<?php

namespace Core\ORM;

use App\Config;
use PDO;

abstract class Database {
    /**
     * @return PDO
     */
    public function getConnection(): PDO {
        return new PDO("mysql:host=".Config::DB_HOST.
                            ";dbname=".Config::DB_NAME.",".
            Config::DB_USER, Config::DB_PASS);
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