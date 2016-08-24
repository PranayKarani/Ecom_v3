<?php

class CartView {
	
	public static function showCartDetails () {
		
		$uID = $_COOKIE[COOKIE_USER_ID];
		$details = UserController::getCartDetails($uID);
		
		echo "<pre>";
		print_r($details);
		echo "</pre>";
		echo "<button onclick=''>goto confirmation page</button>";
		
	}
	
	public static function showHomeDeliveryProducts () {
		
		if (isset($_COOKIE[COOKIE_USER_ID])) {
			
			$uID = $_COOKIE[COOKIE_USER_ID];
			
			$products = UserController::getHomeDelProducts($uID);
			
			$count = count($products);
			
			if ($count > 0) {
				
				echo "<h2>Products with Home Delivery option</h2>";
				
				echo "<table style='width: 100%; table-layout: fixed'>";
				
				echo "<tr>";
				echo "<th width='2%' align='left'></th>";
				echo "<th width='30%' align='left'>Product</th>";
				echo "<th width='15%' align='left'>Shop</th>";
				echo "<th width='5%' align='left' title='quantity'>qty</th>";
				echo "<th width='10%' align='left'>price when added to cart</th>";
				echo "<th width='10%' align='left'>price now</th>";
				echo "<th width='3%' align='left'></th>";
				echo "</tr>";
				
				for ($i = 0; $i < $count; $i++) {
					
					$product = $products[$i];
					
					// ids
					$pID = $product['product_id'];
					$sID = $product['shop_id'];
					
					$p_name = $product['product_name'];
					$category = $product['category'];
					$s_name = $product['shop_name'];
					$qty = $product['qty'];
					$price = $product['price'];
					$price_now = $product['price_now'];
					$w = $product['w'];
					
					echo "<tr>";
					echo "<td style='position: relative'>";
					wishlistThumbnail($w, $pID);
					echo "</td>";
					echo "<td title='$p_name' class='product_name' onclick='openProductInfo($pID)'>$p_name</td>";
					echo "<td title='$s_name' class='shop_name' onclick=\"openShopPage($sID,'$category')\">$s_name</td>";
					echo "<td><input type='number' class='qty' value='$qty' style='width: 100%' min='1' data-pID='$pID' data-uID='$uID' data-sID='$sID' data-price='$price_now'/></td>";
					echo "<td title='$price'>$price</td>";
					echo "<td title='$price_now'><strong>$price_now</strong></td>";
					echo "<td title='remove from cart'><button data-pID='$pID' data-sID='$sID' data-uID='$uID' onclick='removeFromCart($pID, $sID, $uID)'>x</button></td>";
					echo "</tr>";
				}
				echo "</table>";
				echo "<input type='button' id='checkout_with_home_delivery' value='checkout with home delivery option' onclick='homeDelivery_checkOut()'/>";
			} else {
				$result = DBHandler::getValue("SELECT COUNT(customer) FROM cart_pool WHERE customer = $uID");
				if ($result <= 0) {
					echo "Your cart is empty";
				}
				
			}

		} else {
			echo "login first";
		}

	}
	
	public static function showWalkinProducts () {
		
		if (isset($_COOKIE[COOKIE_USER_ID])) {
			
			$uID = $_COOKIE[COOKIE_USER_ID];
			
			$products = UserController::getWalkinProducts($uID);
			
			$count = count($products);
			
			if ($count > 0) {
				
				echo "<h2>Products with Walk-in option</h2>";
				
				echo "<table style='width: 100%; table-layout: fixed'>";
				
				echo "<tr>";
				echo "<th width='2%' align='left'></th>";
				echo "<th width='30%' align='left'>Product</th>";
				echo "<th width='15%' align='left'>Shop</th>";
				echo "<th width='5%' align='left' title='quantity'>qty</th>";
				echo "<th width='10%' align='left'>price when added to cart</th>";
				echo "<th width='10%' align='left'>price now</th>";
				echo "<th width='3%' align='left'></th>";
				echo "</tr>";
				
				for ($i = 0; $i < $count; $i++) {
					
					$product = $products[$i];
					
					// ids
					$pID = $product['product_id'];
					$sID = $product['shop_id'];
					
					$p_name = $product['product_name'];
					$category = $product['category'];
					$s_name = $product['shop_name'];
					$qty = $product['qty'];
					$price = $product['price'];
					$price_now = $product['price_now'];
					$w = $product['w'];
					
					echo "<tr>";
					echo "<td style='position: relative'>";
					wishlistThumbnail($w, $pID);
					echo "</td>";
					echo "<td title='$p_name' class='product_name' onclick='openProductInfo($pID)'>$p_name</td>";
					echo "<td title='$s_name' class='shop_name' onclick=\"openShopPage($sID,'$category')\">$s_name</td>";
					echo "<td><input type='number' class='qty' value='$qty' style='width: 100%' min='1' data-pID='$pID' data-uID='$uID' data-sID='$sID' data-price='$price_now'/></td>";
					echo "<td title='$price'>$price</td>";
					echo "<td title='$price_now'><strong>$price_now</strong></td>";
					echo "<td title='remove from cart'><button data-pID='$pID' data-sID='$sID' data-uID='$uID' onclick='removeFromCart($pID, $sID, $uID)'>x</button></td>";
					echo "</tr>";
					
				}
				echo "</table>";
				echo "<input type='button' id='checkout_with_non_home_delivery' value='checkout with walk-in option' onclick='walkin_checkOut()'/>";
			}
			
		} else {
			echo "login first";
		}
		
	}
	
}