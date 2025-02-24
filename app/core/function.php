<?php
function redirect($path)
{
    header("Location: " . ROOT . "/" . $path);
    die;
}
