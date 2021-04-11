<?php

namespace Core;

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
        // todo exec code
        echo print_r($this->getRouter());
    }
}