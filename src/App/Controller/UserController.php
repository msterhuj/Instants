<?php


namespace App\Controller;

use App\Exception\UserNotFoundException;
use App\Models\User;
use Core\Controller\Controller;
use Core\ORM\Database;
use Core\Router\Route;

class UserController extends Controller {

    public function profile() {
        try {
            $user = User::loadBy("username", Route::getRouteParam());

            $post = "";
            $reply = "";
            $like = "";

            // get post
            $prepare = Database::getPDO()
                ->prepare("select * from post where author = :id and replyTo is null order by createdAt desc");
            $prepare->execute(["id" => $user->getId()]);
            foreach ($prepare->fetchAll(\PDO::FETCH_ASSOC) as $item) {
                $post .= $this->render("post/post", [
                    "AUTHOR" => $user->getUsername(),
                    "PICTURE" => $user->getPicture(),
                    "CONTENT" => $item["content"],
                    "REPLY" => "",
                    "ID" => $item["id"]
                ], false, true);
            }

            // get reply
            $prepare = Database::getPDO()
                ->prepare("select * from post where author =:id and replyTo is not null order by createdAt desc");
            $prepare->execute(["id" => $user->getId()]);
            foreach ($prepare->fetchAll(\PDO::FETCH_ASSOC) as $item) {
                $reply .= $this->render("post/post", [
                    "AUTHOR" => $user->getUsername(),
                    "PICTURE" => $user->getPicture(),
                    "CONTENT" => $item["content"],
                    "REPLY" => "",
                    "ID" => $item["id"]
                ], false, true);
            }

            $this->appendJS(["post"])->render("profile", [
                "PICTURE" => $user->getPicture(),
                "USER" => $user->getUsername(),
                "POST" => $post,
                "REPLY" => $reply,
                "LIKE" => ""
            ]);
        } catch (UserNotFoundException $e) {
            $this->redirectTo("home");
        }
    }

    public function settings() {
        if (Controller::isGuest()) $this->redirectTo("login");

        if ($this->isGet()) {
            $this->setTemplate("intra")->render("settings", [
                "CSRF" => $this->generateCSRF()
            ]);
        } elseif ($this->isPost()) {
            $data = $this->getBody();
            $user = User::getFromSession();
            $user->setUsername($data["username"])
                ->setEmail($data["email"])
                ->setDescription($data["desc"]);
            if ($this->checkCSRF($data["csrf"])) $user->update();
            $this->redirectTo("settings");
        }
    }
}