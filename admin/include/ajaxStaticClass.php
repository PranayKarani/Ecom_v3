<?php

require_once('../include/config.php');
require_once('../include/DBHandler.php');

// Controllers
require_once('../controllers/BrandController.php');
require_once '../controllers/CategoryController.php';
require_once '../controllers/ProductController.php';
require_once '../controllers/SearchController.php';
require_once '../controllers/DepartmentController.php';
require_once '../controllers/ShopController.php';

// Views
require_once '../views/BrandView.php';
require_once '../views/CategoryView.php';

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

