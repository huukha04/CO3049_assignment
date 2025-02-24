<?php
// require auto all file in models
spl_autoload_register(function ($classname) {

    require $filename = "../app/models/" . $classname . ".php";
});


// require all file in core
require 'config.php';
require 'controller.php';
require 'database.php';
require 'function.php';
require 'model.php';
require 'route.php';



