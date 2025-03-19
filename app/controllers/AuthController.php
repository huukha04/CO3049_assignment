<?php

class AuthController {
    use Controller;
    public function __construct() {
    }

    public function index() {
    }
    


    public function login() {
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = new UserModel();
            $user = $model->login($_POST);

            $_SESSION["user"] = $user;
            if ($user) {
                if ($user['role'] == 'admin') {
                    $this->view('admin/home');
                } else {
                    $this->view('page/home');
                }
            } else {
                $data['error'] = $model->message;
            }
        }
        $this->view('auth/login', $data);
        
    }
    public function logout() {
        session_unset();
        session_destroy(); 
        redirect('page/home');
    }
    public function register() {
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = new UserModel();
            $user = $model->register($_POST);
            if ($user) {
                redirect('auth/login');
                exit;
            } else {
                $data['error'] = $model->message;
            }
        }
        $this->view('auth/register', $data);
       
    }
    public function forgot_password() {
        
    }      
}
