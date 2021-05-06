<?php

namespace Core\Controller;

use Core\App;
use Core\Router\RouterException;
use Exception;

abstract class Controller extends View {

    /**
     * @param string $name
     * @param string|null $param
     * @return string
     * @throws RouterException
     */
    public static function getUrl(string $name, string $param = null): string {
        $app = App::getInstance();
        $router = $app->getRouter()->getRoutesByName($name);
        return preg_replace('(:::)', $param, $router->getUrl());
    }

    /**
     * @param string $routeName
     * @param string|null $param
     * @throws RouterException
     */
    public function redirectTo(string $routeName, string $param = null): void {
        header('Location: ' . self::getUrl($routeName, $param));
    }

    public static function isGest(): bool {
        return !isset($_SESSION["USER"]);
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
     * @return bool
     */
    public function isError(): bool {
        return isset($_SERVER["ERROR"]);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function generateCSRF(): string {
        return $_SESSION['CSRF'] = bin2hex(random_bytes(32));
    }

    /**
     * @param string $token
     * @return bool
     */
    public function checkCSRF(string $token): bool {
        return $_SESSION['CSRF'] == $token;
    }
}