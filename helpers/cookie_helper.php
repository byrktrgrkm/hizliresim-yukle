<?php 




function _setcookie($key,$value){
    setcookie($key, $value, time()+3600,"/"); // 1 saat; 
}

function _setViewCookie($key,$type = "folder"){
    if($type == "public"){ /**  */
        setcookie($key,"true",time()+600,"/");
    }else{
        setcookie($key,"true",time()+600);
    }
}

function _hascookie($key){
    return isset($_COOKIE[$key]);
}

function _cookie($key){
    return isset($_COOKIE[$key]) ? $_COOKIE[$key] : "";
}

function _delcookie($key){
    setcookie($key, "", time()-3600,"/");
    return true;
}