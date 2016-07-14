<?php

require_once('include/config.php');
require_once('include/DBHandler.php');
require_once('include/common.php');

// Controllers
require_once('controllers/DepartmentController.php');
require_once('controllers/CategoryController.php');
require_once 'controllers/ProductController.php';

// Views
require_once('views/templates/header.php');
require_once('views/templates/LoginModal.php');
require_once('views/DepartmentView.php');
require_once('views/ProductView.php');
require_once('views/CategoryView.php');

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Title</title>
	<link rel="stylesheet" href="views/styles/index_style.css">
	<link rel="stylesheet" href="views/styles/common_style.css">
	<link rel="stylesheet" href="views/styles/header_style.css">
	<!--	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
	<script src="../jquery-2.2.3.min.js"></script>
	<script src="views/scripts/index_script.js"></script>
	<script src="views/scripts/header_script.js"></script>
	<script src="views/scripts/common_script.js"></script>
</head>
<body>
<?php Header::show(); ?>

<div id="content">
	<div id="dept-category">
		<h2>Browse by Departments and Categories</h2>
		<div id='dept_container'>
			<?php DepartmentView::show(); ?>
		</div>
		<div id="category-products">
			<div id='category_container'>
			</div>
			<div id='category_products_container'>
			</div>
		</div>
	</div>
	<div id="top-products">
		<!--		--><?php //ProductView::showTopProducts(5); ?>
	</div>
	<div id="new-products">
		<!--		--><?php //ProductView::showNewProducts(5); ?>
	</div>
</div>

<?php LoginModal::show(); ?>

</body>
</html>
