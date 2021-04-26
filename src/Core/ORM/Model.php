<?php

namespace Core\ORM;

use Core\Debug;

abstract class Model extends Database {

    private null|string $tablePrefix;
    private string $tableName;

    /**
     * Model constructor.
     */
    public function __construct(string $tabPrefix = null, string $tableName = null) {
        $this->tablePrefix = $tabPrefix;
        if (empty($tableName)) {
            $class = explode('\\', get_called_class());
            $this->tableName = $class[sizeof($class) - 1];
        } else $this->tableName = $tableName;
    }

    /**
     * @return string
     */
    public function getTableName(): string {
        return strtolower($this->tablePrefix . $this->tableName);
    }

    public function save() {
        $con = $this->getConnection();
        $con->exec($this->toInsert($this->getTableName()));
    }

    public function update() {
        $con = $this->getConnection();
        $con->exec($this->toUpdate($this->getTableName()));
    }

    public function delete() {}

}