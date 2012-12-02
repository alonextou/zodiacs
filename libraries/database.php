<?php

class Database Extends PDO {

    public function __construct() {

        if (DB_TYPE == 'sqlite') {
            parent::__construct('sqlite:'.DB_PATH);
        } else if (DB_TYPE == 'mysql' ) {
            parent::__construct('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        }
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