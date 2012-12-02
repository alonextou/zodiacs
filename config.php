<?php

/* MySQL
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'zodiac');
define('DB_USER', 'username');
define('DB_PASS', 'password');
*/

/* SQLite */
define('DB_TYPE', 'sqlite');
define('DB_PATH', $GLOBALS['base'].'/data/zodiac.sqlite3');

define('LIBS', 'libraries/');