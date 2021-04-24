<?php

namespace Core\ORM;

abstract class Model extends Database {

    private null|string $tablePrefix;
    private string $tableName;

    /**
     * Model constructor.
     */
    public function __construct(string $tabPrefix = null, string $tableName = null) {
        parent::__construct();
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

    public function save(bool $new = false) {
        $con = $this->getConnection();
        echo $this->toInsert($this->getTableName());
        if ($new)
            $con->exec($this->toInsert($this->getTableName()));
        else
            echo $this->toUpdate($this->getTableName()); //todo setup update entity
    }

    public function delete() {}

}