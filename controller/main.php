<?php

class Main extends Controller
{
    

    private $imageModel;

    public function __construct(){
        parent::__construct();
        $this->helper('url');
        $this->helper('cookie');
    }

    public function index()
    {

        $this->imageModel = $this->model('image');

        $data = [];
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $data['result'] = $this->index_post();
        }
       

        if(_hascookie('csrftoken')){
            $data['csrf_token'] = _cookie('csrftoken'); 
        }else{
            $data['csrf_token'] = create_csrf();
        }

        $data['broadcast_types'] = $this->imageModel->GetBroadCastTypes();
        $this->view('template/header');
        $this->view('index',$data);
        $this->view('template/footer');
    }

    public function index_post(){
       
        $data = [];
        if(!_hascookie('csrftoken') || _cookie('csrftoken') != post('csrf')){
            return;
        }


    
        if(! isset($_FILES['file']) || empty($_FILES['file'])){
            $data[] = ["class"=>"danger","message"=>"Resim seçilmedi"];
        }else if($_FILES['file']['error'][0] != 0){
            $phpFileUploadErrors = array(
                0 => 'Dosya yüklendi',
                1 => 'Dosya boyutu çok yüksek',
                2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
                3 => 'Eksik dosya yüklemesi',
                4 => 'Dosya yüklenmedi.',
                6 => 'Missing a temporary folder',
                7 => 'Failed to write file to disk.',
                8 => 'A PHP extension stopped the file upload.',
            );
            $errorCode = $_FILES['file']['error'][0];
            $data[] = ["class"=>"danger","message"=>$phpFileUploadErrors[$errorCode]];
        }else if(count(files('file')['tmp_name']) > 10){
            $data[] = ["class"=>"danger","message"=>"En fazla 10 dosya seçebilirsiniz."];
        }
        else{
            
            $files = files('file');
            $files_count = count($files['tmp_name']);

            // check is image

            for($i = 0; $i < $files_count;$i++){
                if(!@is_array(getimagesize($files['tmp_name'][$i]))){
                    $data[] = ["class"=>"danger","message"=>$files['name'][$i]." geçerli dosya seçiniz."];
                    break;
                }

            }

            if(count($data) == 0){

                $types = ["image/png","image/jpg","image/jpeg"];
                $max = 1024*2024*10;

                for($i = 0; $i < $files_count;$i++){

                    if($files['size'][$i] > $max){
                        $data[] = ["class"=>"danger","message"=>$files['name'][$i]." adlı dosya çok büyük ,en fazla 10 mb olabilir"];
                    }
                    if(!in_array($files['type'][$i],$types)){
                        $data[] = ["class"=>"danger","message"=>$files['name'][$i]." adlı dosya geçersiz formatta (png ,jpg ya da jpeg olabilir)"];
                    }

                }

            }



        }
        
        
        
        
        
        if(count($data) > 0){
            if(isset($_FILES['file'])){
                $files = files('file');
                $files_count = count($files['tmp_name']);

                for($i = 0; $i < $files_count;$i++){

                    if(!empty($files['tmp_name'][$i])) {
                        $filename = str_replace("\\","\\\\",$files['tmp_name'][$i]);
                        
                        unlink($filename);
                    }
                    
                }
            }
            
            return ["status"=>"error","data"=>$data];
        }
        
        //$imageModel = $this->model('image');
        $this->helper('string');

        $check = post('check');
        $content = post('content');
        
        $try_count = 0;
        $try_max = 10;
        do{
            if($try_count >= 1 ){
                $this->system_log(SystemTypes::DB,'Slug kontrolü yinelendi.');
            }
            $slug = RandomString(6);
            $slug_already_registery = $this->imageModel->slugCheck($slug);
            $try_count++;
            if($try_count == $try_max){
                $this->system_log(SystemTypes::DB,'Slug 10 denemede başarısız kaldı.');
                $data[] = ["class"=>"danger","message"=>"Sistemde hata meydana geldi."];
                return ["status"=>"error","data"=>$data];
            }
        }while($slug_already_registery && $try_count <= $try_max);

       


        $userid = session("oturum") ? session('user')['id'] : 0;
        $isPass = $check == "on";
        $password = "";

        if($isPass) $password = sha1(md5(post('password')));
    
        $folder_name = substr(md5(date("Ym")),0,8);   

        if($this->imageModel->HasBroadCastTypeId(post('broadcast'))){
           $broadcast = post('broadcast'); 
        }else{
            $broadcast = 0;
        }

        $files = files('file');
        $files_count = count($files['tmp_name']);

        $totalbyte = 0;
        for($i = 0; $i < $files_count;$i++){
            $totalbyte += $files['size'][$i];
        }

        
        $id = $this->imageModel->getSaveId($slug,$userid,$content,$isPass,$password,$folder_name,$broadcast,$totalbyte);

        if($id){


            /*
                yıl-ay 202008 biçiminde klasör oluştur.
            */
           
           $folder_path = dirname(__DIR__)."\\assets\\share\\".$folder_name;
           if(!is_dir($folder_path)) mkdir($folder_path);
           

            
            $imageList = [];

            for($i = 0; $i < $files_count;$i++){

                $ext = pathinfo($files["name"][$i], PATHINFO_EXTENSION);
                $image_name = md5(RandomString(12).$id).".".$ext;
                
                $imageList[] = $folder_name . '\\'.$image_name;
            
                $new_path = $folder_path."\\".$image_name;
                
                
                $move = move_uploaded_file($files["tmp_name"][$i],$new_path);
                if($move){
                        $n = $this->imageModel->saveImage($id,$image_name);
                        
                        if(!$n){
                            $this->system_log(SystemTypes::DB,$this->imageModel->getMessage());
                        }else{
                            create_csrf();
                        }
                }else{
                    
                    $this->system_log(SystemTypes::FILE_MOVE,$files["tmp_name"][$i].' TMP dosyası '.$new_path.' adrese taşınamadı.');
                    //exit;
                }

            }

            return ["status"=>"success","share_image"=>get_image($imageList[0]),"list" => array_map(function($image){ return get_image($image); },$imageList),"slug_image"=>base_url($slug)];

            


        }else{

            $this->system_log(SystemTypes::DB,$this->imageModel->getMessage());
            //$this->imageModel->getMessage();
        }


  
    
    }

    public function route($name){
         if(method_exists($this,$name)){
             $this->$name($name);
         }else{
             $this->share($name);
         }
    }

    public function share($param){

        
        
        $imageModel = $this->model('image');
       
        $data = $imageModel->getImageData($param);

        

        if(!$data){
            $this->system_log(SystemTypes::INVALID_SHARE_PARAM,'Geçersiz parametre : '.$param);
            redirect('/');
            die;   
        }
        
        $this->helper('time');
      
        //

        if(!_hascookie('hit'.$data['share']['id'])){

          
            if($imageModel->setView($data['share']['id'])){

                _setViewCookie('hit'.$data['share']['id'],'folder');
            }else{
               //$imageModel->errorMessage;
            }
        }



        $data['isLogin'] = session('oturum');

        $commentModel = $this->model('comment');
        $bookmarkModel = $this->model('bookmark');
        $likeModel = $this->model('like');

        $data['isBookChecked'] = session('oturum') && $bookmarkModel->checkUserBookmark($data['share']['id'],session('user')['id']);
        $data['isLikeChecked'] = session('oturum') && $likeModel->checkUser($data['share']['id'],session('user')['id']);
        $data['reportItems'] = $imageModel->getReportImageItems();
        $data['comments']['totalCount']  = $commentModel->shareCommentCount($data['share']['id']);
        $tencomment = $commentModel->get10Comments($data['share']['id']);

        foreach($tencomment as $key => $value){
            if($tencomment[$key]["userid"] == 0)
                $tencomment[$key]["username"] = "Anonim";

            $tencomment[$key]["date"] = time_elapsed_string($tencomment[$key]["date"]);
            $tencomment[$key]['avatar'] = avatar_url($tencomment[$key]['avatar']);
        }

        $data['comments']['data'] = $tencomment;
        if($data['share']['userid'] == 0) $data['share']['username'] = 'Anonim'; 

        
        
        $data['share']['is_my_image'] = session('oturum') &&  $data['share']['userid'] == session('user')['id'];  
         


        $data["token"]["csrftoken"] = "";
        if($data['share']['isPass'] == true &&  ! $data['share']['is_my_image']){
            $data['share']['username'] = 'Gizli';
            $data["token"]["csrf"] = md5(rand(10,6666));
            _setcookie('csrf',$data["token"]["csrf"]);
            
        }else{
             $data["token"]["csrftoken"] = _hascookie('csrftoken') ? _cookie('csrftoken') : md5(rand(10,6666));
            _setcookie('csrftoken',$data["token"]["csrftoken"]); // for comments
        }


        $this->view('template/header');
        $this->view('share',$data);
        $this->view('template/footer');

    }

    public function logout()
    {
        $key = get('key');
        # code...

        if(!empty($key) && $key == session('user.token')){
            session_destroy();
        }
        
        redirect("index");
    }
    public function login($name){


        if(session("oturum")){
            redirect('index');
            die;
        }
        
        $data = [];
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $data['result'] = $this->login_post();
        }

        $this->view('template/header');
        $this->view($name,$data);
        $this->view('template/footer');
    }
    public function login_post(){

        $usersModel = $this->model('users');
        $username = post("email");
        $password = post("password");
        
        $result = [];


        if(empty($username) || empty($password)){
            return;// ["message"=>"Kullanıcı adı boş olamaz","class"=>"info"];
        }
        $password = sha1(md5($password));;

        $response = $usersModel->login($username,$password);

        if($response){
  
            session_set('oturum',true);
            session_set('user.username',$response['username']);
            session_set('user.mail',$response['mail']);
            session_set('user.id',$response['id']);
            session_set('user.avatar',$response['avatar']);
            session_set('user.token',create_token());

            redirect('index');
        }else{

            return ["message"=>"Kullanıcı adı veya şifre yanlış!","class"=>"danger"];
        }
        

    }
    public function register($name)
    {
        if(session("oturum")){
            redirect('index');
            die;
        }
        $data = [];

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $data['result'] = $this->register_post();
        }
        # code...
        $this->view('template/header');
        $this->view($name,$data);
        $this->view('template/footer');

    }
    public function register_post(){

         $usersModel = $this->model('users');
         $username = post("username");
         $email = post("email");
         $password = post("password");
         $password_again = post("password_again");
         
         $results = [];
 
         
 
         if(empty($username)){
             $results[] = ["message"=>"Kullanıcı adı boş olamaz","class"=>"info"];
         }
         if(empty($email)){
            $results[] = ["message"=>"Email adresi boş olamaz","class"=>"info"];
         }
         if(empty($password) || empty($password_again)){
            $results[] = ["message"=>"Şifre alanı boş olamaz","class"=>"info"];
         }
         if($password != $password_again){
            $results[] = ["message"=>"Şifreler biribiriyle eşleşmedi.","class"=>"info"];
         }

         if(count($results) > 0){
            return $results; 
         }

         $response = $usersModel->register($email,$username,$password);
 
         if($response){
             redirect("index",3);
             $results[] = ["message"=>"Kayıt olduğunuz için teşekkürler.","class"=>"success"];
         }else{
             $results[] = ["message"=>"Yönetici ile iletişime geçin.","class"=>"danger"];
         }

         return $results;

    }

    public function passwordReset(){
        if(session("oturum")){
            redirect('index');
            die;
        }
        
        $data = [];
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $data['result'] = $this->passwordResetPost();
        }

        $this->view('template/header');
        $this->view('password-reset',$data);
        $this->view('template/footer');
    }
    private function passwordResetPost(){
        $mail = post('email',true);

        if(empty($mail)):
            $results[] = ["message"=>"Mail adresi boş olamaz","class"=>"danger"];
        elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)):
            $results[] = ["message"=>"Geçersiz Mail adresi","class"=>"danger"];
        else:


        $usersModel = $this->model('users');

        $data = $usersModel->find("mail",$mail);

        if($data):

            $results[] = ["message"=>"Şifre sıfırlama bağlantınız mail adresinize gönderildi.","class"=>"success"];
        else:

            $results[] = ["message"=>"Böyle bir mail adresi sisteme kayıtlı değil.","class"=>"danger"];
        endif;




        endif;
       
        return $results;
    }


}