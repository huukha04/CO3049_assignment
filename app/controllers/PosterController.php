<?php
class PosterController
{
    use Controller;
    public function __construct()
    {
        AuthMiddleware::required_admin();
    }
    public function index()
    {
        $model = new PosterModel();
        $data['poster'] = $model->all();
        $this->view('admin/poster', $data);
    }
    public function insert()
    {
        $data = [];
        $model = new PosterModel();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES["file"])) {
            $poster = $model->insert_poster($_POST, $_FILES);
            $data = $model->message;
        }
        $data['poster'] = $model->all();
        $data['success'] = 'Poster added successfully';
        $this->view('admin/poster', $data);
        
    }
    public function update()
    {
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = new PosterModel();
            $poster = $model->update($_POST['id'], $_POST);
            $data = $model->message;
        }
        $data['poster'] = $model->all();
        $data['success'] = 'Poster updated successfully';

        $this->view('admin/poster', $data);
    }
    public function delete()
    {
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = new PosterModel();
            $poster = $model->delete_poster($_POST);
            $data = $model->message;
        }
        $data['poster'] = $model->all();
        $data['success'] = 'Poster deleted successfully';
        $this->view('admin/poster', $data);
    }
}
