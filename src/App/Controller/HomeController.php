<?php

namespace App\Controller;

use Core\Controller;
use Core\Router\Route;

class HomeController extends Controller {

    public function home(Route $route) {
        include "../src/App/Templates/index.html";
    }
}