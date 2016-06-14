<?php

require_once('../include/config.php');
require_once('../include/DBHandler.php');

// Controllers
require_once('../controllers/ABrandController.php');
require_once '../controllers/ACategoryController.php';
require_once '../controllers/AProductController.php';
require_once '../controllers/ASearchController.php';
require_once '../controllers/ADepartmentController.php';
require_once '../controllers/AShopController.php';

// Views
require_once '../views/ABrandView.php';
require_once '../views/ACategoryView.php';

$dir = $_POST['dir'];
$class = $_POST['class'];
$method = $_POST['method'];
$params = $_POST['params'];

require_once ("../$dir/".$class.".php");
if(method_exists($class,$method)){
    $class::$method($params);
} else {
    trigger_error("No such method like $method in $class");
}

