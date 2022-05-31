<?php


class Image extends Model{

    public $errorMessage;

    public function getSaveId($slug,$userid,$content,$isPass,$password,$folder_name,$broadcast,$total_byte){

  
        $response = $this->from("share")->insert2([
            "slug"=>$slug,
            "userid"=>$userid,
            "content"=>$content,
            "isPass"=>$isPass,
            "password"=>$password,
            "folder"=>$folder_name,
            "broadcast_type"=>$broadcast,
            "total_byte"=>$total_byte
        ]);

        if($response){
            return $this->db->lastInsertId();
        }else {return 0;}
    }
    public function saveImage($share_id,$path){

        $response = $this->from('collective')->insert2([
            "shareid"=>$share_id,
            "image"=>$path
        ]);

        if($response){
            return true;
        }

        return false;

    }

    public function getImageData($slug,$pass = ""){
        $response = [];
        $share = $this
        ->query("SELECT s.*,u.username FROM share s left join user u on s.userid = u.id WHERE s.slug = '".$slug."'" .(!empty($pass) ? " and s.password = '".$pass."'" : "") )
        ->getOne();
        if($share){
            $images = $this->from('collective')->where('shareid = '.$share['id'])->getAll();
            if($images){
                
                $response["share"] = $share;
                $response["images"] = $images;
                $response['comments']=["totalCount"=>0];
                $response['viewsCount'] = $share['views'];
                $response['folder'] = $share['folder'];
                
                $response['bookmarksCount'] = $this->BookMarksCount($share['id']);
                $response['likesCount'] = $this->LikesCount($share['id']);
            } 
        }
        return $response;
    }

    public function BookMarksCount($shareid){
        return ($this->select('count(*) as total')->from('bookmark')->where('shareid',$shareid)->getOne()['total']);
    }
    public function LikesCount($shareid){
        return ($this->select('count(*) as total')->from('likes')->where('shareid',$shareid)->getOne()['total']);
    }

    public function AccessImageData($slug,$password){


        $count = $this
        ->from('share')
        ->where('slug = "'.$slug.'" and password = "'.$password.'"')->getOne();

        if($count){

            $data = $this->getImageData($slug,$password);
            if($data)
                return ["status"=>true,"data"=>$data];
            else return ["status"=>false,"message"=>"Kayıt bulunamadı."];
        }else{
            return ["status"=>false,"message"=>"asdadsa"];
        }

    }


    public function getReportImageItems(){
        return ($this->from('share_report_type')->getAll());
    }
    public function setReportImage($shareid,$userid,$typeid,$content,$ip,$browser){

        if($this->from('share_report')->insert2(Array(
            "shareid"=>$shareid,
            "userid"=>$userid,
            "typeid"=>$typeid,
            "content"=>$content,
            "ip"=>$ip,
            "browser"=>$browser
        ))){
            return $this->db->lastInsertId();
        }
        return 0;
    }
    public function setView($shareid){
       return ($this->table('share')->set('views = views + 1')->where('id',$shareid)->update2());
    }   
    public function reportCheckSid($sid){
        return !empty($this->from('share')->where('id = "'.$sid.'"')->getOne());
    }
    public function reportCheckTypeid($typeid){
        return !empty($this->from('share_report_type')->where('id',$typeid)->getOne());
    }
    public function userCheckid($id){
        return !empty($this->from('user')->where('id',$id)->getOne());
    }
    public function slugCheck($slug){
        return !empty($this->from('share')->where('slug',$slug)->getOne());
    }
    public function GetBroadCastTypes()
    {
        return $this->from('share_broadcast')->getAll();
    }

    public function HasBroadCastTypeId($id){
        return !empty($this->from('share_broadcast')->where('id',$id)->getOne());
    }
    public function GetBasicShareData($share_id){
        return $this->from('share')->where('id',$share_id)->getOne();
    }



}