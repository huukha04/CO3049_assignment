<?php

spl_autoload_register(function ($classname) {
    require $filename = "../app/models/" . ucfirst($classname) . ".php";
});

require 'Config.php';
require 'Functions.php';
require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'Router.php';

