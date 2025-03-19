<?php

spl_autoload_register(function ($classname) {
    $paths = ['../app/models/', '../app/middlewares/']; 
    foreach ($paths as $path) {
        $filename = $path . ucfirst($classname) . ".php";
        if (file_exists($filename)) {
            require $filename;
            break;
        }
    }
});


$session_lifetime = 1800;

// Kiểm tra nếu session đã được tạo
if (isset($_SESSION["last_activity"])) {
    if (time() - $_SESSION["last_activity"] > $session_lifetime) {
        session_unset(); // Xóa tất cả dữ liệu session
        session_destroy(); // Hủy session
        redirect('error/end_session');
        exit();
    }
}

// Cập nhật thời gian hoạt động cuối cùng
$_SESSION["last_activity"] = time();


require 'Config.php';
require 'Functions.php';
require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'Router.php';

