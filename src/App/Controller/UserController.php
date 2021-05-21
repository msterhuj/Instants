<?php


namespace App\Controller;


use App\Models\User;
use Core\Controller\Controller;
use Core\Router\Route;

class UserController extends Controller {

    public function user() {
        echo Route::getRouteParam();
    }

    public function follow() {
        $user = User::loadBy("id", Route::getRouteParam());
        $user->followee();
    }
}