<?php

require_once('include/config.php');
require_once('include/DBHandler.php');
require_once('include/common.php');

// Controllers
require_once('controllers/ProductController.php');
require_once('controllers/DepartmentController.php');

// Views
require_once('views/templates/header.php');
require_once('views/templates/footer.php');
require_once('views/templates/LoginModal.php');
require_once('views/ProductView.php');
require_once 'views/DepartmentView.php';
require_once('views/WishlistView.php');

if (isset($_COOKIE[COOKIE_USER_ID])) {
	$uID = $_COOKIE[COOKIE_USER_ID];
	echo "<input type='hidden' value='$uID' id='uID'/>";
} else {
	die("Access denied. Login to access this page.");
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Shop</title>
	<link rel="stylesheet" href="views/styles/header_style.css">
	<link rel="stylesheet" href="views/styles/footer_style.css">
	<link rel="stylesheet" href="views/styles/common_style.css">

	<!--	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
	<script src="../jquery-2.2.3.min.js"></script>
	<script src="views/scripts/header_script.js"></script>
	<script src="views/scripts/common_script.js"></script>
	<script src="views/scripts/wishlist_script.js"></script>

</head>
<body>
<?php Header::show(); ?>

<div id="content">
	<h3>Wishlist</h3>
	<div id="page_controls" style="text-align: center"></div>
	<div id="page">
		<div id="wishlist_products">

		</div>
	</div>
</div>

<?php Footer::show(); ?>

<?php LoginModal::show(); ?>

</body>
</html>
