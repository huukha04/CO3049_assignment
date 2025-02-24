<?php
class UserModel {
    use Model;
    
    public function __construct() {
        $this->allowedColumns = [
            'user_name',
            'email',
            'password',
        ];
        $this->table = 'user';
    }

    public function get_user($data) {
        $this->message = [];
        $email = $data['email'] ?? null;
        $user_name = $data['user_name'] ?? null;

        $query = "SELECT * FROM {$this->table} WHERE ";
        $params = [];

        if ($email && $user_name) {
            $query .= "email = ? AND user_name = ? LIMIT 1";
            $params = [$email, $user_name];
        } elseif ($email) {
            $query .= "email = ? LIMIT 1";
            $params = [$email];
        } elseif ($user_name) {
            $query .= "user_name = ? LIMIT 1";
            $params = [$user_name];
        } else {
            $this->message['error'] = 'data error';
            return false;
        }

        $result = $this->get_first($query, $params);
    
        if ($result) {
            $this->message['error'] = 'Account is exist';
            return $result;
        }
            

        $this->message['error'] = 'Account is not exist';
        return false;

    }

}