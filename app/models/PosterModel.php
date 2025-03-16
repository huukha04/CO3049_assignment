<?php
class PosterModel
{
    use Model;
    
    public function __construct() {
        $this->allowedColumns = [
            'status',
            'expiration_date',
            'url',
        
        ];
        $this->table = 'poster';
        $this->message = [];
    }

    

}
