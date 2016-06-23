<?php
require_once('include/config.php');
require_once('include/DBHandler.php');
// Controllers
require_once('controllers/BrandController.php');
require_once('controllers/CategoryController.php');
require_once('controllers/ProductController.php');
// Views
require_once('views/templates/header.php');
require_once('views/BrandView.php');
require_once('views/CategoryView.php');
require_once('views/ProductView.php');
if (isset($_GET['category'])) {
	$category = $_GET['category'];
	echo "<input type='hidden' id='cat' value='$category'/>";
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Category</title>
	<link rel="stylesheet" href="views/styles/header_style.css">
	<link rel="stylesheet" href="views/styles/common_style.css">
	<link rel="stylesheet" href="views/styles/category_style.css">
	<link rel="stylesheet" href="views/styles/compare_bar_style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	<script src="../jquery-2.2.3.min.js"></script>
	<script src="views/scripts/header_script.js"></script>
	<script src="views/scripts/compare_bar_script.js"></script>
	<script src="views/scripts/category_script.js"></script>
</head>
<body>
<?php Header::show() ?>
<div id="left_section">

	<div id="left_top">
		<?php
		if (isset($category)) {
			echo "Filters for <strong style='font-size: x-large'>$category</strong><br><br>";
		} else {
			echo ":(";
		}
		?>

		<strong style='font-size: larger'>Brands</strong><br>
		<?php
		if (isset($category)) {
			BrandView::showBrandFilters($category);
		} else {
			echo ":(";
		}
		?>
		<strong style='font-size: larger'>Ratings</strong><br>
		<?php
		if (isset($category)) {
			ProductView::showCategoryRatingFilters($category);
		} else {
			echo ":(";
		}
		?>
	</div>
	<div id="left_bottom">

		<?php
		if (isset($category)) {
			CategoryView::showFilters($category);
		} else {
			echo ":(";
		}
		?>
	</div>

</div>
<div id="center_section">

	<div id="center_top">
		<?php
		if (isset($category)) {
			echo "<strong>$category</strong>";
		}
		?>
	</div>
	<div id="bar">
		<button class="nearBy" id="<?php if (isset($category)) {
			echo $category;
		} ?>">
			Find Nearby shops <?php if (isset($category)) {
				echo "for $category";
			} ?></button>
		<!--        <div id="sortBy" hidden>-->
		<select id="order_by" hidden>
			<option value=" ORDER BY mrp ASC" selected>Price: Low to High</option>
			<option value=" ORDER BY mrp DESC">Price: High to Low</option>
			<option value=" ORDER BY rating ASC">Rating: Low to High</option>
			<option value=" ORDER BY rating DESC">Rating: High to Low</option>
			<option value=" ORDER BY product_id DESC">Latest: first</option>
			<option value=" ORDER BY product_id ASC">Latest: last</option>
		</select>
		<!--        </div>-->
	</div>
	<div id="compare_bar" hidden>
		<div class="compare_product_slot" data-slot-no="1" data-product-id="" data-counter="-1">
			<div class="compared_product"></div>
			<!--			<input type="button" value="X" class="remove_from_compare"/>-->
		</div>
		<div class="compare_product_slot" data-slot-no="2" data-product-id="" data-counter="-1">
			<div class="compared_product"></div>
			<!--			<input type="button" value="X" class="remove_from_compare"/>-->
		</div>
		<div class="compare_product_slot" data-slot-no="3" data-product-id="" data-counter="-1">
			<div class="compared_product"></div>
			<!--			<input type="button" value="X" class="remove_from_compare"/>-->
		</div>
		<div class="compare_product_slot" data-slot-no="4" data-product-id="" data-counter="-1">
			<div class="compared_product"></div>
			<!--			<input type="button" value="X" class="remove_from_compare"/>-->
		</div>
		<!--	    <div id="compare_product_button_holder">-->
		<!--	    </div>-->
		<input type="button" value="compare" onclick="goCompare()" class="compare_product_button"/>
		<input type="button" value="clear all and close" onclick="clearAll()" class="compare_product_button"/>
	</div>
	<div id="center_middle"></div>
	<div id="center_bottom"></div>

</div>
</body>
</html>
