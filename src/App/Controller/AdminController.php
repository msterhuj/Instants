<?php

namespace App\Controller;

use Core\Controller\Controller;
use App\Models\User;
use Core\Router\Route;

class AdminController extends Controller {
    public function admin() {
        if ($this->isGuest()) $this->redirectTo("login");
        if (!User::getFromSession()->hasRole("ADMIN")) $this->redirectTo("home");
        $user = User::getFromSession();
        if (!$user->hasRole("ADMIN")) $this->redirectTo("home");

        $this->setTemplate("admin")->appendJS(["graf"])->render("admin/home", [
            "TITLE" => "Admin"
        ]);
    }

    public function admin_users() {
        if ($this->isGuest()) $this->redirectTo("login");
        if (!User::getFromSession()->hasRole("ADMIN")) $this->redirectTo("home");
        $this->setTemplate("admin")
            ->appendJS(["admin"])
            ->render("admin/users", [
            "TITLE" => "Admin - Users",
            "CSRF" => $this->generateCSRF()
        ]);
    }

    public function admin_report() {}

    public function admin_user_ban() {
        if ($this->isGuest()) $this->redirectTo("login");
        if (!User::getFromSession()->hasRole("ADMIN")) $this->redirectTo("home");
        $user = User::loadBy("id", Route::getRouteParam());
        if ($user->hasRole("BANNED")) $user->delRoles("BANNED");
        else $user->addRoles("BANNED");
        $user->update();
        $this->redirectTo("admin_users");
    }

    public function admin_user_delete() {
        if ($this->isGuest()) $this->redirectTo("login");
        if (!User::getFromSession()->hasRole("ADMIN")) $this->redirectTo("home");
        $user = User::loadBy("id", Route::getRouteParam());
        $user->delete();
        $this->redirectTo("admin_users");
    }

}