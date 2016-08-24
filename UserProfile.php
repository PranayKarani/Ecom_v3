<?php

require_once 'include/DBHandler.php';
require_once 'include/config.php';
require_once 'include/common.php';

require_once 'init.php';

$uID = -1;
$userView = null;
if (isset($_GET['uID'])) {
	$uID = $_GET['uID'];
	$userView = new UserProfileView($uID);
} else {
	header("Location: index.php");
	die();
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>User Profile</title>
	
	<!--	styles-->
	<link rel="stylesheet" href="views/styles/header_style.css">
	<link rel="stylesheet" href="views/styles/footer_style.css">
	<link rel="stylesheet" href="views/styles/common_style.css">
	<link rel="stylesheet" href="views/styles/userprofile_style.css">
	
	<!--	scripts-->
	<script src="../jquery-2.2.3.min.js"></script>
	<script src="views/scripts/header_script.js"></script>
	<script src="views/scripts/common_script.js"></script>
	<script src="views/scripts/userprofile_script.js"></script>

</head>
<body>

<?php Header::show(); ?>

<div id="content">
	<div id="top_section">
		<?php
		$userView->showName();
		$userView->showEmail();
		$userView->showContact();
		$userView->showAddress();
		?>
	</div>
	<div id="middle_section">
		<div class="product_container">
			<?php
			$userView->showRecentlyViewedProducts();
			?>
		</div>
	</div>
	<div id="bottom_section">
		<?php
		$userView->showOrderedProducts();
		?>
	
	</div>
</div>

<?php Footer::show(); ?>

</body>
</html>