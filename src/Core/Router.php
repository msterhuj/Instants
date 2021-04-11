<?php

namespace Core;

class Router {

    private array $routes = [];

    public function get(string $url, $callback) {
        $this->routes['get'][$url] = $callback;
        return $this;
    }

    public function post(string $url, $callback) {
        $this->routes['post'][$url] = $callback;
        return $this;
    }
}