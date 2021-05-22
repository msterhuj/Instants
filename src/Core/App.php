<?php

namespace Core;

use Core\Router\Router;
use Core\Router\RouterException;

class App {

    private static ?App $_instance = null;
    private Router $router;

    /**
     * App constructor.
     */
    public function __construct() {
        $this->router = new Router();
    }

    /**
     * @return Router
     */
    public function getRouter(): Router {
        return $this->router;
    }

    public function exec(): void {
        try {
            $route = $this->router->matchUrl($this->getRouter()->getRoutesByMethod($_SERVER['REQUEST_METHOD']));
            $callback = $route->getCallback();
            $func = $route->getName();
            $controller = new $callback;

            $_SESSION["ROUTE"] = $route;

            Stats::insertRequest();

            $controller->$func();
        } catch (RouterException $e) {
            echo "Route non trouvée";
        }
    }

    public static function getInstance(): App {
        if (is_null(self::$_instance))
            self::$_instance = new App();
        return self::$_instance;
    }
}