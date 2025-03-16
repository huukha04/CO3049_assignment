<?php

class Movie {
    use Controller;

    public function index()
    {
        $data = [];
        $data['user'] = $_SESSION['user'] ?? null;
        $movie = new MovieModel();
        $data['movie'] = $movie->where();
        
        $this->view('admin/movie', $data);
    }
    public function insert()
    {
        $data = [];
        $data['user'] = $_SESSION['user'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES["file"])) {
            $movie = new MovieModel();

            if ($movie->where(['url' => $_POST['url']])) {
                $data['error'] = ['URL is already exist'];
            } else {
                $targetDir = "../storage/app/movies/movies/"; // Thư mục lưu trữ tệp
                $targetFile = $targetDir . basename($_FILES["file"]["name"]);
                
                // Kiểm tra nếu thư mục chưa tồn tại, hãy tạo nó
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                // Kiểm tra lỗi
                if ($_FILES["file"]["error"] !== UPLOAD_ERR_OK) {
                    die("Lỗi khi tải lên tệp: " . $_FILES["file"]["error"]);
                }


                // Di chuyển tệp tải lên vào thư mục đích
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                    $movie->insert($_POST);
                    $data['success'] = ['movie uploaded successfully'];
                } else {
                    $data['error'] = ['Sorry, there was an error uploading your file.'];
                }
            }

        }
        $data['movie'] = $movie->where();
        $this->view('admin/movie', $data);
    }
    public function delete()
    {
        $data = [];
        $data['user'] = $_SESSION['user'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $movie = new MovieModel();

            $movie->delete($_POST['id']);
        }
        $data['movie'] = $movie->where();
        $this->view('admin/movie', $data);
    }
    public function update()
    {
        $data = [];
        $data['user'] = $_SESSION['user'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $movie = new MovieModel();

            $movie->update($_POST['id'], $_POST);
        }
        $data['movie'] = $movie->where();
        $this->view('admin/movie', $data);
    }

    
}