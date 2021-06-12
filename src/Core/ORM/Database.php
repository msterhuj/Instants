<?php

namespace Core\ORM;

use App\Config;
use PDO;
use Serializable;

abstract class Database implements Serializable {

    public static function getPDO(): PDO {
        return new PDO("mysql:host=".Config::DB_HOST.";dbname=".Config::DB_NAME,
            Config::DB_USER, Config::DB_PASS);
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO {
        return self::getPDO();
    }

    /**
     * @return array
     */
    abstract protected function getData(): array;

    /**
     * @param string $key
     * @param string $value
     * @return mixed
     */
    abstract public static function loadBy(string $key, string $value): mixed;

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
                $values .= "'" . htmlspecialchars($value, ENT_QUOTES) . "',";
            }
        }
        $columns = trim($columns, ",");
        $values = trim($values, ",");
        return "INSERT INTO $table ($columns) VALUES ($values)";
    }

    /**
     * @param string $table
     * @return string
     */
    protected function toUpdate(string $table): string {

        $newObj = $this->getData();
        $oldObj = get_called_class()::loadBy("id", $newObj["id"])->getData();

        $set = "";

        foreach ($newObj as $key => $value) {
            if ($oldObj[$key] != $newObj[$key]) {
                $values = "'" . $value . "',";
                if (empty($value)) $set .= $key . " = " . 'null,';
                else $set .= $key . " = " . $values;
            }
        }
        $set = trim($set, ",");
        return 'update ' . $table . ' set '.  $set . ' where id = ' . $newObj["id"];
    }

    protected function toDelete(string $table): string {
        return "delete from user where id = " . $this->getData()["id"] . " limit 1";
    }
}