<?php

class View {

    function __construct() {
        // echo 'View';
    }

    function render($name) {
        require 'views/' . $name . '.php';
    }

}