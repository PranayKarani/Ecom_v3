<?php

class UserController {
	
	public static function addNewUser ($json) {
		
		$details = json_decode($json);
		
		$keys = '';
		$values = '';
		
		$name = '';
		$email = '';
		
		for ($i = 0; $i < count($details); $i++) {
			
			$data = $details[$i];
			foreach ($data as $key => $value) {
				
				if ($key == 'customer_name') {
					$name = $value;
				}
				
				if ($key == 'customer_email') {
					$email = $value;
				}
				
				$keys .= "$key, ";
				$values .= "'$value', ";
				
			}
			
		}
		
		// to avoid addition logic for comma-less last key and value
		$keys .= 'waste';
		$values .= '1';
		
		$sql = "SELECT COUNT(customer_name) FROM customer WHERE customer_email = '$email'";
		$result = DBHandler::getValue($sql);
		
		if ($result > 0) {
			
			echo -2;
			
		} else {
			
			$sql = "INSERT INTO customer($keys) VALUES($values)";
			
			$result = DBHandler::execute($sql);
			if ($result != null) {
				setcookie(COOKIE_USER_ID, $result, time() + 6120770, "/");
				setcookie(COOKIE_USER_NAME, $name, time() + 6120770, "/");
				echo $result;
			} else {
				echo -1;
			}
			
		}
		
	}
	
	/* Authentication done here */
	public static function login ($json) {
		
		$details = json_decode($json);
		
		$email = '';
		$password = '';
		
		for ($i = 0; $i < count($details); $i++) {
			
			$data = $details[$i];
			foreach ($data as $key => $value) {
				
				if ($key == 'email') {
					$email = $value;
				}
				if ($key == 'password') {
					$password = $value;
				}
				
			}
			
		}
		
		$customer_data = DBHandler::getRow("SELECT * FROM customer WHERE customer_email = '$email'");
		if ($customer_data == null) {
			echo -1;
		} else {
			$actual_password = $customer_data['customer_password'];
			if ($password == $actual_password) {
				setcookie(COOKIE_USER_ID, $customer_data['customer_id'], time() + 6120770, "/");
				setcookie(COOKIE_USER_NAME, $customer_data['customer_name'], time() + 6041770, "/");
				$data = array(
						'id'   => $customer_data['customer_id'],
						'name' => $customer_data['customer_name']
				);
				echo json_encode($data);
			} else {
				echo -1;
			}
		}
		
	}
	
	/* Check whether user is logged in or not i.e. if cookie is set or not */
	public static function isLoggedIn () {
		if (isset($_COOKIE[COOKIE_USER_ID])) {
			$data = array(
					'id'   => $_COOKIE[COOKIE_USER_ID],
					'name' => $_COOKIE[COOKIE_USER_NAME]
			);
			echo json_encode($data);
			
		} else {
			echo -1;
		}
	}
	
	public static function logOut () {
		
		self::unsetCookie(COOKIE_USER_ID);
		self::unsetCookie(COOKIE_USER_NAME);
		
		echo "done";
	}
	
	/** Others */
	
	private static function unsetCookie ($name) {
		if (isset($_COOKIE[$name])) {
			unset($_COOKIE[$name]);
			setcookie($name, '', time() - 3600, "/");
		}
	}
	
	/** Wishlist Stuff */
	
	public static function addToWishlist ($pID) {
		$uID = cookieSet(COOKIE_USER_ID);
		
		if ($uID != null) {
			$sql = "CALL add_to_wishlist($pID, $uID)";
			DBHandler::execute($sql);
			self::countWishlist($uID);
		} else {
			echo -1;//login first
		}
		
	}
	
	public static function countWishlist ($uID) {
		$sql = "CALL count_products_in_wishlist($uID)";
		$count = DBHandler::getValue($sql);
		echo $count;
	}
	
	public static function getWishlistProducts ($selected_page) {
		
		$uID = cookieSet(COOKIE_USER_ID);
		
		$offset = (RPP * $selected_page);
		$rpp = RPP;
		$sql = "CALL get_wishlist_products($uID, $rpp, $offset)";
		$data = DBHandler::getAll($sql);
		
		$product_id_array = array();
		for ($i = 0; $i < count($data); $i++) {
			foreach ($data[$i] as $key => $value) {
				if ($key == 'product') {
					$product_id_array[$i] = $value;
				}
			}
		}
		
		return $product_id_array;
		
	}
	
	public static function removeFromWishlist ($pID) {
		
		$uID = cookieSet(COOKIE_USER_ID);
		
		$sql = "CALL remove_from_wishlist($uID,$pID)";
		
		DBHandler::execute($sql);
		self::countWishlist($uID);
	}
	
	/** Cart */
	
	public static function addToCart ($json) {
		
		$data = json_decode($json);
		
		$pID = 0;
		$shopID = 0;
		$price = 0;
		
		for ($i = 0; $i < count($data); $i++) {
			
			$x = $data[$i];
			foreach ($x as $key => $value) {
				
				if ($key == 'pID') {
					$pID = $value;
				}
				if ($key == 'shopID') {
					$shopID = $value;
				}
				if ($key == 'price') {
					$price = $value;
				}
				
			}
			
		}
		
		if (isset($_COOKIE[COOKIE_USER_ID])) {
			$uID = $_COOKIE[COOKIE_USER_ID];
			
			$sql = "INSERT INTO cart_pool VALUES ($uID, $pID, $shopID, 1, $price,$price)";
			
			DBHandler::execute($sql);
			
			self::countCart($uID);
		} else {
			echo -1;//login first
		}
		
	}
	
	public static function countCart ($uID) {
		$sql = "SELECT count(product) FROM cart_pool WHERE customer = $uID";
		$count = DBHandler::getValue($sql);
		echo $count;
	}
	
	public static function getCartProducts ($uID) {
		
		$sql = "CALL get_cart_products($uID)";
		
		return DBHandler::getAll($sql);
		
	}
	
	public static function getCartDetails ($uID) {
		
		$sql = "CALL get_cart_details($uID)";
		
		return DBHandler::getRow($sql);
		
	}
	
	public static function removeFromCart ($json) {
		
		$data = json_decode($json);
		
		$pID = 0;
		$sID = 0;
		$uID = 0;
		
		for ($i = 0; $i < count($data); $i++) {
			
			$x = $data[$i];
			foreach ($x as $key => $value) {
				
				if ($key == 'pID') {
					$pID = $value;
				}
				if ($key == 'sID') {
					$sID = $value;
				}
				if ($key == 'uID') {
					$uID = $value;
				}
				
			}
			
		}
		
		$sql = "DELETE FROM cart_pool WHERE customer = $uID AND product = $pID AND shop = $sID";
		
		DBHandler::execute($sql);
		
	}
	
	public static function updateQty ($json) {
		
		$data = json_decode($json);
		
		$pID = 0;
		$sID = 0;
		$uID = 0;
		$qty = 0;
		$price = 0;
		
		for ($i = 0; $i < count($data); $i++) {
			
			$x = $data[$i];
			foreach ($x as $key => $value) {
				
				if ($key == 'pID') {
					$pID = $value;
				}
				if ($key == 'sID') {
					$sID = $value;
				}
				if ($key == 'uID') {
					$uID = $value;
				}
				if ($key == 'qty') {
					$qty = $value;
				}
				if ($key = 'price') {
					$price = $value;
				}
				
			}
			
		}
		
		$bill_price = $price * $qty;
		$sql = "UPDATE cart_pool SET qty = $qty, bill_price = $bill_price WHERE customer = $uID AND product = $pID AND shop = $sID";
		
		DBHandler::execute($sql);
		
	}
	
	/** Checkout */
	
	public static function checkOut ($address) {
		
		$uID = $_COOKIE[COOKIE_USER_ID];
		
		$data = explode("^", $address);
		$type = $data[0];
		$address = $data[1];
		
		if ($type == 1) {
			$sql = "CALL get_cart_home_del_products($uID)";
		} else {
			$sql = "CALL get_cart_non_home_del_products($uID)";
		}
		
		$result = DBHandler::getAll($sql);
		
		$insert_sql = "INSERT INTO order_pool(customer, product, shop, qty, price, method, date, time,address) VALUES";
		
		$delete_products_id = "";
		$delete_shops_id = "";
		for ($i = 0; $i < count($result); $i++) {
			
			$x = $result[$i];
			$pID = $x['product_id'];
			$sID = $x['shop_id'];
			$qty = $x['qty'];
			$price = $x['price_now'];
			$method = $x['home_delivery'];
			
			if ($i == count($result) - 1) {
				$insert_sql .= " ($uID, $pID, $sID, $qty, $price, $method, CURDATE(), CURTIME(), '$address')";
				$delete_products_id .= $pID;
				$delete_shops_id .= $sID;
			} else {
				$insert_sql .= " ($uID, $pID, $sID, $qty, $price, $method, CURDATE(), CURTIME(), '$address'),";
				$delete_products_id .= $pID . ",";
				$delete_shops_id .= $sID . ",";
			}
			
		}
		
		DBHandler::execute($insert_sql);
		
		$delete_sql = "DELETE FROM cart_pool WHERE customer = $uID AND product IN ($delete_products_id) AND cart_pool.shop IN ($delete_shops_id)";
		DBHandler::execute($delete_sql);
		
		// TODO notify all shopkeepers about this customer and his order
		
		echo "$insert_sql \n";
		echo $delete_sql;
		
	}
	
	public static function getCheckoutDetails ($uID, $type) {
		
		$sql = "CALL get_checkout_details($uID, $type)";
		
		return DBHandler::getRow($sql);
		
	}
	
	public static function getHomeDelProducts ($uID) {
		
		$sql = "CALL get_cart_home_del_products($uID)";
		
		return DBHandler::getAll($sql);
		
	}
	
	public static function getWalkinProducts ($uID) {
		
		$sql = "CALL get_cart_non_home_del_products($uID)";
		
		return DBHandler::getAll($sql);
		
	}
	
	public static function getCheckoutShopLocations ($hd) {
		
		$uID = $_COOKIE[COOKIE_USER_ID];
		$sql = "CALL get_checkout_shops_details($uID, $hd)";
		$data = DBHandler::getAll($sql);
		$new_data = array();
		for ($i = 0; $i < count($data); $i++) {
			$new_data[$i]['loc_x'] = $data[$i]['loc_x'];
			$new_data[$i]['loc_y'] = $data[$i]['loc_y'];
			$new_data[$i]['loc_y'] = $data[$i]['loc_y'];
			$new_data[$i]['shop_name'] = $data[$i]['shop_name'];
			$new_data[$i]['shop_id'] = $data[$i]['shop_id'];
			
			$open = shopOpen($data[$i]);
			
			$new_data[$i]['open'] = $open;
			
		}
		
		echo json_encode($new_data);
		
	}
	
	/** Data Recording or Harvesting */
	
	public static function recordRouteSelection ($json) {
		
		$data = json_decode($json, true);
		$data = $data[0];
		
		$uid = $data['uid'];
		$pid = $data['pid'];
		$sid = $data['sid'];
		$price = $data['price'];
		
		$sql = "INSERT INTO d_customer_route_selects VALUES ($uid, $pid, $sid, $price, NOW())";
		
		DBHandler::execute($sql);
		
	}
	
	public static function recordProductSelection ($pid) {
		
		$uid = cookieSet(COOKIE_USER_ID);
		$uid = $uid <= 0 ? 0 : $uid;
		
		$sql = "INSERT INTO d_customer_product_selects VALUES ($uid, $pid, NOW())";
		
		DBHandler::execute($sql);
	}
	
	/** User Profile*/
	
	public static function getUserDetails ($uID) {
		
		$sql = "SELECT * FROM customer WHERE customer_id = $uID";
		
		return DBHandler::getRow($sql);
		
	}
	
	public static function getOrderedProducts ($uID) {
		
		$sql = "SELECT *,product_name FROM order_pool JOIN product_pool ON order_pool.product = product_pool.product_id WHERE customer = $uID ORDER BY date DESC";
		
		return DBHandler::getAll($sql);
		
	}
	
	public static function getRecentlyViewedProducts ($uID) {
		
		$sql = "CALL get_recently_viewed_products($uID)";
		
		return DBHandler::getAll($sql);
		
	}
	
	public static function updateDetails ($set) {
		
		$uID = cookieSet(COOKIE_USER_ID);
		
		if ($uID > 0) {
			$sql = "UPDATE customer $set WHERE customer_id = $uID";
			DBHandler::execute($sql);
		}
		
	}
	
}