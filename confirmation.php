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
//require_once('views/UserProfileView.php');

if (isset($_COOKIE[COOKIE_USER_ID])) {
	$uID = $_COOKIE[COOKIE_USER_ID];
	echo "<input type='hidden' value='$uID' id='uID'/>";
} else {
	die("Access Denied. Login in first.");
}

if (isset($_GET['type'])) {
	$type = $_GET['type'];// 1 = home delivery, 0 = walkin
	echo "<input type='hidden' value='$type' id='type'/>";
} else die ("undefined order type");

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Confirmation</title>
	<link rel="stylesheet" href="views/styles/header_style.css">
	<link rel="stylesheet" href="views/styles/footer_style.css">
	<link rel="stylesheet" href="views/styles/common_style.css">
	<link rel="stylesheet" href="views/styles/confirmation_style.css">
	
	<script async defer
	        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtIbBNlZxS0chITJV8eQdmEiTxykZct9E&callback=initMap&signed_in=true"></script>
	<!--	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
	<script src="../jquery-2.2.3.min.js"></script>
	<script src="views/scripts/header_script.js"></script>
	<script src="views/scripts/common_script.js"></script>
	<script src="views/scripts/confirmation_script.js"></script>
</head>
<body>
<?php Header::show(); ?>

<div id="content">
	
	<h3>Cart &#8594; Checkout &#8594; <span style="color: red">Confirmation</span></h3>
	
	<div id="left_section">
		<div id="left_top">
			<!--		product table-->
		</div>
		<div id="left_bottom">
			map
		</div>
	</div>
	<div id="right_section">
		<div id="right_top">
			<!--		order details-->
		</div>
		<div id="right_middle">
			<!--		address-->
		</div>
		<div id="right_bottom">
			<button>notify/confim button</button>
		</div>
	</div>

</div>

<?php Footer::show(); ?>
<?php LoginModal::show(); ?>

</body>
</html>



