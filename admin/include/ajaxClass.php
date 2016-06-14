<?php

require_once('../include/config.php');
require_once('../include/DBHandler.php');

// Controllers
require_once('../controllers/ADepartmentController.php');
require_once '../controllers/ACategoryController.php';
require_once '../controllers/AProductController.php';
require_once '../controllers/ADepartmentController.php';
require_once '../controllers/AShopController.php';

//$dir = $_POST['dir'];
$class = $_POST['class'];
$method = $_POST['method'];
$params = $_POST['params'];

//if($dir != 'views')
//    die("not allowed to connect to any directory other than views");

require_once ("../views/".$class.".php");
$c = new $class;
if(method_exists($c,$method)){
    $c->$method($params);
} else {
    trigger_error("No such method like $method in $class");
}
