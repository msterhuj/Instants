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
            if(count($_POST) == 5
                && !empty($_POST["username"])
                && !empty($_POST["email"])
                && !empty($_POST["pass"])
                && !empty($_POST["vpass"])
                && !empty($_POST["born"]))
            {
                $user = new User();
                $username = mb_strtolower(trim($_POST["username"]));
                $email = mb_strtolower(trim($_POST["email"]));
                $pass = $_POST["pass"];
                $vpass = $_POST["vpass"];
                $dateOfBirth = $_POST["born"];

                $connection = $user->getConnection();

                if (strlen($username) < 2 || strlen($username) > 30) {
                    $_SESSION['ERROR'][] = "Username pas bien";
                } else {

                    $queryPrepared = $connection->prepare("SELECT username FROM user WHERE username=:username;");
                    $queryPrepared->execute(["username" => $username]);
                    if ($queryPrepared->rowCount() != 0) {
                        $_SESSION['ERROR'][] = "Votre username existe déjà";
                    }
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['ERROR'][] = "Email pas bien";
                } else {
                    $queryPrepared = $connection->prepare("SELECT email FROM user WHERE email=:email;");
                    $queryPrepared->execute(["email" => $email]);
                    if ($queryPrepared->rowCount() != 0) {
                        $_SESSION['ERROR'][] = "Votre email existe déjà";
                    }
                }

                if (strlen($pass) < 8
                    || !preg_match("#[a-z]#", $pass)
                    || !preg_match("#[A-Z]#", $pass)
                    || !preg_match("#[0-9]#", $pass)
                ) {
                    $_SESSION['ERROR'][] = "Password pas bien";
                }
                if ($pass != $vpass) {
                    $_SESSION['ERROR'][] = "VPassword pas bien";
                }

                if (empty($_SESSION['ERROR'])) {
                    Debug::print($_POST);
                    $user->setUsername($username);
                    $user->setEmail($email);
                    $user->setPwd($pass);
                    $user->setDateOfBirth($dateOfBirth);
                    $user->setVreg(uniqid());
                    $user->save(true);

                    $mail = new Mailer($user->getEmail(), "Instants - Activation Link");
                    $mail->render("activation_link", [
                        "TITLE" => "Instants - Activation Link",
                        "CODE" => $user->getVreg()
                    ]);
                    //if ($mail->send()) echo "check you mail";
                    //else echo "error when sending mail";
                }
                Debug::print($_SESSION['ERROR']);
            }
        }
        $this->render("auth/signup", [
            "TITLE" => "Signup"
        ]);
    }
    public function login() {}
    public function activate() {
        $user = new User();
        $user->loadBy("vreg", Route::getRouteParam());
        if (!empty($user->getId())) {
            $user->setVreg();
            $user->addRoles("USER");
            $user->save();
        }
    }

}