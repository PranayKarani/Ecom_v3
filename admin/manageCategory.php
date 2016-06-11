<?php

require_once('include/config.php');
require_once('include/DBHandler.php');

// Controllers
require_once 'controllers/ProductController.php';
require_once 'controllers/DepartmentController.php';
require_once 'controllers/CategoryController.php';
require_once 'controllers/BrandController.php';

// Views
require_once('views/templates/SearchBox.php');
require_once('views/ProductView.php');
require_once('views/DepartmentView.php');
require_once('views/CategoryView.php');
require_once('views/BrandView.php');

if (isset($_GET['name'])) {
    $name = $_GET['name'];
}

if (isset($name)) {
    $categoryView = new CategoryView($name);
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage X Product</title>
    <link rel="stylesheet" href="views/styles/manage_category_style.css">
    <!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
    <script src="../../jquery-2.2.3.min.js"></script>
    <script src="views/scripts/manage_category_script.js"></script>
</head>
<body>
<div id="left_section">
    <?php SearchBox::show("search for categories") ?>
</div>
<div id="center_section">
    <diV id="center_top">
        <h3>Category Details</h3>
        <?php
        if (isset($categoryView)) {
            $categoryView->show_details();
        }
        ?>
    </diV>
    <input type="button" value="Delete this category" id="delete_category_button"
           style="background-color: indianred; color: white; font-size: large; margin-top: 20px">
</div>
<div id="right_section">
    <div id="right_top">
        <h3>Add New Category</h3>
        <form>
            Name: <input type="text" id="new_name" class="input_new"/><br>
            <?php DepartmentView::showDepartmentSelector(null, "new_department","input_new") ?>
            Filters: <input type="text" id="new_filters" class="input_new"/><br>

        <input type="button" value="add new category" id="submit_new"/>
        </form>
    </div>
</div>

</body>
</html>
