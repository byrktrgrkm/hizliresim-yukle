<?php


function like_share_user($username,$profil_href){
    return "<a href='{$profil_href}'>{$username}</a> kullanıcısı paylaşımı beğendi.";
}

function bookmark_share_user($username,$profil_href){
    return "<a href='{$profil_href}'>{$username}</a> kullanıcısı paylaşımınızı kaydetti.";
}