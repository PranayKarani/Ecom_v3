<?php

class WishlistView {
	
	public static function showWishlistProducts ($pg_no) {

		require_once('ProductView.php');
		
		$product_id_array = UserController::getWishlistProducts($pg_no);
		
		for ($i = 0; $i < count($product_id_array); $i++) {
			
			$product = ProductController::getProductDetails($product_id_array[$i]);
			ProductView::product_box($product, false);

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