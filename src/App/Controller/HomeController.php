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
        $mail = new Mailer('gabin.lanore@gmail.com', 'Code de validation');
        $mail->render("activation_code");
        if($mail->send()){
            echo 'Success!';
        } else {
            echo 'An error occurred.';
        };
    }
}