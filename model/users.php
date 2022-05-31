<?php

class Users extends Model {


  
    /**
     * 
     * rank[status] list 
     *     0 => not verified account
     *     1 => verified account
     *     2 => freezing account
     *     3 => Ban account
     *     4 => remove itself account
     * 
     *     9 => Admin account
     * 
     * 
     */


    /**
     * Kullanıcı adı ve şifrenin veritabanından kontrolünü sağlar
     * @var string kullanıcıadı
     * @var string şifre
     * @return boolean Başarılı başarısız durumu
     *  */ 
    public function login($username,$password){

        /*
        $query = "SELECT * FROM user WHERE (username = :u or mail = :m ) and password = :pw";
        $sth = $this->db->prepare($query);
        $sth->execute([
            "u"=>$username,
            "m"=>$username,
            "pw"=>$password
        ]);
        $data = $sth->fetch(PDO::FETCH_ASSOC);


        if($data){
            $_SESSION['oturum'] = true;
            $_SESSION['user']['username'] = $data['username'];
            $_SESSION['user']['mail'] = $data['mail'];
            $_SESSION['user']['id'] = $data['id'];
            $_SESSION['user']['avatar'] = $data['avatar'];
        }

        */

        return $this->table('user')
        ->where('(username = :u or mail = :m ) and password = :pw')
        ->bind2([
            "u"=>$username,
            "m"=>$username,
            "pw"=>$password])
        ->getOneSecurity();
        
    }
   
    public function find($key,$value){
        
        
        return $this->from('user')->where($key,$value)->getOneSecurity();
    
    }

    public function register($email,$username,$password){

        $password = sha1(md5($password));
        $token = sha1(uniqid(mt_rand(), true));
        
        $response = $this
        ->from("user")
        ->insert2([
              "mail"=>$email,
              "username"=>$username,
              "password"=>$password,
              "activekey"=>$token,
              "status" => 1
        ]);
        if(is_bool($response)){
            return $response;
        }
        return false;
    }
    public function saveProfile($userid,$name,$username){
        return (bool)$this->from('user')->set(['name'=>$name,'username'=>$username])->where('id',$userid)->update2();
    }

    public function checkPassword($userid,$password){
        return !empty($this->from('user')->where([
            "id"=>$userid,
            "password"=>$password
        ])->getOne());
    }
    public function changePassword($userid,$password){
        return (bool)$this->from('user')->set(['password'=>$password])->where("id",$userid)->update2();
    }

    public function getProfile(){
        if(empty(session('oturum'))) return null;
        return $this->from('user')->where('id',session('user')['id'])->getOne();
    }
    public function availableUsername($username){
        return !empty($this->from('user')->where('username',$username)->getOne());
    }
    public function getUserProfile($username){
        return $this->select("id,name,username,avatar,status")->from('user')->where('username',$username)->getOne();
    }

    public function setProperty($column,$value,$userid){

      
        if(empty($this->from('user_settings')->where('userid',$userid)->getOne())){

            $s = (bool) $this->from('user_settings')->insert2([
                "userid"=>$userid,
                $column=>$value
            ]);
            return $s;

        }else{
            return (bool) $this->from('user_settings')->set([$column=>$value])->where("userid",$userid)->update2();
        }

    }

    public function getUserPosts($userid,$checkisAccount){
        $sql = "SELECT s1.id,s1.folder,s1.content,s1.isPass,u1.id as userid,s1.slug,s1.content,s1.userid,s1.share_date,c1.image,
            IFNULL(c.total_comments,0) as comment_count,IFNULL(l.total_likes,0) as likes_count FROM share s1 
            INNER JOIN collective c1 on s1.id = c1.shareid 
            INNER JOIN user u1 on u1.id = s1.userid
            LEFT JOIN 
                (SELECT IFNULL(COUNT(c.id),0) as total_comments,c.shareid FROM comment c WHERE c.active = 1 GROUP BY c.shareid) c ON c.shareid = s1.id 
            LEFT JOIN 
                (SELECT IFNULL(COUNT(l.id),0) as total_likes,l.shareid FROM likes l GROUP BY l.shareid) l ON l.shareid = s1.id

            WHERE s1.userid = '".$userid."' ".($checkisAccount == false ? ' and s1.isPass = 0' : '')."
            
            GROUP by c1.shareid
            ORDER BY s1.id DESC LIMIT 0,25";

       
       return $this->set_sql($sql)->getAll();
       
    }
    public function getUserBookmarks($userid){
        $sql = "SELECT b.id,b.userid,b.shareid,b.date,u.name,u.username,u.avatar,s.slug,clc.image,IFNULL(c.totalcomment,0) as total_comment,IFNULL(l.totallike,0) as total_like FROM bookmark b
        LEFT JOIN share s on s.id = b.shareid
        INNER JOIN collective clc on clc.shareid = s.id
        INNER JOIN user u on u.id = s.userid
        LEFT JOIN 
            (SELECT COUNT(c.id) as totalcomment,c.shareid FROM comment c WHERE c.active = 1 GROUP BY c.shareid ) c on c.shareid = b.shareid
        LEFT JOIN 
            (SELECT COUNT(l.id) as totallike,l.shareid FROM likes l GROUP BY l.shareid ) l on l.shareid = b.shareid
        
        
        WHERE b.userid = '".$userid."' and s.isPass = 0
        ORDER BY b.id DESC LIMIT 0,25";
        return $this->set_sql($sql)->getAll();
    }

    public function getUserComments($userid){
        $sql = "SELECT c.content,c.date,c.active,c.shareid,x.image,x.slug,u.avatar,IFNULL(u.name,'Anonim') as name,IFNULL(u.username,'Anonim') as username FROM comment c 
        LEFT JOIN (
         SELECT s.id,s.slug,s.userid,s.content,s.isPass,coll.image FROM share s INNER JOIN collective coll on coll.shareid = s.id WHERE s.isPass = 0 GROUP BY coll.shareid 
        ) x on x.id = c.shareid
        LEFT JOIN user u ON u.id = x.userid
        WHERE c.userid = '".$userid."' and x.slug is not null
        ORDER BY c.date DESC LIMIT 0,50";
        return $this->set_sql($sql)->getAll();
    }
    public function getUserLikes($userid){
        $sql = "SELECT b.id,b.userid,b.shareid,s.content,IFNULL(u.name,'Anonim') as name,IFNULL(u.username,'Anonim') as username,u.avatar,b.date,s.slug,clc.image,IFNULL(c.totalcomment,0) as total_comment,IFNULL(l.totallike,0) as total_like FROM likes b
        LEFT JOIN share s on s.id = b.shareid
        INNER JOIN collective clc on clc.shareid = s.id
        LEFT JOIN user u on u.id = s.userid
       	
         LEFT JOIN 
            (SELECT COUNT(c.id) as totalcomment,c.shareid FROM comment c WHERE c.active = 1 GROUP BY c.shareid ) c on c.shareid = b.shareid
        LEFT JOIN 
            (SELECT COUNT(l.id) as totallike,l.shareid FROM likes l GROUP BY l.shareid ) l on l.shareid = b.shareid
        
       
        
        WHERE b.userid = '".$userid."' and s.isPass = 0
        ORDER BY b.id DESC LIMIT 0,25";
        return $this->set_sql($sql)->getAll();
    }
    public function getAvatar($userid){
        return $this->select('avatar')->from('user')->where('id',$userid)->getOne()['avatar'];
    }
    public function saveAvatar($userid,$avatar_name){
        return (bool)$this->from('user')->where('id',$userid)->set(["avatar"=>$avatar_name])->update2();
    }
    public function getPosts(){
        print_r($this->from('bookmark')->getAll());
    }

    public function getProperty($column,$userid){
        return $this->from('user_settings')->where('userid',$userid)->getOne()[$column];
    }

    

}