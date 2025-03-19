<?php
class AuthMiddleware
{
    public static function required_admin() {
        if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] != 'admin') {
            redirect('error/error_403');
            exit();
        }
    }
}
