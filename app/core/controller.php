<?php

trait Controller {
    
    public function view($name, $data = []) {
        if (!empty($data))
            extract($data);
        $filename = "../app/views/" . $name . ".php";
        if (file_exists($filename)) {
            require $filename;
        } else {
            $filename = "../app/views/404.php";
            require $filename;
        }
    }
}
