<?php

namespace Core\Router;

use Core\Debug;
use JetBrains\PhpStorm\Pure;

class Router {

    /**
     * @var Route[]
     */
    private array $routes;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->routes = [];
    }

    public function get(string $url, string $name, $callback) {
        $this->routes[] = new Route('GET', $url, $name, $callback);
        return $this;
    }

    public function post(string $url, string $name, $callback) {
        $this->routes[] = new Route('POST', $url, $name, $callback);
        return $this;
    }

    /**
     * @return Route[]
     */
    #[Pure] public function getRoutesByMethod(string $method): array {

        $result = [];

        foreach ($this->routes as $item) {
            if ($item->getMethod() == $method) $result[] = $item;
        }
        return $this->routes;
    }

    /**
     * @param Route[] $routes
     * @return Route|null
     */
    public function matchUrl(array $routes): ?Route {
        // check if ::: in possible url and generate regex to check
        foreach ($routes as $route) {
            $route->match();
        }
        return null;
    }
}