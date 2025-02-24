<?php

class Customer {
    use Controller;

    public function index()
    {
        $data['user_name'] = $_SESSION['USER']->user_name ?? null;
        $this->view('customer/home', $data);
    }
}
