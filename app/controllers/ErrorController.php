<?php

class ErrorController
{
    use Controller;

    public function index()
    {
        $this->view('error/error_404');
    }
    public function error_403()
    {
        $this->view('error/error_403');
    }
    public function error_404()
    {
        $this->view('error/error_404');
    }
    public function error_500()
    {
        $this->view('error/error_500');
    }
    public function end_session()
    {
        $this->view('error/end_session');
    }
}
