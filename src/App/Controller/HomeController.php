<?php

namespace App\Controller;

use Core\Controller\Controller;

class HomeController extends Controller {

    public function home() {
        $this->render("home", [
            "TITLE" => "Instants Home page",
        ]);
    }
}