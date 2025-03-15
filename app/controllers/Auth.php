<?php

class Auth
{
    use Controller;

    public function index()
    {
        $data['user'] = $_SESSION['user'] ?? null;
        $this->view('home/home', $data);
    }
    public function login()
    {
        $data['user'] = $_SESSION['user'] ?? null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userModel = new UserModel;
            $user = $userModel->get_first("SELECT * FROM users WHERE email = :email", ['email' => $_POST['email']]);
            if ($user && password_verify($_POST['password'], $user->password)) {
                $_SESSION['user'] = $user;
                redirect('auth');
            } else {
                $data['errors'] = "Invalid email or password";
            }
        }
        $this->view('auth/login', $data);
    }
    public function register() {
        $data = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userModel = new UserModel;
            $userModel->insert($_POST);
            redirect('auth/login');
            $data['errors'] = $otpModel->message;
        }
        $this->view('auth/register', $data);
    }      
}
