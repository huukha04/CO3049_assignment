<?php
session_start();


require "../app/core/init.php";

$app = new Route;

$app->loadController();
