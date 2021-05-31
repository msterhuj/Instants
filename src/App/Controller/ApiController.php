<?php

namespace App\Controller;

use App\Models\Post;
use App\Models\User;
use Core\Controller\Controller;
use Core\ORM\Database;
use Core\Router\Route;

class ApiController extends Controller {

    public function nextPost() {
        if ($this->isGet()) {
            $offset = intval(Route::getRouteParam());
            $con = Database::getPDO();
            $prepare = $con->prepare("select * from post where replyTo is null order by createdAt desc limit 5 offset $offset");
            $prepare->execute();
            $content = "";
            $data = $prepare->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($data as $key => $post) {
                $user = User::loadBy("id", $post["author"]);
                $content .= $this->render("post/post", [
                    "AUTHOR" => $user->getUsername(),
                    "PICTURE" => $user->getPicture(),
                    "CONTENT" => $post["content"]
                ], false, true);
            }
            echo $content;
        }
    }

    public function post() {
        if (Controller::isGuest()) return;
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
        if (Controller::isGuest()) return;
        $post = Post::loadBy("id", Route::getRouteParam());
        $post->like();
    }

    public function isFollowee() {
        $user = User::loadBy("id", Route::getRouteParam());
        echo $user->isFollowee();
    }

    public function followee() {
        if (Controller::isGuest()) return;
        $user = User::getFromSession();
        $user->follow();
    }
}