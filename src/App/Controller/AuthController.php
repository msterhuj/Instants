<?php

namespace App\Controller;

use App\Exception\UserNotFoundException;
use App\Models\User;
use Core\Controller\Controller;
use Core\Mailer;
use Core\ORM\Database;
use Core\Router\Route;

class AuthController extends Controller {

    public function signup() {
        if ($this->isPost()) {

            if(count($_POST) == 6
                && !empty($_POST["username"])
                && !empty($_POST["email"])
                && !empty($_POST["pass"])
                && !empty($_POST["vpass"])
                && !empty($_POST["born"]))
            {
                $data = $this->getBody();
                $username = mb_strtolower(trim($data["username"]));
                $email = mb_strtolower(trim($data["email"]));
                $pass = $data["pass"];
                $vpass = $data["vpass"];
                $dateOfBirth = $data["born"];

                $connection = Database::getPDO();

                /* TODO
                 * if (strlen($username) < 2 || strlen($username) > 30) {
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

                if (!$this->checkCSRF($_POST["csrf"]))
                    $_SESSION['ERROR'][] = "SCRF invalide";

                if ($pass != $vpass) {
                    $_SESSION['ERROR'][] = "VPassword pas bien";
                }*/

                if (empty($_SESSION['ERROR'])) {
                    $user = new User();
                    $user->setUsername($username);
                    $user->setEmail($email);
                    $user->setPwd($pass);
                    $user->setDateOfBirth($dateOfBirth);
                    $user->setVreg(uniqid());
                    $user->save();

                    $mail = new Mailer($user->getEmail(), "Instants - Activation Link");
                    $mail->render("activation_link", [
                        "TITLE" => "Instants - Activation Link",
                        "CODE" => $user->getVreg()
                    ]);
                    if ($mail->send()) echo "check you mail";
                    else echo "error when sending mail";
                    $this->redirectTo("home");
                }
            }
        } else {
            $this->appendCSS(["auth"])->render("auth/signup", [
                "TITLE" => "Signup",
                "CSRF" => $this->generateCSRF()
            ]);
        }
    }

    public function activate() {
        try {
            // update account
            $user = User::loadBy("vreg", Route::getRouteParam());
            if (!empty($user->getId())) {
                $user->setVreg();
                $user->addRoles("USER");
                $user->update();
            }
        } catch (\TypeError $e) {
            echo $e;
            // account not found
        } catch (UserNotFoundException $e) {
        }
    }

    public function login() {
        if ($this->isPost()){
            $data = $this->getBody();
            try {
                $user = User::loadBy("username", $data["username"]);

                if (!$this->checkCSRF($data["csrf"])) $_SESSION['ERROR'][] = "Invalid csrf";
                if (!$user->emailValidated()) $_SESSION['ERROR'][] = "Email not verified";

                if (empty($_SESSION['ERROR'])) {
                    if ($user->checkPwd($data["pass"])) $_SESSION["USER"] = $user;
                    else $_SESSION['ERROR'][] = "Invalid password";
                }

            } catch (UserNotFoundException) {
                $_SESSION['ERROR'][] = "User not found";
            }
        }

        $this->appendCSS(["auth"])->render("auth/login", [
            "TITLE" => "Login",
            "CSRF" => $this->generateCSRF()
        ]);
    }

    public function logout() {
        session_destroy();
        $this->redirectTo("home");
    }
}