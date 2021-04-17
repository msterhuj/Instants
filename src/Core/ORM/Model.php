<?php

namespace Core\ORM;

abstract class Model extends Database {

    private string $table;

    /**
     * Model constructor.
     */
    public function __construct() {
        $this->table = get_called_class();
    }


    public function save() {}
    public function delete() {}

}