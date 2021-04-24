<?php

namespace Core\ORM;

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
        $this->db = "instants";
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO {
        return new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
    }

    /**
     * @return array
     */
    abstract protected function getData(): array;

    /**
     * @param string $table
     * @return string
     */
    protected function toInsert(string $table): string {
        $columns = "";
        $values = "";
        foreach ($this->getData() as $key => $value) {
            if (!empty($value)) {
                $columns .= $key . ",";
                $values .= "'" . $value . "',";
            }
        }
        $columns = trim($columns, ",");
        $values = trim($values, ",");
        return "INSERT INTO " . $table . " ($columns) VALUES ($values)";
    }

    protected function toUpdate(string $table): string {
        $columns = "";
        $values = "";
        foreach ($this->getData() as $key => $value) {
            if (!empty($value)) {
                $columns .= $key . ",";
                $values .= "'" . $value . "',";
            }
        }
        $columns = trim($columns, ",");
        $values = trim($values, ",");
        return "update user set vreg = null where vreg = '60843f887d9fd'";
    }
}