<?php


defined('BASEPATH') OR exit('No direct script access allowed');



class Profile extends Controller
{

    public function index($name = null)
    {
        echo 'Hoş Geldin  ' . $name;
    }

    public function route($name)
    {
        # code...
        if(method_exists($this,$name)){
            $this->$name();
        }
    }

    public function settings()
    {

        # code...
    }

}