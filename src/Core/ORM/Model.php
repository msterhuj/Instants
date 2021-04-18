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
        return $this->tablePrefix . $this->tableName;
    }

    /**
     * @return array
     */
    abstract protected function getData(): array;

    public function save() {
        $this->toInsert($this->getData(), $this->getTableName());
    }
    public function delete() {}

}