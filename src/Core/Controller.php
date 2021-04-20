<?php

namespace Core;

abstract class Controller extends View {

    public function getUrl(string $name, array $params = null) {}
    public function redirectTo(string $routeName, array $params = null) {}

    public function isGet(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    public function isPost(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function getBody(): array {
        $data = [];
        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $data;
    }
}