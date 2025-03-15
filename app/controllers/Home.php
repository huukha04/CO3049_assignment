<?php

/**
 * home class
 */

class Home
{
    use Controller;

    public function index()
    {
        $data['user'] = $_SESSION['user'] ?? null;
        $this->view('home/home', $data);
    }
    public function faq()
    {
        $data['user'] = $_SESSION['user'] ?? null;
        $this->view('home/faq', $data);
    }

}
