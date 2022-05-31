<?php 


function current_url(){
    return BASE_URL.'/';
}

function api_url($tag){
    return BASE_URL.'/api/'.$tag;
}

function avatar_url($tag){
    if(is_null($tag) || empty($tag))
        return default_avatar();
    return BASE_URL.'/assets/avatar/'.$tag;
}
function default_avatar(){
    return BASE_URL."/assets/images/resize/ninja-default.png";
}

function share_image($folder,$imgname){
    return SHARE_URL.'/'.$folder.'/'.$imgname;
}

function get_local_image($file){
    return BASE_URL."/assets/images/".$file;
} 

function get_image($file){
    return BASE_URL."/assets/share/".$file;
}

function  base_url($path = ""){
    return current_url().$path;
}

function script_load($name){
    return JS_DIR.'/'.$name;
}
function style_load($name){
    return BASE_URL."/assets/css/".$name;
}



function get($name){
    return isset($_GET[$name]) ? $_GET[$name] : "";
}

function post($name){
    return isset($_POST[$name]) ? htmlspecialchars(trim($_POST[$name])) : ""; 
}
function posts(){
    return $_POST;
}

function files($name){return $_FILES[$name];}

function session($name){
    if(strpos($name,'.')){
        $split = explode('.',$name);
        return isset($_SESSION[$split[0]][$split[1]]) ? $_SESSION[$split[0]][$split[1]] : "";
    }
    return isset($_SESSION[$name]) ? $_SESSION[$name] : ""; 
}
function session_set($tag,$value){
    if(strpos($tag,'.')){

        /**
         * alogrithm
         * user.name.first
         * $_SESSION['user']['name]['first']
         */
        $split = explode('.',$tag);
        $_SESSION[$split[0]][$split[1]] = $value;
    }else{
        $_SESSION[$tag] = $value;
    }
}


function xcsrf_header($token){
    header('x-csrf-token: '.$token);
}

function create_csrf(){
    $token = create_token();
    _setcookie('csrftoken',$token);
    return $token;
}

function create_token(){
    return bin2hex(random_bytes(32));
}




function redirect($name,$seconds = 0){
    if($seconds != 0){
        header('Refresh: '.$seconds.'; url='.current_url($name));
    }
    else{
        header('Location: '.current_url($name));
        exit;
    }
}

