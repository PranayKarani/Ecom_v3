<?php

class CheckoutView {
	
	public static function showCartDetails ($type) {
		
		$uID = $_COOKIE[COOKIE_USER_ID];
		
		$details = UserController::getCheckoutDetails($uID, $type);
		echo "<h4>checkout details</h4>";
		echo "<pre>";
		print_r($details);
		echo "</pre>";
		echo "<button onclick='gotoConfirmation()' style='width: 100%; height: 40px'>goto confirmation page</button>";
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
					
					$loc_x = $product['loc_x'];
					$loc_y = $product['loc_y'];
					
					$open = shopOpen($product);
					$title = "closed";
					if ($open == 1) {
						$title = "open";
						$s_name = "<span>$s_name</span>";
					} else {
						$s_name = "<span style='color: lightgray'>$s_name</span>";
					}
					
					echo "<tr>";
					echo "<td title='$p_name' class='product_name' onclick='openProductInfo($pID)'>$p_name</td>";
					echo "<td title='$title' class='shop_name' onclick=\"openShopPage($sID,'$category')\" data-loc_x='$loc_x' data-loc_y='$loc_y' data-id='$sID'>$s_name</td>";
					echo "<td><input type='number' class='qty' value='$qty' style='width: 100%' min='1' data-pID='$pID' data-uID='$uID' data-sID='$sID' data-price='$price_now'/></td>";
					echo "<td title='$price'>$price</td>";
					echo "<td title='$price_now'><strong>$price_now</strong></td>";
					echo "<td title='remove from cart'><button data-pID='$pID' data-sID='$sID' data-uID='$uID' onclick='removeFromCart($pID, $sID, $uID)'>x</button></td>";
					echo "</tr>";
				}
				echo "</table>";
				
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
					
					$loc_x = $product['loc_x'];
					$loc_y = $product['loc_y'];
					
					$open = shopOpen($product);
					$title = "closed";
					if ($open == 1) {
						$title = "open";
						$s_name = "<span>$s_name</span>";
					} else {
						$s_name = "<span style='color: lightgray'>$s_name</span>";
					}
					
					echo "<tr>";
					echo "<input type='hidden' class='locations' data-loc_x='$loc_x' data-loc_y='$loc_y'/>";
					echo "<td title='$p_name' class='product_name' onclick='openProductInfo($pID)'>$p_name</td>";
					echo "<td title='$title' class='shop_name' onclick=\"openShopPage($sID,'$category')\" data-loc_x='$loc_x' data-loc_y='$loc_y' data-id='$sID'>$s_name</td>";
					echo "<td><input type='number' class='qty' value='$qty' style='width: 100%' min='1' data-pID='$pID' data-uID='$uID' data-sID='$sID' data-price='$price_now'/></td>";
					echo "<td title='$price'>$price</td>";
					echo "<td title='$price_now'><strong>$price_now</strong></td>";
					echo "<td title='remove from cart'><button data-pID='$pID' data-sID='$sID' data-uID='$uID' onclick='removeFromCart($pID, $sID, $uID)'>x</button></td>";
					echo "</tr>";
					
				}
				echo "</table>";
				
			}
			
		} else {
			echo "login first";
		}
		
	}
	
}