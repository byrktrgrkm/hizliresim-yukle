<?php



class Bookmark extends Model{

    public $_mtable = "bookmark";

    public function checkUserBookmark($shareid,$userid){
        return !empty($this->from($this->_mtable)->where(["shareid"=>$shareid,"userid"=>$userid])->getOne());
    }

    public function delUserBookmark($shareid,$userid){
        return (bool) $this->from($this->_mtable)->where(["shareid"=>$shareid,"userid"=>$userid])->del();
    }
    public function setUserBookmark($shareid,$userid){
        return (bool)$this->from($this->_mtable)->set(["shareid"=>$shareid,"userid"=>$userid])->insert();
    }
    
}