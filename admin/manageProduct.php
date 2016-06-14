<?php

require_once('include/config.php');
require_once('include/DBHandler.php');

// Controllers
require_once 'controllers/AProductController.php';
require_once 'controllers/ACategoryController.php';
require_once 'controllers/ABrandController.php';

// Views
require_once('views/templates/SearchBox.php');
require_once('views/AProductView.php');
require_once('views/ACategoryView.php');
require_once('views/ABrandView.php');

if (isset($_GET['id'])) {
    $pID = $_GET['id'];
}

if (isset($pID)) {
    $productView = new AProductView($pID);
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage X Product</title>
    <link rel="stylesheet" href="views/styles/manage_product_style.css">
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
    <script src="../../jquery-2.2.3.min.js"></script>
    <script src="views/scripts/manage_product_script.js"></script>
</head>
<body>
<div id="left_section">
    <?php SearchBox::show("search for products") ?>
</div>
<div id="center_section">
    <diV id="center_top">
        <h3>Product Basic Details</h3>
        <?php
        if (isset($productView)) {
            $productView->show_basic_for_admin();
        }
        ?>
    </diV>
    <div id="center_bottom">
        <h3>Product Advance Details</h3>
        <?php
        if (isset($productView)) {
            $productView->show_advance_for_admin();
        }
        ?>
    </div>
    <input type="button" value="Delete this product" id="delete_product_button"
           style="background-color: indianred; color: white; font-size: large">
</div>
<div id="right_section">
    <div id="right_top">
        <h3>Add New Product</h3>
        <strong>Select Category for the Product:</strong> <br>
        <?php ACategoryView::showCategorySelector("Electronics", "new_product_category") ?>
        <input type="button" value="add new product" id="add_new_product_button"/>
    </div>
    <div id="right_center">
<!--    advanced details input fields-->
    </div>
    <div id="right_bottom">
        <strong>Add a new brand</strong><br>
        <input type="text" id="new_brand_name"/><br>
        <input type="button" value="add new Brand" id="add_new_brand_button"/>
    </div>
</div>

</body>
</html>
