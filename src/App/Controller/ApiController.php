<?php

namespace App\Controller;

use App\Exception\PostNotFoundException;
use App\Models\Post;
use App\Models\User;
use Core\Controller\Controller;
use Core\Debug;
use Core\ORM\Database;
use Core\Router\Route;
use PDO;

class ApiController extends Controller {

    public function nextPost() {
        if ($this->isGet()) {
            $offset = intval(Route::getRouteParam());
            $con = Database::getPDO();
            $followWhere = " ";


            if (!Controller::isGuest() && isset($_COOKIE["POST_FOLLOW_ONLY"])) {

                $prepare = $con->prepare("select followee from follow where follower = :id");
                $prepare->execute([
                    "id" => User::getFromSession()->getId()
                ]);
                foreach ($prepare->fetchAll(\PDO::FETCH_ASSOC) as $followee)
                    $followWhere .= " or author = " . $followee["followee"];
                $followWhere = "and " . trim($followWhere, " or ");
            }
            $prepare = $con->prepare("select * from post where replyTo is null " . $followWhere .  " order by createdAt desc limit 5 offset $offset");
            $prepare->execute();
            $content = "";
            $data = $prepare->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($data as $post) {
                $replys = "";
                $prepare = $con->prepare("select * from post where replyTo = :id");
                $prepare->execute([
                    "id" => $post["id"]
                ]);
                $replyData = $prepare->fetchAll(\PDO::FETCH_ASSOC);
                foreach ($replyData as $reply) {
                    $replys .= $this->render("post/replyData", [
                        "CONTENT" => $reply["content"],
                        "AUTHOR" => User::loadBy("id", $reply["author"])->getUsername()
                    ], false, true);
                }

                $user = User::loadBy("id", $post["author"]);
                $content .= $this->render("post/post", [
                    "AUTHOR" => $user->getUsername(),
                    "PICTURE" => $user->getPicture(),
                    "CONTENT" => $post["content"],
                    "ID" => $post["id"],
                    "REPLY" => $replys
                ], false, true);
            }
            echo $content;
        }
    }

    /**
     * @throws PostNotFoundException
     */
    public function post() {
        if (Controller::isGuest()) return;
        if ($this->isPost()) {
            $data = $this->getBody();
            if (!empty($data['content'])) {
                $post = new Post();
                Debug::print($data);
                $post->setContent($data['content']);
                if (isset($data['reply'])) $post->setReplyTo(Post::loadBy('id', $data['reply']));
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

    public function search() {
        $data = $this->getBody();

        $con = Database::getPDO();

        $prepare = "";
        if ($data["type"] == "user") $prepare = $con->prepare("select * from user where username like :data");
        else $prepare = $con->prepare("select * from post where content like :data;");

        $prepare->execute([
            "data" => '%' . $data["data"] . '%'
        ]);

        echo json_encode($prepare->fetchAll(PDO::FETCH_ASSOC));
    }

    public function stats_graf() {
        $con = Database::getPDO();

        // day now
        $dn = $con->query("select id from stats where createdAt > now() - interval 1 day;")->rowCount();
        // day -1
        $d1 = $con->query("select id from stats where createdAt > now() - interval 2 day;")->rowCount() - $dn;
        // day -2
        $d2 = $con->query("select id from stats where createdAt > now() - interval 3 day;")->rowCount() - $d1;
        // day -3
        $d3 = $con->query("select id from stats where createdAt > now() - interval 4 day;")->rowCount() - $d2;
        // day -4
        $d4 = $con->query("select id from stats where createdAt > now() - interval 5 day;")->rowCount() - $d3;
        // day -5
        $d5 = $con->query("select id from stats where createdAt > now() - interval 6 day;")->rowCount() - $d4;
        // day -6
        $d6 = $con->query("select id from stats where createdAt > now() - interval 7 day;")->rowCount() - $d5;

        echo json_encode([$d6, $d5, $d4, $d3, $d2, $d1, $dn]);
    }
}