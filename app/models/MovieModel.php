<?php
class movieModel
{
    use Model;
    
    public function __construct() {
        $this->allowedColumns = [
            'status',
            'title',
            'premiere_date',
            'expiration_date',
            'time',
            'category_code',
            'url',
            'trailer',
            'description',
            'time',
            'rating',
            'vote_count',
            'year',
            'country',
            'producer',	
            'genre',
            'director',
            'cast',
        ];
        
        $this->table = 'movie';
        $this->message = [];
    }
    public function insert_movie($data, $files) {
        $url = $data['url'];
        $movie = $this->where(['url' => $url]);
        if ($movie) {
            $this->message['error'] = 'Movie already exists';
            return false;
        }

        // **Xử lý tải ảnh**
        $uploadDir = 'storage/app/main/movies/'; 
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($files['file']['name']);
        $targetFilePath = $uploadDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Chỉ chấp nhận định dạng ảnh
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($fileType, $allowedTypes)) {
            $this->message['error'] = 'Only JPG, JPEG, PNG, GIF, WEBP files are allowed.';
            return false;
        }

        // Di chuyển file tải lên vào thư mục
        if (!move_uploaded_file($files['file']['tmp_name'], $targetFilePath)) {
            $this->message['error'] = 'Failed to upload image.';
            return false;
        }

        
        $movie = $this->insert($data);
        if ($movie) {
            $this->message['success'] = 'Movie added successfully';
            return true;
        }
        $this->message['error'] = 'Failed to add movie';
        return false;
    }
    public function delete_movie($data) {
        $url = $data['url'];
        $movie = $this->where(['url' => $url]);
        if (!$movie) {
            $this->message['error'] = 'Movie does not exist';
            return false;
        }

        $file_name = basename($url);
        $uploadDir = 'storage/app/main/movies/'; 


        $filePath = $uploadDir . $file_name;
        if (file_exists($filePath)) {
            unlink($filePath);
        } else {
            $this->message['warning'] = 'File does not exist on server';
        }

        $delete = $this->delete($data['id']);
        if ($delete) {
            $this->message['success'] = 'Movie deleted successfully';
            return true;
        } else {
            $this->message['error'] = 'Failed to delete movie';
            return false;
        }

    }

    

}
