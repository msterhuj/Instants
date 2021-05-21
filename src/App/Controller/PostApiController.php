<?php

namespace App\Controller;

use App\Models\Post;
use Core\Controller\Controller;
use Core\Debug;
use Core\Router\Route;

class PostApiController extends Controller {

    public function post() {
        if ($this->isPost()) {
            $data = $this->getBody();
            if (!empty($data['content'])) {
                $post = new Post();
                $post->setContent($data['content']);
                if (!empty($data['reply'])) $post->setReplyTo(Post::loadBy('id', $data['reply']));
                $post->save();
            }
        }
    }

    public function like() {
        $post = Post::loadBy("id", Route::getRouteParam());
        $post->like();
    }
}