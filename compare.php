<?php

require_once('include/config.php');
require_once('include/DBHandler.php');
// Controllers
//require_once('controllers/BrandController.php');
//require_once('controllers/CategoryController.php');
//require_once('controllers/ProductController.php');
// Views
require_once('views/templates/header.php');
//require_once('views/BrandView.php');
//require_once('views/CategoryView.php');
//require_once('views/ProductView.php');

$ids = array();
if (isset($_GET['ids'])) {
	$ids = explode(' ', trim($_GET['ids']));
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Compare</title>
	<link rel="stylesheet" href="views/styles/header_style.css">
	<link rel="stylesheet" href="views/styles/common_style.css">
	<link rel="stylesheet" href="views/styles/compare_style.css">

<!--	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
	<script src="../jquery-2.2.3.min.js"></script>
	<script src="views/scripts/header_script.js"></script>

</head>
<body>
<?php Header::show(); ?>

<div id="center_section">

	<div class="column" id="col_1"></div>
	<div class="column" id="col_2"></div>
	<div class="column" id="col_3"></div>
	<div class="column" id="col_4"></div>

</div>

</body>
</html>
