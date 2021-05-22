<?php

namespace App\Controller;

use App\Models\Post;
use App\Models\User;
use Core\Controller\Controller;
use Core\Router\Route;

class ApiController extends Controller {

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

    public function isLike() {
        $post = Post::loadBy("id", Route::getRouteParam());
        echo $post->isLiked();
    }

    public function like() {
        $post = Post::loadBy("id", Route::getRouteParam());
        $post->like();
    }

    public function isFollowee() {
        $user = User::loadBy("id", Route::getRouteParam());
        echo $user->isFollowee();
    }

    public function followee() {
        $user = User::loadBy("id", Route::getRouteParam());
        $user->follow();
    }
}