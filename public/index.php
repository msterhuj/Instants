<?php
require '../includes/autoload.php';

use App\Router\Router;
use App\Router\RouterException;

use App\Views\HomeView;

$router = new Router($_GET["url"]);

$router->get("/", function () { new HomeView(); });
$router->get("/admin/:id", function ($id) { echo "ee".$id; });

try {
    $router->run();
} catch (RouterException $e) {
    echo $e;
}