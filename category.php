<?php

require_once('include/config.php');
require_once('include/DBHandler.php');

// Controllers
require_once('controllers/BrandController.php');
require_once('controllers/CategoryController.php');
require_once('controllers/ProductController.php');

// Views
require_once('views/templates/header.php');
require_once('views/BrandView.php');
require_once('views/CategoryView.php');
require_once('views/ProductView.php');


if (isset($_GET['category'])) {
    $category = $_GET['category'];
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="views/styles/header_style.css">
    <link rel="stylesheet" href="views/styles/category_style.css">
    <!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
    <script src="../jquery-2.2.3.min.js"></script>
    <script src="views/scripts/header_script.js"></script>
    <script src="views/scripts/category_script.js"></script>
</head>
<body>
<?php Header::show() ?>
<div id="left_section">

    <div id="left_top">
        <strong style='font-size: larger'>Brands</strong><br>
        <?php

        if (isset($category)) {
            BrandView::showCategoryBrands($category);
        } else {
            echo ":(";
        }

        ?>
    </div>
    <div id="left_bottom">

        <?php

        if (isset($category)) {
            CategoryView::showFilters($category);
        } else {
            echo ":(";
        }

        ?>
    </div>

</div>
<div id="center_section">

    <div id="center_top">
        <?php
        if (isset($category)) {
            echo "<strong>$category</strong>";
        }
        ?>
    </div>
    <button>Find Nearby shops <?php if (isset($category)) {
            echo "for $category";
        } ?></button>
    <div id="center_middle">
        <strong>Top Products</strong><br>
        <?php
        if (isset($category)) {
            ProductView::getCategoryTopProducts($category);
        }
        ?>
    </div>
    <div id="center_bottom">
        <strong>New Products</strong><br>
        <?php
        if (isset($category)) {
            ProductView::getCategoryNewProducts($category);
        }
        ?>
    </div>

</div>
</body>
</html>
