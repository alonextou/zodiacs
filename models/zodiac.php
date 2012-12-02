<?php

class ZodiacModel extends Model {

    function __construct() {
        parent::__construct();
    }

    function getAll() {
        return $this->db->select('SELECT id, name, season, element FROM zodiacs');
    }

    function create($zodiac) {

    }

}