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
        $this->table = 'users';
        $this->message = [];
    }

    public function validate($data)
    {
        $this->message = [];

        
    }
}
