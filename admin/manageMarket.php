<?php

require_once('include/config.php');
require_once('include/DBHandler.php');

// Controllers
require_once 'controllers/ProductController.php';
require_once 'controllers/DepartmentController.php';
require_once 'controllers/CategoryController.php';
require_once 'controllers/BrandController.php';
require_once 'controllers/ShopController.php';

// Views
require_once('views/templates/SearchBox.php');
require_once('views/ProductView.php');
require_once('views/DepartmentView.php');
require_once('views/CategoryView.php');
require_once('views/BrandView.php');
require_once('views/ShopView.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

if (isset($id)) {
    $shopView = new ShopView($id);
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Shop</title>
    <link rel="stylesheet" href="views/styles/manage_shop_style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <!--    <script src="../../jquery-2.2.3.min.js"></script>-->
    <script src="views/scripts/manage_shop_script.js"></script>
</head>
<body>
<div id="left_section">
    <?php SearchBox::show("search for shops") ?>
</div>
<div id="center_section">
    <div id="center_top">
        <h3>Shop Details</h3>
        <?php
        if (isset($id)) {
            $shopView->show_details();
        }
        ?>
    </div>
    <input type="button" value="Remove this shop" id="delete_shop_button"
           style="background-color: indianred; color: white; font-size: large">
    <div id="center_bottom">
        <h3>Shop Products</h3>
        <?php
        if (isset($id)) {
            $shopView->show_products();
        }
        ?>
    </div>
</div>
<div id="right_section">
    <?php
    ShopView::showAddNewShop();
    ?>
</div>

</body>
</html>

