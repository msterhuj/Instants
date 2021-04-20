<?php

namespace Core;

abstract class Controller {

    public function getUrl(string $name, array $params = null) {}
    public function redirectTo(string $routeName, array $params = null) {}

    public function isGet(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    public function isPost(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}