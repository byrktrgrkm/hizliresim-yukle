<?php



class Comment extends Model{


    public function SetComment($userid,$shareid,$content,$ip = "",$browser = ""){

        $status = $this->from('comment')->insert2([
            "userid"=>$userid,
            "shareid"=>$shareid,
            "content"=>$content,
            "ip"=>$ip,
            "browser"=>$browser
        ]);
        return (bool)$status;
    }

    public function CheckShare($id){
        $status = $this->select('count(*) as total')->from('share')->where('id = '.$id)->getOne();
        return $status['total'] == 1;
    }
    public function get10Comments($shareid){
        $sql = "Select c.id,c.content,c.date,c.userid,u.username,u.avatar from comment c left join user u on c.userid = u.id WHERE c.shareid = '".$shareid."' order by c.id desc limit 10";
        return $this->query($sql)->getAll();
    }
    public function getShareComments($shareid){
        return $this->from('comment')->where('shareid ='.$shareid)->getAll();
    }
    public function shareCommentCount($shareid){
        return (int)$this->select('count(*) as total')->from('comment')->where('shareid = '.$shareid)->getOne()['total'];
    }



}