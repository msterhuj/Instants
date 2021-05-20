<?php

namespace Core\ORM;

abstract class Model extends Database {

    /**
     * @return string
     */
    public function getTableName(): string {
        $class = explode('\\', get_called_class());
        return strtolower($class[sizeof($class) - 1]);
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