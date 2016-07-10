<?php

class CartView {

	public static function showCartProducts () {

		if (isset($_COOKIE[COOKIE_USER_ID])) {
			$uID = $_COOKIE[COOKIE_USER_ID];

			$products = UserController::getCartProducts($uID);
			$count = count($products);

			if ($count > 0) {
				echo "<table style='width: 100%; table-layout: fixed'>";

				echo "<tr>";
				echo "<th width='30%' align='left'>Product</th>";
				echo "<th width='15%' align='left'>Shop</th>";
				echo "<th width='5%' align='left' title='quantity'>qty</th>";
				echo "<th width='10%' align='left'>price when added to cart</th>";
				echo "<th width='10%' align='left'>price now</th>";
				echo "<th width='6%' align='left'>home delivery</th>";
				echo "<th width='3%' align='left'></th>";
				echo "</tr>";

				for ($i = 0; $i < $count; $i++) {

					$product = $products[$i];

					// ids
					$pID = $product['product_id'];
					$sID = $product['shop_id'];

					$p_name = $product['product_name'];
//				$quick_info = $product['quick_info'];
					$category = $product['category'];
					$s_name = $product['shop_name'];
					$qty = $product['qty'];
					$price = $product['price'];
					$price_now = $product['price_now'];
					$homeDelivery = $product['home_delivery'];

					$hd = $homeDelivery == 1 ? "yes" : "no";

					echo "<tr>";
//					$category = "\" $category \"";
					echo "<td title='$p_name' class='product_name' onclick='openProductInfo($pID)'>$p_name</td>";
					echo "<td title='$s_name' class='shop_name' onclick=\"openShopPage($sID,'$category')\">$s_name</td>";
					echo "<td><input type='number' class='qty' value='$qty' style='width: 100%' min='1' data-pID='$pID' data-uID='$uID' data-sID='$sID' data-price='$price_now'/></td>";
					echo "<td title='$price'>$price</td>";
					echo "<td title='$price_now'><strong>$price_now</strong></td>";
					echo "<td title='$hd'>$hd</td>";
					echo "<td title='remove from cart'><button data-pID='$pID' data-sID='$sID' data-uID='$uID' onclick='removeFromCart($pID, $sID, $uID)'>x</button></td>";

					echo "</tr>";
				}
				echo "</table>";
			} else {
				echo "Cart Empty";
			}

		} else {
			echo "login first";
		}

	}

	public static function showCartDetails () {

		//TODO count home deliveries

		$uID = $_COOKIE[COOKIE_USER_ID];
		$details = UserController::getCartDetails($uID);

		echo "<pre>";
		print_r($details);
		echo "</pre>";
		echo "<button onclick='checkOut()'>Check Out or something else</button>";

	}

}