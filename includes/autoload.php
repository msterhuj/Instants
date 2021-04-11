<?php

if (isset($_COOKIE["debug"]) && $_COOKIE["debug"] == "chocolatine") {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} elseif (isset($_GET["debug"]) && $_GET["debug"] == "chocolatine") {
    setcookie("debug", "chocolatine", time()+3600);
}

spl_autoload_register(function($className) {
    $path = "../src/";
    $ext = ".php";
    $fullPath = $path . $className . $ext;
    if (file_exists($fullPath))
        include_once $fullPath;
});