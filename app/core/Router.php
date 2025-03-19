<?php

class Router
{
    private $controller = 'PageController';
    private $method = 'index';

    private function splitURL()
    {
        $URL = $_GET['url'] ?? 'page';
        $URL = explode("/", trim($URL, '/'));
        return $URL;
    }

    public function loadController()
    {
        $URL = $this->splitURL();

        /** Select Controller **/
        $filename = "../app/controllers/" . ucfirst($URL[0]) . "Controller".".php";
        if (file_exists($filename)) {
            require $filename;
            $this->controller = ucfirst($URL[0]) . "Controller";
            unset($URL[0]);
        } else {
            $filename = "../app/controllers/ErrorController.php";
            require $filename;
            $this->controller = "ErrorController";
        }

        $controller = new $this->controller;

        /** Select Method **/
        if (!empty($URL[1])) {
            if (method_exists($controller, $URL[1])) {
                $this->method = $URL[1];
                unset($URL[1]);
            }
        }

        call_user_func_array([$controller, $this->method], $URL);
    }
}
