<?php

class WishlistView {

	public static function showWishlistProducts ($json) {

		require_once('ProductView.php');

		$products_array = UserController::getWishlistProducts($json);

		for ($i = 0; $i < count($products_array); $i++) {

			$product = ProductController::getProductDetails($products_array[$i]);
			ProductView::product_box($product, false, true);

		}

	}

	public static function getPageControls ($count) {

		$count /= RPP;

		if ($count > 1) {
			echo "<button id='prev_page' class='page_control_buttons'><<</button>";

			for ($i = 0; $i < $count; $i++) {
				$x = $i + 1;
				echo "<button id='$i' class='page_no_buttons'>$x</button>";
			}

			echo "<button id='next_page' class='page_control_buttons'>>></button>";

		} else {
			echo "<button id='prev_page' class='page_control_buttons' disabled><<</button>";
			echo "<button id='next_page' class='page_control_buttons' disabled>>></button>";

		}
	}

}