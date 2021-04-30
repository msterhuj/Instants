<?php

error_reporting(E_ALL);
spl_autoload_register(function($className) {
    $path = __DIR__ . "/../src/";
    $ext = ".php";
    $fullPath = str_replace("\\", "/", $path . $className . $ext);
    if (file_exists($fullPath))
        include_once $fullPath;
});