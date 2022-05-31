<?php

class Controller
{
    private $systemModel;

    public function __construct(){
        $this->systemModel = $this->model('system');
    }

    public function view($name, $data = [])
    {
        extract($data);
        require __DIR__ . '/view/' . strtolower($name) . '.php';
    }

    public function template($name,$ex = []){

        $data = "";
        $file = __DIR__ .'/view/'.strtolower($name). '.php';
        if(file_exists($file)){
            extract($ex);
            ob_start();
            require $file;
            $data = ob_get_clean();
        }
        return $data;
    }

    public function model($name)
    {
        require __DIR__ . '/model/' . strtolower($name) . '.php';
        return new $name();
    }

    public function helper($name)
    {
        $file =  __DIR__ . '/helpers/'.strtolower($name).'_helper.php';
        if(file_exists($file))
            require $file;
        else
            die("No exits helper file : ".$name);
    }

    public function system_log($SystemTypes = SystemTypes::DB,$message){
        $this->systemModel->AddMessage($SystemTypes,$message);
    }
}