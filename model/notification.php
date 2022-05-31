<?php

defined('BASEPATH') or die('not allowed');


abstract class NotificationTypes{
    public const BOOKMARK = 1;
    public const COOMENT = 2;
    public const LIKE = 3;
    public const REPORT = 4;
    public const SYSTEM = 5;
}



class Notification extends Model{

    private $_title = '',$_body = '',$_href = '';

    function AddNotification($notification_type,$sender_id,$recipient_id){

        $r = $this->table('notification')->insert2([
            "sender_id"=>$sender_id,
            "recipient_id"=>$recipient_id,
            "type_of_notification"=>$notification_type,
            'title_html'=>$this->_title,
            'body_html'=>$this->_body,
            'href'=>$this->_href
        ]);

        $this->clearProperties();

        return $r;
    }

    function IsReadNotification($notification_type,$sender_id,$recipient_id){
        return ($this->select('is_read')->table('notification')
        ->where([
            "sender_id"=>$sender_id,
            "recipient_id"=>$recipient_id,
            "type_of_notification"=>$notification_type,
            "is_hidden"=>0
        ])
        ->getOne()['is_read']) == 1 ;
    }

    public function HideNotification($notification_type,$sender_id,$recipient_id,$href){

        return $this->table('notification')->where([
            "type_of_notification"=>$notification_type,
            "sender_id"=>$sender_id,
            "recipient_id"=>$recipient_id,
            "href"=>$href,
            "is_read"=>0
        ])->set("is_hidden",1)->update2();


    }




    public function _title($title){
        $this->_title = $title;
    }
    public function _body($body){
        $this->_body  = $body;
    }
    public function _href($href){
        $this->_href = $href;
    }


    private function clearProperties(){
        $this->_title = "";
        $this->_body = "";
        $this->_href = "";
    }






}