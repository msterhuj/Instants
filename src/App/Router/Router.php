<?php

namespace App\Router;


class Router {

    private $url;
    private $routes = [];

    public function __construct($url) {
        $this->url = $url;
    }

    public function get($path, $callable) {
        $route = new Route($path, $callable);
        $this->routes['GET'][] = $route;
    }

    public function post($path, $callable) {
        $route = new Route($path, $callable);
        $this->routes['POST'][] = $route;
    }

    public function run() {
        if (!isset($this->routes[$_SERVER["REQUEST_METHOD"]])) throw new RouterException("Methode not supported");

        foreach ($this->routes[$_SERVER["REQUEST_METHOD"]] as $route) {
            if ($route->match($this->url)) {
                return $route->call();
            }
        }

        if (!isset($this->routes[$_SERVER["REQUEST_METHOD"]])) throw new RouterException("Rout dose not exist");
    }
}