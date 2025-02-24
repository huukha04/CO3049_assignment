<?php

class Admin {
    use Controller;

    public function index()
    {
        $data['user_name'] = $_SESSION['USER']->user_name ?? null;
        $this->view('admin/home', $data);
    }
}
