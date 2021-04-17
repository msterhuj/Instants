<?php

namespace App\Controller;

use Core\Controller;
use Core\Router\Route;

class HomeController extends Controller {

    public  function home(Route $route) {
        return $this->render("file.html", ["app" => $route->getParam()]);
    }
}