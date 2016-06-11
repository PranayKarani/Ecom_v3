<?php

require_once('../include/config.php');
require_once('../include/DBHandler.php');

// Controllers
require_once('../controllers/DepartmentController.php');
require_once '../controllers/CategoryController.php';
require_once '../controllers/ProductController.php';
require_once '../controllers/DepartmentController.php';
require_once '../controllers/ShopController.php';

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
