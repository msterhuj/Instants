<?php

namespace App\Controller;

use Core\Controller\Controller;
use App\Models\User;

class AdminController extends Controller {
    public function admin() {
        if ($this->isGuest()) $this->redirectTo("login");
        $user = User::getFromSession();
        if (!$user->hasRole("ADMIN")) $this->redirectTo("home");

        $this->setTemplate("admin")->appendJS(["graf"])->render("admin/home", [
            "TITLE" => "Admin"
        ]);
    }

    public function admin_users() {
        $this->setTemplate("admin")->render("admin/users", [
            "TITLE" => "Admin - Users",
            "CSRF" => $this->generateCSRF()
        ]);
    }

    public function admin_report() {}
}