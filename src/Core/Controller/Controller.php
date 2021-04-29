<?php

namespace Core\Controller;

use Exception;

abstract class Controller extends View {

    public function getUrl(string $name, string $param = null) {
        $app = App::getInstance();
        $router = $app->getRouter()->getRoutesByName($name);
        return preg_replace('(:::)', $param, $router->getUrl());
    }

    public function redirectTo(string $routeName, string $param = null) {
        header('Location: ' . $this->getUrl($routeName, $param));
    }

    /**
     * @return bool
     */
    public function isGet(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    /**
     * @return bool
     */
    public function isPost(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * @return array
     */
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

    /**
     * @return string
     * @throws Exception
     */
    public function generateCSRF(): string {
        return $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }

    /**
     * @param string $token
     * @return bool
     */
    public function checkCSRF(string $token): bool {
        return $_SESSION['csrf'] == $token;
    }
}