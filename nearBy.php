<?php

require_once('include/config.php');
require_once('include/DBHandler.php');

// Controllers
require_once('controllers/ProductController.php');
require_once('controllers/CategoryController.php');
require_once('controllers/ShopController.php');

// Views
require_once('views/templates/header.php');
require_once('views/ProductView.php');
require_once('views/CategoryView.php');
require_once('views/ShopView.php');

if (isset($_GET['category'])) {
    $category = $_GET['category'];
    echo "<input type='hidden' id='$category' class='data'/>";
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NearBy</title>
    <link rel="stylesheet" href="views/styles/header_style.css">
    <link rel="stylesheet" href="views/styles/common_style.css">
    <link rel="stylesheet" href="views/styles/nearby_style.css">
    <!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
    <script src="../jquery-2.2.3.min.js"></script>
    <script src="views/scripts/header_script.js"></script>
    <script src="views/scripts/nearby_script.js"></script>
</head>
<body>
<?php Header::show() ?>

<div id="center_section">

    <div id="center_top">
        <div id="center_top_left">
            <?php
            if (isset($category)) {
                echo "searching map for $category";
            }
            ?>
        </div>
        <div id="center_top_right">
            <?php
            if (isset($category)) {
                ShopView::showCategoryShops($category);
            }
            ?>
        </div>
    </div>
    <div id="center_middle">

        <?php
        if (isset($category)) {
            ProductView::showCategoryTopProducts($category);
        }
        ?>
    </div>
    <div id="center_bottom">

        <?php
        if (isset($category)) {
            ProductView::showCategoryNewProducts($category);
        }
        ?>
    </div>
</div>

</body>
</html>
