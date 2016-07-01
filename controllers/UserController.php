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
	 * @param $json
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
			$sql = "CALL get_wishlist_count($uID)";
			$count = DBHandler::getValue($sql);
			echo $count;
		} else {
			echo -1;//login first
		}

	}

}