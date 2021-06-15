<?php

namespace App\Controller;

use App\Models\User;
use Core\Controller\Controller;
use Core\ORM\Database;
use Core\Router\Route;

class HomeController extends Controller {

    public function home() {
        $this->appendJS(["theme", "scroll", "post", "search"])
             ->render("home", [
            "TITLE" => "Instants Home page",
        ]);
    }

    public function report() {
        if (Controller::isGuest()) $this->redirectTo("home");

        $user = User::getFromSession();
        $post_id = Route::getRouteParam();

        $prepare = Database::getPDO()->prepare("insert into report (author, post) VALUE (:author, :post)");
        $prepare->execute([
            "author" => $user->getId(),
            "post" => $post_id
        ]);
        $this->redirectTo("home");
    }
}