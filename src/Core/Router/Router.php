<?php

namespace Core\Router;

class Router {

    /**
     * @var Route[]
     */
    private array $routes;

    /**
     * Router constructor.
     */
    public function __construct() {
        $this->routes = [];
    }

    /**
     * @param string $url
     * @param string $name
     * @param $callback
     * @return $this
     */
    public function get(string $url, string $name, $callback): Router {
        $this->routes[] = new Route('GET', $url, $name, $callback);
        return $this;
    }

    /**
     * @param string $url
     * @param string $name
     * @param $callback
     * @return $this
     */
    public function post(string $url, string $name, $callback): Router {
        $this->routes[] = new Route('POST', $url, $name, $callback);
        return $this;
    }

    /**
     * @return Route[]
     */
    public function getRoutesByMethod(string $method): array {
        $result = [];
        foreach ($this->routes as $item) {
            if ($item->getMethod() == $method) $result[] = $item;
        }
        return $this->routes;
    }

    /**
     * @param string $name
     * @return Route
     * @throws RouterException
     */
    public function getRoutesByName(string $name): Route {
        $result = [];
        foreach ($this->routes as $item) {
            if ($item->getName() == $name)
                return $item;
        }
        throw new RouterException();
    }

    /**
     * @param Route[] $routes
     * @return Route
     * @throws RouterException
     */
    public function matchUrl(array $routes): Route {
        $request_url = trim($_SERVER["REQUEST_URI"], '/');
        foreach ($routes as $route) {
            $route_url = trim($route->getUrl(), '/');
            $route_url = preg_replace('(:::)', '([a-zA-Z-0-9]+)', $route_url);
            $route_url = "#^$route_url$#i";
            if (!preg_match($route_url, $request_url, $matches))
                continue;
            $route->setUrl($route_url);
            if (sizeof($matches) > 1) {
                array_shift($matches);
                $route->setParam($matches[0]);
            }
            return $route;
        }
        throw new RouterException();
    }
}