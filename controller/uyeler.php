<?php


defined('BASEPATH') OR exit('No direct script access allowed');





class Uyeler extends Controller
{

    public function index()
    {

        $usersModel = $this->model('users');
        $users = $usersModel->getAll();

        $this->view('uyeler', [
            'users' => $users
        ]);
    }

    public function post()
    {
        print_r($_POST);
    }

}