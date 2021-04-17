<?php

namespace Core\ORM;

use PDO;

abstract class Database {

    private string $host, $user, $pass, $db;

    /**
     * Database constructor.
     * @param string $host
     * @param string $user
     * @param string $pass
     * @param string $db
     */
    public function __construct(string $host, string $user, string $pass, string $db) {
        $this->host = "";
        $this->user = "";
        $this->pass = "";
        $this->db = "";
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO {
        return new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
    }
}