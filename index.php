<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);




define("BASEPATH",TRUE);




//ob_start();
session_start();

require __DIR__ . '/config.php';
require __DIR__ . '/database.php';
require __DIR__ . '/model.php';
require __DIR__ . '/controller.php';
require __DIR__ . '/route.php';





Route::run('/static/{tag}',"staticpages@index","get");

Route::get('/yardim-sss',"staticpages@yardim");

Route::run('/settings/?',"settings@index","get|post");
Route::run('/settings/{menu}',"settings@route","get|post");

Route::run('/', "main@index","get|post");
Route::run('/password-reset',"main@passwordReset","get|post");
Route::run('/{url}',"main@route","get|post");




Route::run('/user/{user}',"user@index");
Route::run('/user/?',"user@redirect");


/*
Route::run('/profile',"profile@index");
Route::run('/profile/{url}',"profile@route");
*/


Route::run('/api/{tag}',"api@index","post");


Route::default('notfound404');




//Route::run('/uyeler', 'uyeler@index');    





//Route::run('/uyeler', 'uyeler@post', 'post');
//Route::run('/uye/{url}', 'uye@index');
//Route::run('/profil/sifre-degistir', 'profile/changepassword@index');