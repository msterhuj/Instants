<?php


namespace App\Controller;


use Core\Controller\Controller;
use Core\Router\Route;

class UserController extends Controller {

    public function user() {
        echo Route::getRouteParam();
    }
}