<?php
include_once 'UserProfileView.php';

class ConfirmationView {
	
	public static function showCartDetails ($type) {
		
		$uID = $_COOKIE[COOKIE_USER_ID];
		
		$details = UserController::getCheckoutDetails($uID, $type);
		
		echo "<pre>";
		print_r($details);
		echo "</pre>";
		
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
				echo "<th width='10%' align='left'>Product Codes</th>";
				echo "<th width='30%' align='left'>Product</th>";
				echo "<th width='15%' align='left'>Shop</th>";
				echo "<th width='5%' align='left' title='quantity'>qty</th>";
				echo "<th width='10%' align='left'>price</th>";
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
					
					echo "<tr class='product_row' data-productID = '$pID' data-shopID='$sID' data-qty='$qty' data-price='$price_now'>";
					echo "<td class='product_code'>XYZAD</td>";
					echo "<td title='$p_name' class='product_name' onclick='openProductInfo($pID)'>$p_name</td>";
					echo "<td title='$title' class='shop_name' onclick=\"openShopPage($sID,'$category')\" data-loc_x='$loc_x' data-loc_y='$loc_y' data-id='$sID'>$s_name</td>";
					echo "<td>$qty</td>";
					echo "<td title='$price_now'><strong>$price_now</strong></td>";
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
				echo "<th width='10%' align='left'>price now</th>";
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
					
					echo "<tr class='product_row' data-productID = '$pID' data-shopID='$sID' data-qty='$qty' data-price='$price_now'>";
					echo "<input type='hidden' class='locations' data-loc_x='$loc_x' data-loc_y='$loc_y'/>";
					echo "<td title='$p_name' class='product_name' onclick='openProductInfo($pID)'>$p_name</td>";
					echo "<td title='$title' class='shop_name' onclick=\"openShopPage($sID,'$category')\" data-loc_x='$loc_x' data-loc_y='$loc_y' data-id='$sID'>$s_name</td>";
					echo "<td>$qty</td>";
					echo "<td title='$price_now'><strong>$price_now</strong></td>";
					echo "</tr>";
					
				}
				echo "</table>";
				
			}
			
		} else {
			echo "login first";
		}
		
	}
	
	public static function showAddress () {
		$uID = $_COOKIE[COOKIE_USER_ID];
		$data = UserController::getUserDetails($uID);
		
		$room = $data['room'];
		$building = $data['building'];
		$road = $data['road'];
		$landmark = $data['landmark'];
		$town = $data['town'];
		$pincode = $data['pincode'];
		
		echo "Room: <input type='text' value='$room' class='addr' id='room'/><br/>";
		echo "Building: <input type='text' value='$building' class='addr' id='building'/><br/>";
		echo "Road: <input type='text' value='$road' class='addr' id='road'/><br/>";
		echo "Landmark: <input type='text' value='$landmark' class='addr' id='landmark'/><br/>";
		echo "Town: <input type='text' value='$town' class='addr' id='town' disabled='disabled'/> <a href='#'>is this correct?</a><br/>";
		echo "Pincode: <input type='text' value='$pincode' class='addr' id='pincode' disabled='disabled'/> <a href='#'>is this correct?</a><br/>";
		
	}
	
	public static function showButton ($type) {
		$uID = $_COOKIE[COOKIE_USER_ID];
		$btnName = $type == 1 ? "place home delivery order" : "notify the sellers";
		echo "<button onclick='placeOrder($uID)' style='width: 100%; height: 40px'>$btnName</button>";
	}
	
}