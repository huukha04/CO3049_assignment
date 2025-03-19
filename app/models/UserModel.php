<?php


/**
 * User Class
 */
class UserModel
{

    use Model;
    public function __construct() {
        $this->allowedColumns = [
            'email',
            'password',
            'username',
        ];
        $this->table = 'user';
        $this->message = [];
    }

    public function login($data) {
        $username = $data['username'] ?? null;
        $email = $data['email'] ?? null;
        $password = $data['password'];
        
        if (!empty($username)) {
            $user = $this->where(['username' => $username]);
        } elseif (!empty($email)) {
            $user = $this->where(['email' => $email]);
        } else {
            $this->message['error'] = 'Username or email is required';
            return false;
        }
        
        if ($user) {
            if ($password == $user[0]->password) {
                $this->message['success'] = 'Login success';
                return [
                    'id' => $user[0]->id,
                    'username' => $user[0]->username,
                    'email' => $user[0]->email,
                    'role' => $user[0]->role,
                ];
            } else {
                $this->message['error'] = 'Password is incorrect';
                return false;
            }
        }
        $this->message['error'] = 'User not found';
        return false;
    }

    public function register($data) {
        $username = $data['username'];
        $email = $data['email'];
        $password = $data['password'];
        
        if (empty($username)) {
            $this->message['error'] = 'Username is required';
            return false;
        }
        
        if (empty($email)) {
            $this->message['error'] = 'Email is required';
            return false;
        }
        
        if (empty($password)) {
            $this->message['error'] = 'Password is required';
            return false;
        }
        
        $user = $this->where(['username' => $username]);
        if ($user) {
            $this->message['error'] = 'Username is already taken';
            return false;
        }
        
        $user = $this->where(['email' => $email]);
        if ($user) {
            $this->message['error'] = 'Email is already taken';
            return false;
        }
        
        $result = $this->insert($data);
        if ($result) {
            $this->message['success'] = 'Register success';
            return true;
        }
        $this->message['error'] = 'Register failed';
        return false;
    }


}
