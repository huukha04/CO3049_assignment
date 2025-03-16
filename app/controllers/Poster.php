<?php

class Poster {
    use Controller;

    public function index()
    {
        $data = [];
        $data['user'] = $_SESSION['user'] ?? null;
        $poster = new PosterModel();
        $data['poster'] = $poster->where();
        
        $this->view('admin/poster', $data);
    }
    public function insert()
    {
        $data = [];
        $data['user'] = $_SESSION['user'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES["file"])) {
            $poster = new PosterModel();

            if ($poster->where(['url' => $_POST['url']])) {
                $data['error'] = ['URL is already exist'];
            } else {
                $targetDir = "../storage/app/movies/posters/"; // Thư mục lưu trữ tệp
                $targetFile = $targetDir . basename($_FILES["file"]["name"]);
                
                // Kiểm tra nếu thư mục chưa tồn tại, hãy tạo nó
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                // Kiểm tra lỗi
                if ($_FILES["file"]["error"] !== UPLOAD_ERR_OK) {
                    die("Lỗi khi tải lên tệp: " . $_FILES["file"]["error"]);
                }

                // Kiểm tra loại tệp (ví dụ: chỉ cho phép hình ảnh)
                $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                $allowedTypes = ["jpg", "jpeg", "png", "gif", "pdf"];
                if (!in_array($fileType, $allowedTypes)) {
                    die("Chỉ chấp nhận các tệp: JPG, JPEG, PNG, GIF, PDF.");
                }

                // Di chuyển tệp tải lên vào thư mục đích
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                    $poster->insert($_POST);
                    $data['success'] = ['Poster uploaded successfully'];
                } else {
                    $data['error'] = ['Sorry, there was an error uploading your file.'];
                }
            }

        }
        $data['poster'] = $poster->where();
        $this->view('admin/poster', $data);
    }
    

    
}