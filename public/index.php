<?php

require '../includes/autoload.php';

use Core\App;
use App\Controller\HomeController;

//print "The request path is : " . $_SERVER['PATH_INFO'];

$app = new App();

$app->getRouter()
    // public zone
    ->get('/', [HomeController::class, 'home']) // home page
    ->get('signup', [])
    ->get('login', [])
    ->get('/post/:::', []) // show post
    ->get('/profile/:::', []) // show profile of user
    // user zone
    ->get('/logout', []) // logout user
    ->get('/bookmarks/', []) // all post saved
    ->get('/report/', []) // report a post
    ->get('/support/', []) // support tech
    ->get('/messages/', []) // all private message
    ->get('/messages/:::', []) // private with user
    ->get('/settings/', []) // settings of user
    // admin zone
    ->get('/admin/', []) // General admin info
    ->get('/admin/report', []) // manage report
    ->get('/admin/support', []) // manage support ask
    ->get('/admin/users', []) // manage user
;
$app->exec();