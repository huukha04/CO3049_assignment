<?php

trait Controller
{
    public function view($name, $data = [])
    {
        if (!empty($data)) {
            extract($data);
        }

        // Danh sách các đuôi mở rộng cần kiểm tra
        $extensions = ['php', 'html'];
        
        // Kiểm tra xem file nào tồn tại trước
        $filename = null;
        foreach ($extensions as $ext) {
            $path = "../app/views/{$name}.{$ext}";
            if (file_exists($path)) {
                $filename = $path;
                break;
            }
        }

        // Nếu không tìm thấy file hợp lệ, dùng trang 404
        if (!isset($filename)) {
            $filename = "../app/views/error/error_404.html";
        }

        require $filename;
    }
}


