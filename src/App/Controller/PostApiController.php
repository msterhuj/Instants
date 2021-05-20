<?php

namespace App\Controller;

use Core\Controller\Controller;
use Core\Debug;

class PostApiController extends Controller {

    public function post() {
        // todo
        Debug::dump($this->getBody());
    }

}