<?php

class UserController {

	public static function addNewUser ($json) {

		$details = json_decode($json);

		$keys = '';
		$values = '';

		$name = '';

		for ($i = 0; $i < count($details); $i++) {

			$data = $details[$i];
			foreach ($data as $key => $value) {

				if ($key == 'customer_name') {
					$name = $value;
				}

				$keys .= "$key, ";
				$values .= "'$value', ";

			}

		}

		// to avoid addition logic for comma-less last key and value
		$keys .= 'waste';
		$values .= '1';

		$sql = "INSERT INTO customer($keys) VALUES($values)";

		$result = DBHandler::execute($sql);
		if ($result != null) {
			setcookie(COOKIE_USER_ID, $result);
			setcookie(COOKIE_USER_NAME, $name);
			echo $result;
		} else {
			echo -1;
		}

	}

	/**
	 * Authentication done here
	 *
*@param $json
	 */
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

	/**
	 * Check whether user is logged in or not i.e. if cookie is set or not
	 */
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
		setcookie(COOKIE_USER_ID, "", time() - 6120770, "/");
		setcookie(COOKIE_USER_NAME, "", time() - 6041770, "/");
		echo "done";
	}

	/* Wishlist Stuff */
	public static function addToWishlist ($pID) {
		if (isset($_COOKIE[COOKIE_USER_ID])) {
			$uID = $_COOKIE[COOKIE_USER_ID];
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

	public static function getWishlistProducts ($uID) {
		$sql = "CALL get_wishlist_products($uID)";
		$data = DBHandler::getAll($sql);

		$product_array = array();
		for ($i = 0; $i < count($data); $i++) {
			foreach ($data[$i] as $key => $value) {
				$product_array[$i] = $value;
			}
		}

		return $product_array;

	}

	public static function removeFromWishlist ($json) {
		$data = json_decode($json);

		$uID = -1;
		$pID = -1;

		for ($i = 0; $i < count($data); $i++) {
//			$uID = $data[$i]['uID'];
//			$pID = $data[$i]['pID'];
			foreach ($data[$i] as $key => $value) {

				if ($key == 'uID') {
					$uID = $value;
				}
				if ($key == 'pID') {
					$pID = $value;
				}

			}
		}

		$sql = "CALL remove_from_wishlist($uID,$pID)";

		DBHandler::execute($sql);

	}

}