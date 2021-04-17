<?php

namespace Core;

use Core\Router\Router;
use Core\Router\RouterException;

class App {

    private static $_instance = null;
    private Router $router;

    public function __construct() {
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

            return $controller->$func($route);
        } catch (RouterException $e) {
            echo '404';
            // catch 404 route here
        }
    }

    public static function getInstance(): App {
        if (is_null(self::$_instance)) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }
}