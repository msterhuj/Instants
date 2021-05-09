<?php

require '../includes/autoload.php';
session_start();

unset($_SESSION['ERROR']);

use Core\App;
use App\Controller\HomeController;
use App\Controller\AuthController;
use App\Controller\AdminController;
use App\Controller\UserController;

$app = App::getInstance();

$app->getRouter()
    // public zone
    ->get('/', 'home', HomeController::class) // home page

    ->get('/signup', 'signup', AuthController::class) // signup form
    ->post('/signup', 'signup', AuthController::class) // sign up action
    ->get('/login', 'login', AuthController::class) // login form
    ->post('/login', 'login', AuthController::class) // login action
    ->get('/activate/:::', 'activate', AuthController::class) // use code for validate account
    ->get('/post/:::', 'home', HomeController::class) // show post
    ->get('/profile/:::', 'home', HomeController::class) // show profile of user
    // admin zone
    ->get('/admin/', 'admin', AdminController::class) // General admin info
    ->get('/admin/report', 'admin_report', AdminController::class) // manage report
    ->get('/admin/users', 'admin_users', AdminController::class) // manage user
    // user zone
    ->get('/logout', 'logout', AuthController::class) // logout user
    ->get('/report/', 'home', HomeController::class) // report a post
    ->get('/support/', 'home', HomeController::class) // support tech
    ->get('/messages/', 'home', HomeController::class) // all private message
    ->get('/messages/:::', 'home', HomeController::class) // private with user
    ->get('/settings/', 'home', HomeController::class) // settings of user
    ->get('/:::', 'user', UserController::class)
;
$app->exec();