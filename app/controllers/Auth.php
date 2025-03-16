<?php

class Auth
{
    use Controller;

    public function index()
    {
        $data['user'] = $_SESSION['user'] ?? null;
        $this->view('home/home', $data);
    }
    public function login() {
        $data = [];
        $data['user'] = $_SESSION['user'] ?? null;
        if ($data['user']) {
            if ($data['user']->role == 'admin') {
                redirect('admin');
                exit;
            }
            redirect('home');
            exit;
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userModel = new UserModel();
            $users = $userModel->where(['username' => $_POST['username']]); // Trả về mảng chứa object
        
            if (!empty($users)) {
                $user = $users[0]; // Lấy phần tử đầu tiên của mảng
        
                if (!isset($user->password) || $user->password != $_POST['password']) {
                    $data['error'] = ['Password is incorrect'];
                } else {
                    $_SESSION['user'] = $user;
                    if ($user->role == 'admin') {
                        redirect('admin');
                        exit;
                    }
                    redirect('home');
                    exit;
                }
            } else {
                $data['error'] = ['Username not found'];
            }
        }
        
        $this->view('auth/login', $data);
    }
    public function logout() {
        $data = [];
        unset($_SESSION['user']);
        redirect('home');
    }
    public function register() {

        $data = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userModel = new UserModel();



            if ($userModel->where(['email' => $_POST['email']])) {
                $data['error'] = ['Email is already taken'];
            } 
            elseif ($userModel->where(['username' => $_POST['username']])) {
                $data['error'] = ['Username is already taken'];
            } 
            else {
                $userModel->insert($_POST);
                redirect('auth/login');
            }
        }
        $this->view('auth/register', $data);
    }
    public function forgot_password() {
        $data = [];
        $this->view('auth/forgot_password');
    }      
}
