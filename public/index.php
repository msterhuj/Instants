<?php

require '../includes/autoload.php';

session_start();

use Core\App;
use App\Controller\HomeController;
use App\Controller\AuthController;

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
    // user zone
    ->get('/logout', 'home', HomeController::class) // logout user
    ->get('/bookmarks/', 'home', HomeController::class) // all post saved
    ->get('/report/', 'home', HomeController::class) // report a post
    ->get('/support/', 'home', HomeController::class) // support tech
    ->get('/messages/', 'home', HomeController::class) // all private message
    ->get('/messages/:::', 'home', HomeController::class) // private with user
    ->get('/settings/', 'home', HomeController::class) // settings of user
    // admin zone
    ->get('/admin/', 'home', HomeController::class) // General admin info
    ->get('/admin/report', 'home', HomeController::class) // manage report
    ->get('/admin/support', 'home', HomeController::class) // manage support ask
    ->get('/admin/users', 'home', HomeController::class) // manage user
;
$app->exec();