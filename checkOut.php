<?php

require_once('include/config.php');
require_once('include/DBHandler.php');
require_once('include/common.php');

// Controllers
require_once('controllers/ProductController.php');
require_once('controllers/UserController.php');
require_once('controllers/DepartmentController.php');

// Views
require_once('views/templates/header.php');
require_once('views/templates/footer.php');
require_once('views/templates/LoginModal.php');
require_once 'views/DepartmentView.php';
require_once('views/CheckoutView.php');

if (isset($_COOKIE[COOKIE_USER_ID])) {
	$uID = $_COOKIE[COOKIE_USER_ID];
	echo "<input type='hidden' value='$uID' id='uID'/>";
} else {
	die("Access denied. Login to access this page.");
}

if (isset($_GET['type'])) {
	$type = $_GET['type'];// 1 = home delivery, 0 = walkin
	echo "<input type='hidden' value='$type' id='type'/>";
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Checkout</title>
	<link rel="stylesheet" href="views/styles/header_style.css">
	<link rel="stylesheet" href="views/styles/footer_style.css">
	<link rel="stylesheet" href="views/styles/common_style.css">
	<link rel="stylesheet" href="views/styles/checkout_style.css">
	
	<script async defer
	        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtIbBNlZxS0chITJV8eQdmEiTxykZct9E&callback=initMap&signed_in=true"></script>
	<!--	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
	<script src="../jquery-2.2.3.min.js"></script>
	<script src="views/scripts/header_script.js"></script>
	<script src="views/scripts/common_script.js"></script>
	<script src="views/scripts/checkout_script.js"></script>

</head>
<body>
<?php Header::show(); ?>

<div id="content">
	
	<h3>Cart &#8594; <span style="color: red">Checkout</span> &#8594; Confirmation</h3>
	
	<div id="left_section">
		<div id="left_top">
			<?php
			if ($type == 1) {
				CheckoutView::showHomeDeliveryProducts(); // ajax synced
			} else {
				CheckoutView::showWalkinProducts(); // ajax synced
			}
			?>
		</div>
		<div id="left_bottom">map</div>
	</div>
	<div id="right_section">
		<?php
		CheckoutView::showCartDetails($type); // ajax synced
		?>
	</div>

</div>

<?php Footer::show(); ?>
<?php LoginModal::show(); ?>

</body>
</html>


