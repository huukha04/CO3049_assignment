<?php
class MovieModel
{
    use Model;
    
    public function __construct() {
        $this->allowedColumns = [
            'description',
            'status',
            'title',
            'premiere_date',
            'expiration_date',
            'time',
            'category_code',
            'url',
            'rating',
            'vote_count',
            'country',
            'producer',	
            'genre',
            'director',
            'cast',
        ];
        
        $this->table = 'movie';
        $this->message = [];
    }

    

}
