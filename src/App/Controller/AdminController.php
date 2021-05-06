<?php

namespace App\Controller;

use Core\Controller\Controller;

class AdminController extends Controller {
    public function admin() {
        $this->setTemplate("admin")->render("admin/home", [
            "TITLE" => "Admin"
        ]);
    }
    public function admin_report() {}
    public function admin_support() {}
    public function admin_users() {}
}