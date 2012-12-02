<?php

// This sets our working directory to where this file is located.
chdir(__DIR__);

// This can give our other files the working directory path.
$GLOBALS['base'] = __DIR__;

// This starts our application!
require 'libraries/bootstrap.php';
$bootstrap = new Bootstrap();

