<?php

namespace Core;

abstract class Controller {

    public function render(string $file, array $args) {
        return "oui ca ces sur";
    }

    public function getUrl(string $name, array $param = null) {
        // todo
    }
}