<?php

namespace App\Controller;

use Core\Controller\Controller;

class HomeController extends Controller {

    public function home() {
        $this->appendJS(["theme", "scroll", "post"])
             ->render("home", [
            "TITLE" => "Instants Home page",
        ]);
    }
}