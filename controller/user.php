<?php


defined('BASEPATH') OR exit('No direct script access allowed');



class User extends Controller{

    
    /**
     * 
     *  rank[status] list 
     *     0 => not verified account
     *     1 => verified account
     *     2 => freezing account
     *     3 => Ban account
     *     4 => remove itself account
     * 
     *     9 => Admin account
     * 
     * 
     */

    const USER_AUTH = [
        'NOT_VERIFIED'=>0,
        'VERIFIED'=>1,
        'FREEZING'=>2,
        'BAN'=>3,
        'REMOVEITSELF'=>4,
        'ADMIN'=>9
    ];

    private $menuler;
    private $default_menu = 'posts';

    private $messages = [];


    private $userProfile;
    private $userModel;

    public function __construct(){
        parent::__construct();

        $this->helper('url');

        $this->menuler = [

            "posts"=>[
                "menu"=>[
                    "icon"=>"fas fa-file",
                    "name"=>"Postlar"
                ],
                "method"=>"posts",
                "scripts"=>[],
                "css"=>[]
            ],
            "bookmarks"=>[
                "menu"=>[
                     "icon"=>"fas fa-bookmark",
                     "name"=>"Yer imleri"
                ],
                "method"=>"bookmarks",
                "scripts"=>[],
                "css"=>[]  
            ],
            "comments"=>[
                "menu"=>[
                    "icon"=>"far fa-comments",
                    "name"=>"Yorumlar"
                ],
                "method"=>"comments",
                "scripts"=>[],
                "css"=>[]
            ],
            "likes"=>[
                "menu"=>[
                     "icon"=>"fas fa-heart",
                     "name"=>"Beğeniler"
                ],
                "method"=>"likes",
                "scripts"=>[],
                "css"=>[]  
             ],

        ];

    }

    public function index($username){

        // Tab yoksa default menu göster
        // Tab değeri var olup ilgili key yoksa yine default göster.


        preg_match('([a-zA-Z0-9]+)',$username,$matches);

        if(empty($matches[0])){
            redirect('index');
        }
        $username = $matches[0];



        $this->userModel = $this->model('users');

        if(!$this->userModel->availableUsername($username)){
            $this->user_not_found();
            exit;
        }


        $this->userProfile = $this->userModel->getUserProfile($username);

        if( ! ($this->userProfile['status'] == self::USER_AUTH['VERIFIED'] || $this->userProfile['status'] == self::USER_AUTH['ADMIN']) ){
            $this->user_not_found();
        }


        $this->userProfile['avatar'] = empty($this->userProfile['avatar']) ? default_avatar() : avatar_url($this->userProfile['avatar']); 
        $this->userProfile['auth'] = session('oturum') && session('user')['id'] == $this->userProfile['id'];
        $this->userProfile['admin'] = $this->userProfile['status'] == self::USER_AUTH['ADMIN'];


        


        $tab = trim(get('tab'));

        if(empty($tab) || !key_exists($tab,$this->menuler)){
            $tab = $this->default_menu;
        }
        $this->route($tab);

    }

    private function active_menu($menu){
        $this->menuler[$menu]['active'] = true;
    } 
    private function route($menu){

        $this->active_menu($menu);

        $exact['menuler'] = $this->menuler;
        $exact['userProfile'] = $this->userProfile;


        $custom['data'] = [];
        if(isset($this->menuler[$menu]['method']) && method_exists($this,$this->menuler[$menu]['method'])){
            $methodName = $this->menuler[$menu]['method'];
            $custom['data'] = $this->$methodName();
            $custom['messages'] = $this->messages;
        }
        $exact['data'] = $this->template('user/'.$menu,$custom);


        $this->view('template/header');
        $this->view('user/template',$exact);
        $this->view('template/footer');
    }



    private function posts(){

        
        $userProperty = $this->userModel->getProperty('secrecy',$this->userProfile['id']);
        

        $userProperty = json_decode($userProperty,true);


        $userID = session('oturum')  ? session('user')['id'] : -1; 

        if( 
            isset($userProperty['posts_public_show']) && 
            $userProperty['posts_public_show'] == '0' &&
            ($userID != $this->userProfile['id']) &&  
            $this->userProfile['status'] != self::USER_AUTH['ADMIN']
        ){
        
            $this->message('Paylaşılanları görmeniz <b>'.$this->userProfile['username'].'</b> tarafından kısıtlanmıştır.','info');
            
        }else{

            $checkisAccount = $userID == $this->userProfile['id'];
            $data['posts'] = $this->userModel->getUserPosts($this->userProfile['id'],$checkisAccount);

            $this->helper('time');

            foreach($data['posts'] as &$post){
                $post['share_date'] = time_elapsed_string($post['share_date']);
                $post['image'] = share_image($post['folder'],$post['image']);
                if(empty($post['content']))
                    $post['content'] = 'Bir açıklama yapılmamış.';
            }

            if(count($data['posts']) == 0){

                if($userID == $this->userProfile['id']){
                    $this->message('Hiç yer paylaşımınız bulunmuyor.','secondary');
                }else{
                    $this->message('<b>'.$this->userProfile['username'].'</b> isimli kullanıcının paylaşımı bulunmuyor.','secondary');
                }
            }
           
            return $data;

        }
    
        
    }

    private function bookmarks(){

        $userProperty = $this->userModel->getProperty('secrecy',$this->userProfile['id']);
        
        $userProperty = json_decode($userProperty,true);


        $userID = session('oturum')  ? session('user')['id'] : -1;

        if( 
            isset($userProperty['bookmarks_public_show']) && 
            $userProperty['bookmarks_public_show'] == '0' &&
            ($userID != $this->userProfile['id']) &&  
            $this->userProfile['status'] != self::USER_AUTH['ADMIN']
        ){
        
            $this->message('Yer imlerini görmeniz '.$this->userProfile['username'].' tarafından kısıtlanmıştır.','info');
            
        }else{

            $data['posts'] = $this->userModel->getUserBookmarks($this->userProfile['id']);

            $this->helper('time');

         
            foreach($data['posts'] as &$post){
                $post['date'] = time_elapsed_string($post['date']);
                $post['image'] = get_image($post['image']);
                $post['avatar'] = empty($post['avatar']) ? default_avatar() : avatar_url($post['avatar']);
                if(empty($post['content']))
                    $post['content'] = 'Bir açıklama yapılmamış.';
            }
           
            if(count($data['posts']) == 0){
                if($userID == $this->userProfile['id']){
                    $this->message('Hiç yer iminiz bulunmuyor.','secondary');
                }else{
                    $this->message('<b>'.$this->userProfile['username'].'</b> isimli kullanıcının yer imleri bulunmuyor.','secondary');
                }
            }
            

            return $data;

        }
    }

    private function comments(){
        $userProperty = $this->userModel->getProperty('secrecy',$this->userProfile['id']);
        
        $userProperty = json_decode($userProperty,true);


        $userID = session('oturum')  ? session('user')['id'] : -1;

        if( 
            isset($userProperty['comment_public_show']) && 
            $userProperty['comment_public_show'] == '0' &&
            ($userID != $this->userProfile['id']) &&  
            $this->userProfile['status'] != '9'
        ){
        
            $this->message('Yorumları görmeniz <b>'.$this->userProfile['username'].'</b> tarafından kısıtlanmıştır.','info');
            
        }else{

            $posts = $this->userModel->getUserComments($this->userProfile['id']);
            $data['posts'] = [];
            $this->helper('time');
            foreach($posts as $post){
                $post['date'] = time_elapsed_string($post['date']);
                $post['content'] = strlen($post['content']) > 100 ?  substr($post['content'],0,100).'..' : $post['content'];
                $post['image'] = get_image($post['image']);
                $post['avatar'] = empty($post['avatar']) ? default_avatar() : avatar_url($post['avatar']);
                $data['posts'][$post['shareid']][] = $post;
            }
            if(count($data['posts']) == 0){
                if($userID == $this->userProfile['id']){
                    $this->message('Yorumunuz  bulunmuyor.','secondary');
                }else{
                    $this->message('<b>'.$this->userProfile['username'].'</b> isimli kullanıcının yorumu bulunmuyor.','secondary');
                }
            }

            return $data;
        }
    }

    private function likes(){
        $userProperty = $this->userModel->getProperty('secrecy',$this->userProfile['id']);
        
        $userProperty = json_decode($userProperty,true);


        $userID = session('oturum')  ? session('user')['id'] : -1;

        if( 
            isset($userProperty['likes_public_show']) && 
            $userProperty['likes_public_show'] == '0' &&
            ($userID != $this->userProfile['id']) &&  
            $this->userProfile['status'] != '9'
        ){
        
            $this->message('Beğenileri görüntülemeniz <b>'.$this->userProfile['username'].'</b> tarafından kısıtlanmıştır.','info');
            
        }else{

            $data['posts'] = $this->userModel->getUserLikes($this->userProfile['id']);
        
            $this->helper('time');
            foreach($data['posts'] as &$post){
                $post['date'] = time_elapsed_string($post['date']);
                $post['content'] = strlen($post['content']) > 100 ?  substr($post['content'],0,100).'..' : $post['content'];
                $post['image'] = get_image($post['image']);
                $post['avatar'] = empty($post['avatar']) ? default_avatar() : avatar_url($post['avatar']);
            }

            if(count($data['posts']) == 0){

                if($userID == $this->userProfile['id']){
                    $this->message('Hiç beğeniniz bulunmuyor.','secondary');
                }else{
                    $this->message('<b>'.$this->userProfile['username'].'</b> isimli kullanıcının yorumu bulunmuyor.','secondary');
                }
            }

            return $data;
        }
    }
    public function redirect(){
        redirect('index');
    }


    private function user_not_found(){
        $this->view('template/header');
        $this->view('user/notfound');
        $this->view('template/footer');
        die;
    }


    private function message($msg,$class){
        $this->messages[] = [
            "msg" => $msg,
            "class" => $class
        ];
    }
  

}