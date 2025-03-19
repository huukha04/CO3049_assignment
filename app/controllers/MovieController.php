<?php
class movieController
{
    use Controller;
    public function __construct()
    {
        AuthMiddleware::required_admin();
    }
    public function index()
    {
        $model = new MovieModel();
        $data['movie'] = $model->all();
        $this->view('admin/movie', $data);
    }
    public function insert()
    {
        $data = [];
        $model = new MovieModel();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES["file"])) {
            $movie = $model->insert_movie($_POST, $_FILES);
            $data = $model->message;
        }
        $data['movie'] = $model->all();
        $data['success'] = 'Movie added successfully';
        $this->view('admin/movie', $data);
        
    }
    public function update()
    {
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = new MovieModel();
            $movie = $model->update($_POST['id'], $_POST);
            $data = $model->message;
        }
        $data['movie'] = $model->all();
        $data['success'] = 'Movie updated successfully';

        $this->view('admin/movie', $data);
    }
    public function delete()
    {
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = new MovieModel();
            $movie = $model->delete_movie($_POST);
            $data = $model->message;
        }
        $data['movie'] = $model->all();
        $data['success'] = 'Movie deleted successfully';
        $this->view('admin/movie', $data);
    }
}
