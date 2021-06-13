<?php

namespace App\Controller;

use App\Models\User;
use Core\Controller\Controller;
use Core\Debug;
use Core\ORM\Database;
use Core\Router\Route;

class MessagesController extends Controller {

    public function canMP() {
        if (self::isGuest()) $this->redirectTo("home");
        $user = User::getFromSession();
        if (!$user->isFollowee(Route::getRouteParam())) {
            echo "vous ne suivez pas cette perssone :(";
            return false;
        }
        $user_recv = User::loadBy("id", Route::getRouteParam());
        if (!$user_recv->isFollowee($user->getId())) {
            echo "ho non il ne te suis pas tu ne peut pas parler avec lui :(";
            return false;
        }
        return true;
    }

    public function index() {}

    public function private_fetch() {
        if (!$this->canMP()) return;
        $user = User::getFromSession();
        $user_recv = User::loadBy("id", Route::getRouteParam());

        $prepare = Database::getPDO()->prepare("select * from messages where sender = :s and receiver = :r or  sender = :r and receiver = :s order by createdAt asc;");
        $prepare->execute([
            "s" => $user->getId(),
            "r" => $user_recv->getId()
        ]);
        echo json_encode($prepare->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function private_msg() {
        if (!$this->canMP()) return;
        $user = User::getFromSession();
        $user_recv = User::loadBy("id", Route::getRouteParam());

        if ($this->isGet()) {
            $this->setTemplate("intra")
                ->appendJS(["msg"])
                ->render("messages/mp", [
                    "AUTHOR" => $user_recv->getUsername(),
                    "PICTURE" => $user_recv->getPicture()
                ]);
        } elseif ($this->isPost()) {
            $data = $this->getBody();
            $con = Database::getPDO();
            $prepare = $con->prepare("insert into messages (sender, receiver, content) values (:sender, :receiver, :content)");
            $prepare->execute([
                "sender" => $user->getId(),
                "receiver" => $user_recv->getId(),
                "content" => $data["msg"]
            ]);
        }
    }
}