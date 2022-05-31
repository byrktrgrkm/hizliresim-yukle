<?php

defined('BASEPATH') or die('not allowed');


abstract class SystemTypes{
    public const DB = "DB";
    public const MAIL = "MAIL";
    public const FILE_MOVE = "FILE_MOVE";
    public const INVALID_SHARE_PARAM = "INVALID_SHARE_PARAM";
}


class System extends Model{

    public function AddMessage($action_type,$message){
        return $this->table('system')->insert2([
            "action_type"=>$action_type,
            "message"=>$message
        ]); 
    }


}