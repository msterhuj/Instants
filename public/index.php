<?php

require '../includes/autoload.php';
session_start();

unset($_SESSION['ERROR']);

use App\Controller\MessagesController;
use Core\App;
use App\Controller\HomeController;
use App\Controller\AuthController;
use App\Controller\AdminController;
use App\Controller\ApiController;
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
    // admin zone
    ->get('/admin/', 'admin', AdminController::class) // General admin info
    ->get('/admin/report', 'admin_report', AdminController::class) // manage report
    ->get('/admin/users', 'admin_users', AdminController::class) // manage user
    ->get('/admin/user/:::/ban', 'admin_user_ban', AdminController::class) // ban or unban user by id
    ->get('/admin/user/:::/delete', 'admin_user_delete', AdminController::class) // delete user by id
    // api
    ->get('/api/post/:::', 'nextPost', ApiController::class)
    ->post('/api/post', 'post', ApiController::class)
    ->get('/api/like/:::', 'like', ApiController::class)
    ->get('/api/like/:::/check', 'isLike', ApiController::class)
    ->get('/api/followee/:::', 'followee', ApiController::class)
    ->get('/api/followee/:::/check', 'isFollowee', ApiController::class)
    ->post('/api/search', 'search', ApiController::class)
    ->get('/api/stats/graf', 'stats_graf', ApiController::class)
    // user zone
    ->get('/logout', 'logout', AuthController::class) // logout user
    ->get('/report/', 'home', HomeController::class) // report a post
    ->get('/contact/', 'home', HomeController::class) // contact page
    ->get('/messages/', 'index', MessagesController::class) // all private message
    ->get('/messages/:::', 'private_msg', MessagesController::class) // private with user
    ->get('/messages/:::/fetch', 'private_fetch', MessagesController::class) // private with user
    ->post('/messages/:::', 'private_msg', MessagesController::class) // add msg in private user
    ->get('/settings/', 'home', HomeController::class) // settings of user
    ->get('/p/:::', 'profile', UserController::class)
;
$app->exec();