<?php


namespace Core;


use Core\ORM\Database;

class Stats {

    public static function insertRequest() {
        $con = Database::getPDO();
        $prepare = $con->prepare("insert into stats (ip, user, url) values (:ip, :user, :route);");
        $prepare->execute([
            "ip" => $_SERVER['REMOTE_ADDR'],
            "user" => (isset($_SESSION['USER'])) ? $_SESSION['USER'] : null,
            "route" => $_SERVER['REQUEST_URI']
        ]);
    }

}