<?php
class AdminController
{
    use Controller;
    public function __construct()
    {
        AuthMiddleware::required_admin();
    }
    public function index()
    {
        $this->view('admin/home');
    }
    public function home()
    {
        $this->view('admin/home');
    }


}
