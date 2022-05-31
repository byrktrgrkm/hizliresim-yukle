<?php


defined('BASEPATH') or die('not allowed');



if(session_status() == PHP_SESSION_ACTIVE){
    $_SESSION['token'] = bin2hex(random_bytes(32));
}


define('SYSTEM_DIR',__DIR__.'/system');
define('SYSTEM_DIR_LOG',SYSTEM_DIR.'/log');


define('ASSET_DIR_',__DIR__.'/assets');
define('AVATAR_DIR',ASSET_DIR_.'/avatar');
define('CSS_DIR',ASSET_DIR_.'/css');
define('JS_DIR',ASSET_DIR_.'/js');

define('BASE_URL','http://localhost/hizliresim/mvc');


define('SHARE_URL',BASE_URL.'/image');

define('DB_HOST','localhost');
define('DB_NAME','hizliresim');
define('DB_USERNAME','root');
define('DB_PASSWORD','');

