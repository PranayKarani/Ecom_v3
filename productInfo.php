<?php
require_once('include/config.php');
require_once('include/DBHandler.php');
// Controllers
require_once('controllers/ProductController.php');
require_once('controllers/ShopController.php');
// Views
require_once('views/templates/header.php');
require_once('views/ProductInfoView.php');
require_once('views/ProductView.php');
require_once('views/CategoryView.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $productInfoView = new ProductInfoView($id);
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Product Info</title>
	<link rel="stylesheet" href="views/styles/header_style.css">
	<link rel="stylesheet" href="views/styles/common_style.css">
	<link rel="stylesheet" href="views/styles/product_info_style.css">
	<script async defer
	        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtIbBNlZxS0chITJV8eQdmEiTxykZct9E&callback=initMap&signed_in=true"></script>
	<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
	<script src="../jquery-2.2.3.min.js"></script>
	<script src="views/scripts/header_script.js"></script>
	<script src="views/scripts/common_script.js"></script>
	<script src="views/scripts/product_info_script.js"></script>
</head>
<body>
<?php Header::show(); ?>

<div id="content">
	<div id="top_section">
		<div id="top_left">
			<div id="top_left_top">
				<div id="top_left_top_left">
					<!--                TODO to be changed-->
					<input type="image" id="product_image" src="res/images/product/default0.jpg"/>
				</div>
				<div id="top_left_top_right">
					<div id="top_left_top_right_top">
						<?php
						$productInfoView->show_name_and_brand();
						$productInfoView->show_price_range();
						$productInfoView->show_rating_stars();
						?>
					</div>
					<div id="top_left_top_right_bottom">
						<div id="top_left_top_right_bottom_left">
							<?php $productInfoView->show_thumbnails(); ?>
						</div>
						<div id="top_left_top_right_bottom_right">
							<?php $productInfoView->show_quick_info(); ?>
							<?php $productInfoView->show_shop_availability(); ?>
						</div>
					</div>
				</div>
			</div>
			<div id="top_left_bottom">
				<div id="top_left_bottom_left">
				</div>
				<div id="top_left_bottom_right">
					<input type='checkbox' id='drive'/> drive
					<?php $productInfoView->show_shop_list(); ?>
				</div>
			</div>
		</div>
		<div id="top_right">
			<div id="tab_pane">
				<button class='tabs' id="specs_tab">Specs</button>
				<button class='tabs' id="description_tab">Description</button>
			</div>
			<div id="specs_tab_content">
				<?php $productInfoView->show_specs(); ?>
			</div>
			<div id="desc_tab_content" hidden>
				<?php $productInfoView->show_description(); ?>
			</div>
		</div>
	</div>

	<div id="center_section">
		<?php $productInfoView->show_similar_products(); ?>
	</div>

	<div id="bottom_section">
		Reviews or some other crap
	</div>
</div>

</body>
</html>
