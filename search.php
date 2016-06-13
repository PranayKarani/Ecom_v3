<?php

require_once('include/config.php');
require_once('include/DBHandler.php');

// Controllers
require_once('controllers/ProductController.php');
require_once('controllers/CategoryController.php');

// Views
require_once('views/templates/header.php');
require_once('views/CategoryView.php');
require_once('views/ProductView.php');

if (isset($_GET['category'])) {
    $category = $_GET['category'];
}
if (isset($_GET['search_text'])) {
    $search_text = $_GET['search_text'];
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>search</title>
    <link rel="stylesheet" href="views/styles/header_style.css">
    <link rel="stylesheet" href="views/styles/search_style.css">
    <!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
    <script src="../jquery-2.2.3.min.js"></script>
    <script src="views/scripts/header_script.js"></script>
    <script src="views/scripts/search_script.js"></script>
</head>
<body>
<?php Header::show(); ?>
<div id="left_section">
    <?php
    if (isset($category)) {
        CategoryView::showFilters($category);
    } else {
        // TODO show common filters
    }
    ?>
</div>
<div id="center_section">
    <div id="center_top"></div>
    <div id="center_middle">
        <?php
        if (isset($search_text)) {
            ProductView::showSearchedProducts($search_text);
        } else {
            echo "<script>loadFilteredProducts();</script>";
        }
        ?>
    </div>
    <div id="center_bottom"></div>
</div>

</body>
</html>
