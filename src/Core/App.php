<?php

namespace Core;

use Core\Router\Router;
use Core\Router\RouterException;
use JetBrains\PhpStorm\Pure;

class App {

    private Router $router;

    #[Pure] public function __construct() {
        $this->router = new Router();
    }

    public function getRouter(): Router {
        return $this->router;
    }

    public function exec() {

        try {
            $route = $this->router->matchUrl($this->getRouter()->getRoutesByMethod($_SERVER['REQUEST_METHOD']));
            $callback = $route->getCallback();
            $func = $route->getName();
            $controller = new $callback;

            if (empty($route->getParam())) $controller->$func();
            else $controller->$func($route->getParam());
        } catch (RouterException $e) {
            echo '404';
            // catch 404 route here
        }

    }
}