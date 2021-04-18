<?php

error_reporting(E_ALL);

require '../includes/autoload.php';

use Core\App;
use App\Controller\HomeController;

$app = App::getInstance();

$user = new \App\Models\User();
$user->setPwd("test");
$user->save();


$app->getRouter()
    // public zone
    ->get('/', 'home', HomeController::class) // home page
    ->get('/signup', 'home', HomeController::class) // signup form
    ->post('/signup', 'home', HomeController::class) // sign up action
    ->get('/login', 'home', HomeController::class) // login form
    ->post('/login', 'home', HomeController::class) // login action
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
echo $app->exec();