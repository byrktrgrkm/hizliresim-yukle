<?php

class Database
{

    protected $db;

    public function __construct()
    {
        try {
            $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.'', DB_USERNAME, DB_PASSWORD);
            $this->db->exec("set names utf8");
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }
    
    



}

/*
$db = new DB("localhost","root");
$db->use("test");

$data = $db
        ->col(["id","name","confirm"])
        ->table("users")
        ->where([
            "confirm"=>[
                "val"=>0,
                "operation"=>"!="
            ],
            "name"=>[
                "val"=>"'%e%'",
                "operation"=>"LIKE"
            ]
        ])
        ->order(-1)
        ->limit(20)
        ->getAll();
        
$b = $db
    ->begin()
    ->table("users")
    ->search("name","gà¸£à¸–rkem")
    ->getOne();

    
 */