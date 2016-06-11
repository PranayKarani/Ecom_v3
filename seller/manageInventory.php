<?php

require_once('include/config.php');
require_once('include/DBHandler.php');

// Controllers
require_once 'controllers/ProductController.php';
require_once 'controllers/SellerController.php';
//require_once 'controllers/BrandController.php';

// Views
require_once 'views/templates/SearchBox.php';
require_once 'views/SearchView.php';
require_once 'views/ShopView.php';


if (isset($_GET['id'])) {
    $seller_id = $_GET['id'];
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Inventory</title>
    <link rel="stylesheet" href="views/styles/manage_inventory_style.css">
    <!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
    <script src="../../jquery-2.2.3.min.js"></script>
    <script src="views/scripts/manage_inventory_script.js"></script>
</head>
<body>
<div id="top_section">
    <?php
    if (isset($seller_id)) {
        ShopView::showShopsSelector($seller_id,"shop_selector");
    }
    ?>
    <input type="button" value="go" id="shop_select_button"/>
    <div id="logout">logout</div>
</div>
<div id="left_section">

        <?php SearchBox::show("search for products") ?>

</div>
<div id="center_section"></div>
<div id="right_section"></div>


</body>
</html>
