<?php
session_start();

require "../app/core/Init.php";

DEBUG ? ini_set('display_errors', 1) : ini_set('display_errors', 0);

$app = new Router;
$app->loadController();
