<?php

require_once('include/config.php');
require_once('include/DBHandler.php');
require_once('include/common.php');

// Controllers
//require_once('controllers/BrandController.php');
//require_once('controllers/CategoryController.php');
require_once('controllers/ProductController.php');
require_once('controllers/DepartmentController.php');

// Views
require_once('views/templates/header.php');
require_once('views/templates/footer.php');
require_once('views/templates/LoginModal.php');
require_once 'views/DepartmentView.php';
require_once('views/ProductView.php');

$ids = array();
$noof_ids = 0;
if (isset($_GET['ids']) && !empty($_GET['ids'])) {
	$ids = explode(' ', trim($_GET['ids']));
	$noof_ids = count($ids);
}
if (isset($_GET['category'])) {
	$category = $_GET['category'];
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Compare</title>
	<link rel="stylesheet" href="views/styles/header_style.css">
	<link rel="stylesheet" href="views/styles/footer_style.css">
	<link rel="stylesheet" href="views/styles/common_style.css">
	<link rel="stylesheet" href="views/styles/compare_style.css">

	<!--	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
	<script src="../jquery-2.2.3.min.js"></script>
	<script src="views/scripts/header_script.js"></script>
	<script src="views/scripts/common_script.js"></script>
	<script src="views/scripts/compare_script.js"></script>

</head>
<body>
<?php Header::show(); ?>

<div id="content">
	<div id="center_section">

		<?php
		
		if (isset($category)) {
			if ($noof_ids > 0) {
				ProductView::showComparedProducts($ids, $category);
			} else {
				echo "<div style='font-size: 96px;font-family: \"Segoe\"; width: 100%;padding: 2%; text-align: center'><span>Nothing to compare</span></div>";
			}
		} else {
			die("category not set");
		}
		
		?>

	</div>
</div>
<?php Footer::show(); ?>
<?php LoginModal::show(); ?>

</body>
</html>
