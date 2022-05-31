<?php


class Api extends Controller{


    private $errors = [];
    private $return;

    public function __construct(){

        parent::__construct();
        $this->return = [];
        $this->return['state'] = "error";
    }



    public function index($param){


        $param = str_replace("-","",$param);
        if(method_exists($this,$param)){
            return $this->$param();
        }

        return $this->AuthError();
    }

    private function accessimage(){
        
        $this->helper('url');
        $this->helper('cookie');
   
        $csrf = post('csrf');
        $pass = post('password');
        $slug = post('slug');

       
        if(empty($csrf) || empty(_cookie('csrf'))){
            $this->errors[] =  "CSRF required";  
        }else if($csrf != _cookie('csrf')){
            $this->erros[] = "Csrf error";
        }
        if(empty($slug)){
            $this->errors[] = "SLUG must required";
        }

        if(count($this->errors) > 0){
            $this->return['response'] = 'Hatalı istek!';
        }else{

            $pass = sha1(md5($pass));

            $imageModel = $this->model('image');

            $result = $imageModel->AccessImageData($slug,$pass);

            if($result['status'] == true){

                foreach($result['data']['images'] as $key => $im){

                    $path = share_image($result['data']['folder'],$im['image']);
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    $result['data']['images'][$key]["image"] = $base64;
                }

               
                $this->helper('time');

                $commentModel = $this->model('comment');
                $result['data']['comments']['totalCount'] = $commentModel->shareCommentCount($result['data']['share']['id']);
                if($result['data']['comments']['totalCount'] == 0 ) $result['data']['comments']['noComment'] = '<div class="alert text-small">Yorum bulunamadı, ilk yazan sen ol!</div>'; 
                $comments = $commentModel->get10Comments($result['data']['share']['id']);

                foreach($comments as $key => $value){
                    if($comments[$key]["userid"] == 0)
                        $comments[$key]["username"] = "Anonim";

                    $comments[$key]["date"] = time_elapsed_string($value["date"]);
                    if($comments[$key]["userid"] == 0 || empty($comments[$key]["image"]))
                        $comments[$key]["image"] = default_avatar();
                    else
                        $comments[$key]["image"] = avatar_url($value['image']);

                    unset($comments[$key]["userid"]);
                }

                $result['data']['comments']['data'] = $comments; 

                $token = _hascookie('csrftoken') ? _cookie('csrftoken') :  md5(rand(10,6666));
                _setcookie('csrftoken',$token);

                $this->return['state'] = 'success';
                $this->return['response'] = [
                    "share"=>[
                        "slug"=>$result['data']['share']['slug'],
                        "username"=>$result['data']['share']['userid'] == 0 ? "Anonim" : $result['data']['share']['username'],
                        "content"=> empty($result['data']['share']['content']) ? "<div class='alert alert-info'>Açıklama belirtilmemiş</div>" : $result['data']['share']['content'],
                        "share_date"=>time_elapsed_string($result['data']['share']['share_date'])
                    ],
                    "images"=>$result['data']['images'],
                    "comments"=>$result['data']['comments'],
                    "viewsCount"=>$result['data']['viewsCount'],
                    "bookmarks"=>$result['data']['bookmarksCount'],
                    "likes"=>$result['data']['likesCount'],
                    "token"=>$token
                ];

            }else{
                $this->return['state'] = 'error';
                $this->return['message'] = 'Şifre hatalı!';
            }
            

        }
  
    }

    public function commentpost(){

        
        $this->helper('url');
        $this->helper('cookie');
        

        
        $csrf = post('csrf');
        $comment = post('comment');
        $shareid = post('id');
        $cookie_csrf = _cookie('csrftoken');


        if(empty($csrf) || empty( $cookie_csrf)){
            $this->errors[] = "Csrf required";
        }else if($csrf !=  $cookie_csrf){
            $this->errors[] = "Invalid token:csrf ->". $cookie_csrf . " \n post:csrf " .$csrf."  | main:csrf "._cookie('csrf');
        }elseif(empty($comment) || $comment == ""){
            $this->errors[] = "comment required";
        }else if(strlen($comment) > 1000){
            $this->errors[] = "comment too long";
        }else if(empty($shareid)){
            $this->errors[] = "id required";
        }

        

       

        if(empty($this->errors)){
   
            $commentModel = $this->model('comment');
            
            if($commentModel->checkShare($shareid)){
                $userid = session('oturum') ? session('user')['id'] : 0;
                $status = $commentModel->setComment($userid,$shareid,$comment,"ip",$_SERVER['HTTP_USER_AGENT']);

                if($status){
                    $this->return['state'] = 'success';
                    $this->return['message'] = 'Yorumunuz kaydedilmiştir.';
                }else{
                    $this->errors[] = 'Yönetici ile iletişme geçin yorum gönderilemedi!';
                }

            }else{
                $this->errors[] = 'Invalid id';
            }

        }
    
    }


    public function reportimage(){


        $this->helper('url');
        $this->helper('cookie');

        $return['state'] = 'error';

        $csrf = post('csrftoken');
        $shareid = post('id');
        $typeid = post('typeid');
        $content = post('content');
        $ip = "";
        $browser = $_SERVER['HTTP_USER_AGENT'];

        if(empty($csrf)){
           $this->errors[] = "csrf required"; 
        }else if($csrf != _cookie('csrftoken')){
            $this->errors[] = "csrf invalid"; 
        }else if(empty($shareid) || empty($typeid)){
            $this->errors[] = "shareid and tyepid required";
        }

        if(empty($this->errors)){

            $imageModel = $this->model('image');

            if(!$imageModel->reportCheckSid($shareid)){
                $this->errors[] = "sid invalid";
            }else if(!$imageModel->reportCheckTypeid($typeid)){
                $this->errors[] = "type id not found";
            }else{

                $userid = session('oturum') ? session('user')['id'] : 0;
                if($reportid = $imageModel->setReportImage($shareid,$userid,$typeid,$content,$ip,$browser)){

                    $this->return['state'] = 'success';
                    $this->return['message'] = "Rapor numarası : ".$reportid;

                }else{
                    $this->errors[] = $imageModel->errorMessage;
                }

            }

        

        }

    }

    public function bookmark(){

        $this->helper('url');
        $this->helper('cookie');
        


        $shareid = post('id');
        $csrf = post('csrf');
        
        if(session('oturum')){

            if(empty($shareid)){
                $this->errors[] = "İnvalid shareid";
            }else if(empty($csrf) || $csrf != _cookie('csrftoken')){
                $this->errors[] = "invalid csrf token";
            }else{

                $imageModel = $this->model('image');
                $userid = session('user')['id'];

                if(! $imageModel->userCheckid($userid)){
                    $this->errors[] = "user invalid";
                }else if( ! $imageModel->reportCheckSid($shareid)){
                    $this->errors[] = "share invalid";
                }else{

                    $bookmarkModel = $this->model('bookmark');
                    $shareData = $imageModel->GetBasicShareData($shareid);
                    $notificationModel = $this->model('notification');
                    $check = "";

                    if($bookmarkModel->checkUserBookmark($shareid,$userid)){
                        if($bookmarkModel->delUserBookmark($shareid,$userid)){

                            if($shareData['userid'] != $userid){

                                $notificationModel->_href($shareData['slug']);
                                $href = $shareData['slug'];

                                $response = $notificationModel->HideNotification(
                                    NotificationTypes::BOOKMARK,
                                    $userid,
                                    $shareData['userid'],
                                    $href
                                );
                                if(!$response){
                                    $this->system_log(SystemTypes::DB,'METHOD:API[BOOKMARK]: '.$notificationModel->getMessage());
                                }
                            }

                        }else{
                            $this->system_log(SystemTypes::DB,'METHOD:API[BOOKMARK]: '.$notificationModel->getMessage());
                        }
                        $check = "NOBOOKMARK";
                    }else{

                        if($bookmarkModel->setUserBookmark($shareid,$userid)){

                            if($shareData['userid'] != $userid){

                                if($notificationModel->IsReadNotification(NotificationTypes::BOOKMARK,$userid,$shareData['userid']) == false){

                                    $notificationModel->_href($shareData['slug']);
                                    
                                    $response = $notificationModel->AddNotification(
                                        NotificationTypes::BOOKMARK,
                                        $userid,
                                        $shareData['userid']);
                                    if(!$response){
                                        $this->system_log(SystemTypes::DB,'METHOD:API[BOOKMARK]: '.$notificationModel->getMessage());
                                    }

                                }
                            }
                            
                        }else{

                            $this->system_log(SystemTypes::DB,'METHOD:API[BOOKMARK]: '.$notificationModel->getMessage());

                        }





                        $check = "BOOKMARK";
                    }

                    $this->return['state'] = 'success';
                    $this->return['check'] = $check; 

                }




            }
        }else{
            $this->errors[] = "user invalid";
        }



        
    }

    public function heart(){

        $this->helper('url');
        $this->helper('cookie');
        


        $shareid = post('id');
        $csrf = post('csrf');
        
        if(session('oturum')){

            if(empty($shareid)){
                $this->errors[] = "İnvalid shareid";
            }else if(empty($csrf) || $csrf != _cookie('csrftoken')){
                $this->errors[] = "invalid csrf token";
            }else{

                $imageModel = $this->model('image');
                $userid = session('user')['id'];

                if(! $imageModel->userCheckid($userid)){
                    $this->errors[] = "user invalid";
                }else if( ! $imageModel->reportCheckSid($shareid)){
                    $this->errors[] = "share invalid";
                }else{

                    $shareData = $imageModel->GetBasicShareData($shareid);



                    $like = $this->model('like');
                    $notificationModel = $this->model('notification');
                    $check = "";
                    if($like->checkUser($shareid,$userid)){
                        if($like->delUser($shareid,$userid)){

                            if($shareData['userid'] != $userid){
                                $href = $shareData['slug'];
                                $response = $notificationModel->HideNotification(
                                    NotificationTypes::LIKE,
                                    $userid,
                                    $shareData['userid'],
                                    $href                                        
                                );
                                if(!$response){
                        
                                $this->system_log(SystemTypes::DB,'METHOD:API[HEART]: '.$notificationModel->getMessage());
                                }
                            }

                        }else{
                            $this->system_log(SystemTypes::DB,$like->getMessage());
                        }
                        $check = "NOHEART";
                    }else{
                        if($like->setUser($shareid,$userid)){
                        
                            if($shareData['userid'] != $userid){

                                if($notificationModel->IsReadNotification(NotificationTypes::LIKE,$userid,$shareData['userid']) == false){

                                    $notificationModel->_href($shareData['slug']);
                                    
                                    $response = $notificationModel->AddNotification(
                                        NotificationTypes::LIKE,
                                        $userid,
                                        $shareData['userid']);
                                    if(!$response){
                            
                                    $this->system_log(SystemTypes::DB,'METHOD:API[HEART]: '.$notificationModel->getMessage());
                                    }
                                }
                            }
                        
                        }else{
                            $this->system_log(SystemTypes::DB,'METHOD:API[HEART]: '.$like->getMessage());
                        }
                        $check = "HEART";
                    }

                    $this->return['state'] = 'success';
                    $this->return['check'] = $check; 

                }




            }
        }else{
            $this->errors[] = "user invalid";
        }



        
    }




    private function AuthError(){
        
        echo "Erişim yetkiniz bulunmuyor.";
        exit;
    }

    public function __destruct(){
        if(!empty($this->errors))$this->return['errors'] = $this->errors;
        echo json_encode($this->return);
    }

}