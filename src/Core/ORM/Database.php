<?php

namespace Core\ORM;

use Core\Debug;
use PDO;

abstract class Database {

    private string $host, $user, $pass, $db;

    /**
     * Database constructor.
     */
    public function __construct() {
        $this->host = "127.0.0.1";
        $this->user = "root";
        $this->pass = "";
        $this->db = "instant";
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO {
        return new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
    }

    public function toInsert(array $data, string $table): string {
        // INSERT INTO `instant`.`users` (`username`, `email`, `pwd`, `roles`) VALUES ('username', 'efef', 'fe', 'efefe');
        /**
         * $queryPrepared = $connection->prepare("INSERT INTO pfh4_user (firstname, lastname, email, pwd) VALUES ( :firstname , :lastname , :email , :pwd );");
        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        $queryPrepared->execute(["firstname" => $firstname, "lastname" => $lastname, "email" => $email, "pwd" => $pwd]);
         */
        $columns = implode(", ",array_keys($data));
        $values  = implode(", ", array_values($data));
        $sql = "INSERT INTO " . $table . " ($columns) VALUES ($values)";
        return $sql;
    }
}