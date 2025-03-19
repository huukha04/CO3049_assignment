<?php

class PageController
{
    use Controller;
    public function __construct()
    {
    }
    public function index()
    {
        $this->view('page/home');
    }
    public function home()
    {
        $this->view('page/home');
    }


}
