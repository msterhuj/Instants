<?php

namespace App\Controller;

use Core\Controller;
use Core\Router\Route;

class HomeController extends Controller {

    public function home(Route $route) {
        $this->render("home", [
            "TITLE" => "Instants Home page",
        ]);
    }
}