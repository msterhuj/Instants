<?php

namespace App\Controller;

use App\Models\User;
use Core\Controller;
use Core\Debug;
use Core\Mailer;
use Core\Router\Route;

class AuthController extends Controller {

    public function signup() {

        if ($this->isPost()) {
            Debug::print($_POST);
            $user = new User();
            $user->setUsername($_POST["username"]);
            $user->setEmail($_POST["email"]);
            $user->setPwd($_POST["pass"]);
            $user->setVreg(uniqid());
            $user->save(true);

            $mail = new Mailer($user->getEmail(), "Instants - Activation Link");
            $mail->render("activation_link", [
                "TITLE" => "Instants - Activation Link",
                "CODE" => $user->getVreg()
            ]);

            if ($mail->send()) echo "check you mail";
            else echo "error when sending mail";
        }

        $this->render("auth/signup", [
            "TITLE" => "Signup"
        ]);
    }
    public function login() {}
    public function activate() {
        User::ActivateByVreg(Route::getRouteParam());
    }

}