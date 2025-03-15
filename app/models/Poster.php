<?php
class Poster
{
    use Model;
    public function __construct() {
        $this->allowedColumns = [
            'expiration_date',
            'url',
        ];
        $this->table = 'poster';
        $this->message = [];
    }

    public function get_url($data)
    {
        $this->message = [];


        
    }
    public function add_url($url)
    {
        $this->message = [];
        


        
    }
    public function delete_url($data)
    {
        $this->message = [];

        
    }
}
