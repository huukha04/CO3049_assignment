<?php
class Home
{
    use Controller;

    public function index()
    {
        $data['user'] = $_SESSION['user'] ?? null;
        $poster = new PosterModel();
        $data['poster'] = $poster->where();
        $poster = new MovieModel();
        $data['movie'] = $poster->where();
        $this->view('home/home', $data);
    }
    public function faq()
    {
        $data['user'] = $_SESSION['user'] ?? null;
        $this->view('home/faq', $data);
    }

}
