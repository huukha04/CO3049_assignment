<?php

// View thì gọi Views/
// Redirect thì gọi Url truyền router -> controllers/
function redirect($path)
{
    header("Location: " . ROOT . $path);
    die;
}
