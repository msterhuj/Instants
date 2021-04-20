<?php

namespace App\Controller;

use Core\Controller;
use Core\Router\Route;

class HomeController extends Controller {

    public function home(Route $route) {
        include "../src/App/Templates/includes/head.php";
        include "../src/App/Templates/includes/body.php";
    }
}