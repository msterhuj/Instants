<?php

namespace Core;

use Core\Router\Router;
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

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            $route = $this->router->matchUrl($this->getRouter()->getRoutesByMethod('GET'));

        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //
        } else {
            // todo return 404
        }
    }
}