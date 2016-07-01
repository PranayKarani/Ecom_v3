<?php

class WishlistView {

	public static function showWishlistProducts ($uID) {

		require_once('ProductView.php');

		$products_array = UserController::getWishlistProducts($uID);

		for ($i = 0; $i < count($products_array); $i++) {

			$product = ProductController::getProductDetails($products_array[$i]);
			ProductView::product_box($product, false, true);

		}

	}

}