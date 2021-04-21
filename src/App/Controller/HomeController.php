<?php

namespace App\Controller;

use Core\Controller;
use Core\Mailer;
use Core\Router\Route;

class HomeController extends Controller {

    public function home(Route $route) {
        $this->render("home", [
            "TITLE" => "Instants Home page",
        ]);
    }
    public function test(Route $route) {
        $mailer = new Mailer();
        $mailer->render("activation_code")->send();
    }
}