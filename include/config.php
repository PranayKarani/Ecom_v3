<?php

define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DB', 'ecom_v3');
define('PDO_DSN', 'mysql:host=' . HOST . ';dbname=' . DB);

define('COOKIE_LOGGEDIN', 'loggedIn');
define('COOKIE_USER_ID', 'UID');
define('COOKIE_USER_NAME', 'UN');

define('RPP', 8);// results per page

define('ESC_STR', serialize(array( '+', '-', '*', '~', '@', '%', '(', ')', '<', '>', '\'', '"', '\\', '#' )));