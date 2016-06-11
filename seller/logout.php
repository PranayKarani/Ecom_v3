<?php


session_start();

$_SESSION['seller_loggedIn'] = false;
unset($_SESSION['seller_loggedIn']);
unset($_SESSION['seller_id']);
