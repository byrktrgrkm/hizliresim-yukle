<?php 

defined('BASEPATH') OR exit('No direct script access allowed');


class StaticPages extends Controller{
    
    public function __construct(){
        parent::__construct();
        $this->helper('url');
    }

    public function index($page){

        $pages = [
            "gizlilik-politikasi"=>"gp",
            "kotuye-kullanim"=>"kk",
            "iletisim"=>"il",
            "yardim"=>"yardim-sss"
        ];
        if(!key_exists($page,$pages))
            redirect('index');

        $this->view('template/header');
        $this->view('static/'.$pages[$page]);
        $this->view('template/footer');
    }
    public function yardim(){
        $this->view('template/header');
        $this->view('static/yardim-sss');
        $this->view('template/footer');
    }
}