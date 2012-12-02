<?php

class Database Extends PDO {

    public function __construct() {
        parent::__construct('sqlite:'.DB_PATH);
        parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
        $query = $this->prepare($sql);
        foreach ($array as $key => $value) {
            $query->bindValue("$key", $value);
        }
        $query->execute();
        return $query->fetchAll($fetchMode);
    }

}