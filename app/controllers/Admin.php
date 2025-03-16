<?php
class Admin
{
    use Controller;

    public function index()
    {
        $data['user'] = $_SESSION['user'] ?? null;

        
        $this->view('admin/home', $data);
    }


}
