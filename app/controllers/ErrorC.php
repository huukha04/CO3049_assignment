<?php

class ErrorC
{
    use Controller;

    public function index()
    {
        $this->view('error/error_404');
    }
    public function error_404()
    {
        $this->view('error/error_404');
    }
    public function error_500()
    {
        $this->view('error/error_500');
    }
}
