<?php
spl_autoload_register(function($className) {
    $path = "../src/";
    $ext = ".php";
    $fullPath = $path . $className . $ext;
    if (file_exists($fullPath))
        include_once $fullPath;
});