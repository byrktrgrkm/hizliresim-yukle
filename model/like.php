<?php



class Like extends Model{

    public $_mtable = "likes";

    public function checkUser($shareid,$userid){
        return !empty($this->from($this->_mtable)->where(["shareid"=>$shareid,"userid"=>$userid])->getOne());
    }

    public function delUser($shareid,$userid){
        return (bool) $this->from($this->_mtable)->where(["shareid"=>$shareid,"userid"=>$userid])->del();
    }
    public function setUser($shareid,$userid){
        return (bool)$this->from($this->_mtable)->set(["shareid"=>$shareid,"userid"=>$userid])->insert();
    }
    
}