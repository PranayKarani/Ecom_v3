<?php

require_once('include/config.php');
require_once('include/DBHandler.php');

// Controllers
require_once('controllers/ProductController.php');
require_once('controllers/ShopController.php');

// Views
require_once('views/templates/header.php');
require_once('views/ProductView.php');
require_once('views/ShopView.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];// shop id
}

if (isset($_GET['category'])) {
    $category = $_GET['category'];
    echo "<input type='hidden' id='$category' class='data'/>";
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop</title>
    <link rel="stylesheet" href="views/styles/header_style.css">
    <link rel="stylesheet" href="views/styles/shop_style.css">
    <!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
    <script src="../jquery-2.2.3.min.js"></script>
    <script src="views/scripts/header_script.js"></script>
    <script src="views/scripts/shop_script.js"></script>
</head>
<body>
<?php Header::show(); ?>
<div id="top_section">
    <div id="top_left"><?php

        if (isset($id)) {
            ShopView::showShopInfo($id);
        }

        ?></div>
    <div id="top_center">Shop Map</div>
    <div id="top_right">
        <?php

        if (isset($id)) {
            ShopView::showSimilarShops($id);
        }

        ?>
    </div>
</div>
<div id="middle_section">
    <?php
    if (isset($category) && isset($id)) {
        echo "<h3>$category" . "s in this shop</h3>";

        ProductView::showShopCategoryProducts($id, $category);
    }
    ?>
</div>
<div id="bottom_section">
    <?php
    if (isset($id)) {
        echo "<h3>All products of this shop</h3>";

        ProductView::showShopProducts($id);
    }
    ?>
</div>

</body>
</html>