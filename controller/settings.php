<?php


defined('BASEPATH') OR exit('No direct script access allowed');


class Settings extends Controller{


    public $menuler;
    public $default_menu = "profile-edit";


    public $messages = [];

    private $userID;


    public function __construct(){

        parent::__construct();

        $this->helper('url');


        empty(session('oturum')) && ( redirect('index') || die() );


        $this->userID = session('user')['id'];

   
        /**
         * current true
         */
        $this->menuler = [

            "profile-edit"=>[
                "menu"=>[
                    "icon"=>"fas fa-user-edit",
                    "name"=>"Profili Düzenle"
                ],
                "method"=>"profileEdit",
                "scripts"=>[],
                "css"=>[]
            ],
            "secrecy"=>[
                "menu"=>[
                     "icon"=>"fas fa-user-secret",
                     "name"=>"Gizlilik Ayarları"
                ],
                "method"=>"secrecy",
                "scripts"=>[],
                "css"=>[]  
            ],
            "notification"=>[
                "menu"=>[
                    "icon"=>"far fa-bell",
                    "name"=>"Bildirimler"
                ],
                "method"=>"notification",
                "scripts"=>[],
                "css"=>[]
            ],
            "account-edit"=>[
                "menu"=>[
                     "icon"=>"fas fa-edit",
                     "name"=>"Hesap Ayarları"
                ],
                "method"=>"accountEdit",
                "scripts"=>[],
                "css"=>[]  
             ],

        ];


    }


    public function index(){
        $this->route($this->default_menu);
    }

    public function active_menu($menu){
        $this->menuler[$menu]['active'] = true;
    }

    public function route($menu){

        $menu = trim($menu);

        if(key_exists($menu,$this->menuler)){
            
            $this->active_menu($menu);
            $exact['menuler'] = $this->menuler;

            $custom['data'] = [];
            if(isset($this->menuler[$menu]['method']) && method_exists($this,$this->menuler[$menu]['method'])){
                $methodName = $this->menuler[$menu]['method'];
                $custom['data'] = $this->$methodName();
                $custom['messages'] = $this->messages;
            }

            $exact['data'] = $this->template('settings/'.$menu,$custom);
            $this->view('template/header');
            $this->view('settings/template',$exact);
            $this->view('template/footer');    
        }else{
            $this->route($this->default_menu);
        }

    }

    private function profileEdit(){
        /**Geçici çözüm */
        $userModel = $this->model('users');

        if($_SERVER['REQUEST_METHOD'] == "POST") $this->profileEdit_post($userModel);

        $profile = $userModel->getProfile();
        $profile['avatar'] = empty($profile['avatar']) ? default_avatar() : avatar_url($profile['avatar']);
        $profile['firstName'] ="";
        $profile['lastName'] = "";
        if(strpos($profile['name'],' ')){
           $names = explode(' ',$profile['name']);
           $profile['firstName'] = $names[0];
           $profile['lastName'] = $names[1];
        }
        return $profile;
    }
    private function profileEdit_post($userModel){

        $firstname = post('firstname');
        $lastname = post('lastname');
        $username = post('username');
 
        
        $namePattern = '/^[a-zA-zİŞÇÖĞÜışçöüğ]+$/';
        $usernamePattern = '/^[a-zA-Z]+[a-zA-Z0-9_]+$/';

        $avatarPattern = '/^image\/[a-zA-Z]+$/';


        $avatar = $_FILES['avatar'];

       
        if($avatar['error'] == 0){

            if(!preg_match($avatarPattern,$avatar['type'])){
                $this->message('Resim türü belirtilen formatta değil.',"danger");
                unset($avatar['tmp_name']);
            }else{

                $this->helper('file');
                $this->helper('string');

                $avatar_name = randomMd5(12).'.jpg';
                $source_avatar_path = base_upload_path("avatar/".$avatar_name);
                avatar_resizeImage($avatar['tmp_name'],$source_avatar_path,100,100);

                $old_avatar_name = $userModel->getAvatar($this->userID);

            

                if($userModel->saveAvatar($this->userID,$avatar_name)){
                    
                    $old_avatar_path = base_upload_path("avatar/".$old_avatar_name);
                    unlink($old_avatar_path);
                    session_set('user.avatar',$avatar_name);
                    $this->message('Resim güncellendi',"success");
                }else{
                    $this->message('Resim güncellenemedi,lütfen daha sonra tekrar deneyin.',"danger");
                }



                
            }
        }


        if(empty($firstname) || empty($lastname) || empty($username)){
            $this->message('Boş alan bırakmayınız',"info");
        }else if(!preg_match($namePattern,$firstname)){
            $this->message('İsim geçersiz karakterler içeriyor',"danger");
        }else if(!preg_match($namePattern,$lastname)){
            $this->message('Soyisim geçersiz karakterler içeriyor',"danger");
        }else if(!preg_match($usernamePattern,$username)){
            $this->message('Kullanıcı adı geçersiz karakterler içeriyor.<br> Türkçe karakter kullanmayınız',"danger");
        }else if($username != session('user')['username'] && $userModel->availableUsername($username)){
            $this->message('Böyle bir kullanıcı adı mevcut.',"danger");
        }else{
            //mail adresini değiştirme kapalı
            $name = $firstname.' '.$lastname;
            if($userModel->saveProfile(session('user')['id'],$name,$username)){
                session_set("user.username",$username);
                $this->message('Değişiklikler başarılı şekilde kaydedildi.','success');
            }else{
                $this->message('Bir sorun oluştu lütfen daha sonra tekrar deneyin.','danger');
            }
            
        }

    }


    private function accountEdit(){
        if($_SERVER['REQUEST_METHOD'] == "POST") $this->accountEdit_post();
    }

    private function accountEdit_post(){
        
        $current_pass = post('current_password');
        $password = post('password');
        $password2 = post('password2');

        if(empty($current_pass) || empty($password) || empty($password2)){
            $this->message('Gerekli alanları doldurunuz.','info');
        }else if(strlen($password) < 6 || strlen($password) > 20){
            $this->message('Şifreniz 6 karakterden kısa , 20 karakterden uzun olamaz','danger');
        }else if($password != $password2){
            $this->message('Şifreler eşleşmiyor,lütfen dikkatli giriniz.','danger');
        }else{

            $userModel = $this->model('users');

            $current_pass = sha1(md5($current_pass));

            $id = session('user')['id'];

            if($userModel->checkPassword($id,$current_pass)){

                $password = sha1(md5($password));

                if($userModel->changePassword($id,$password)){
                    $this->message('Şifreniz değiştirilmiştir,güncel şifrenizle tekrar giriş yapabilirsiniz.','success');
                }else{
                    $this->message('Şifre değiştirme işlemi başarısız,lütfen daha sonra tekrar deneyiniz.','danger');
                }


            }else{
                $this->message('Lütfen mevcut şifrenizi doğru giriniz.','danger');
            }

        }



    }

    private function secrecy(){

        $security = [
            "picture_public_show" => 1,
            "comment_public_show" => 1,
            "likes_public_show"   => 1,
            "bookmarks_public_show" => 1,
            "posts_public_show" => 1,
            "posts_comment_do" => 1
        ];
 
        $userModel = $this->model('users');
        if($_SERVER['REQUEST_METHOD'] == "POST") $this->secrecy_post($security,$userModel);

        $data['property'] = $userModel->getProperty('secrecy',$this->userID);
        if(!empty($data['property'])){
            $data['property'] = json_decode($data['property'],true);

            foreach($security as $property => $value){
                if( ! key_exists($property,$data['property']) ){
                    $data['property'][$property] = $value;
                }
            }

        }else{
            $data['property']= $security;
        }

        return $data;

    }

    private function secrecy_post($security,$userModel){

        $settings = [];
        foreach($security as $setting => $value){
            if(!empty(post($setting)) &&  post($setting) == "on"){
                $settings[$setting] = 1;
            }else{
                $settings[$setting] = 0;
            }
        }

        $settings = json_encode($settings);
        if($userModel->setProperty('secrecy',$settings,$this->userID)){
            $this->message('Değişiklikler kaydedildi','success');
        }else{
            $this->message('Değişiklikler kaydedilemedi,lütfen daha sonra tekrar deneyin.','danger');
        }


    }

    private function notification(){
        $security = [
            "get_all_notification" => 0,
            "get_mail_important_notification" => 0
        ];

        $userModel = $this->model('users');
        if($_SERVER['REQUEST_METHOD'] == "POST") $this->notification_post($security,$userModel);

        $data['property'] = $userModel->getProperty('notification',$this->userID);
        if(!empty($data['property'])){
            $data['property'] = json_decode($data['property'],true);
        }else{
            $data['property']= $security;
        }

        return $data;
 
    }
    private function notification_post($security,$userModel){

        $settings = [];
        foreach($security as $setting => $value){
            if(!empty(post($setting)) &&  post($setting) == "on"){
                $settings[$setting] = 1;
            }else{
                $settings[$setting] = 0;
            }
        }

        $settings = json_encode($settings);
        if($userModel->setProperty('notification',$settings,$this->userID)){
            $this->message('Değişiklikler kaydedildi','success');
        }else{
            $this->message('Değişiklikler kaydedilemedi,lütfen daha sonra tekrar deneyin.','danger');
        }
    }





    private function message($msg,$class){
        $this->messages[] = [
            "msg" => $msg,
            "class" => $class
        ];
    }

}