<?php

class ErrorC
{
    use Controller;

    public function index()
    {
        $this->view('error/error_404');
    }
}
