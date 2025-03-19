<?php
class PosterModel
{
    use Model;
    
    public function __construct() {
        $this->allowedColumns = [
            'status',
            'expiration_date',
            'url',
            'title',
            'description',
            'start_date',
        
        ];
        $this->table = 'poster';
        $this->message = [];
    }
    public function insert_poster($data, $files) {
        $url = $data['url'];
        $poster = $this->where(['url' => $url]);
        if ($poster) {
            $this->message['error'] = 'Poster already exists';
            return false;
        }

        // **Xử lý tải ảnh**
        $uploadDir = 'storage/app/main/posters/'; 
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

        
        $poster = $this->insert($data);
        if ($poster) {
            $this->message['success'] = 'Poster added successfully';
            return true;
        }
        $this->message['error'] = 'Failed to add poster';
        return false;
    }
    public function delete_poster($data) {
        $url = $data['url'];
        $poster = $this->where(['url' => $url]);
        if (!$poster) {
            $this->message['error'] = 'Poster does not exist';
            return false;
        }

        $file_name = basename($url);
        $uploadDir = 'storage/app/main/posters/'; 


        $filePath = $uploadDir . $file_name;
        if (file_exists($filePath)) {
            unlink($filePath);
        } else {
            $this->message['warning'] = 'File does not exist on server';
        }

        $delete = $this->delete($data['id']);
        if ($delete) {
            $this->message['success'] = 'Poster deleted successfully';
            return true;
        } else {
            $this->message['error'] = 'Failed to delete poster';
            return false;
        }

    }
    

}
