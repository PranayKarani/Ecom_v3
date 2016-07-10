<?php

use admin\DBHandler;

class AShopController {

	public static function getSearchedShops ($search_text) {
		$sql = "CALL get_searched_shops('$search_text')";

		return DBHandler::getAll($sql);
	}

	public static function getShopDetails ($id) {
		$sql = "CALL get_shop_details($id)";

		return DBHandler::getRow($sql);
	}

	public static function getShopOwnerDetails ($shop_id) {
		$sql = "CALL get_shop_owner_details($shop_id)";

		return DBHandler::getRow($sql);
	}

	public static function getShopProducts ($shop_id) {

		$sql = "CALL get_shop_products($shop_id)";

		return DBHandler::getAll($sql);

	}

	public static function getSellersList () {
		$sql = "SELECT seller_id, seller_name FROM seller";

		return DBHandler::getAll($sql);

	}

	public static function updateDetails ($json_string) {

		$details = json_decode($json_string);

		$s_id = 0;
		$shop_name = '';
		$dept = '';
		$old_seller = 0;
		$new_seller = 0;

		$sql = "UPDATE shop_pool SET ";
		for ($i = 0; $i < count($details); $i++) {

			foreach ($details[$i] as $key => $value) {

				if ($key == 'seller') {
					$new_seller = $value;
					continue;
				}
				if ($key == 'old_seller') {
					$old_seller = $value;
					continue;
				}

				if ($key == 'shop_name') {
					$shop_name = $value;
					continue;
				}

				if ($key == 'department') {
					$dept = $value;
					continue;
				}

				if ($key != "shop_id") {

					$sql .= " $key = '$value', ";

				} else {
					$s_id = $value;
				}
			}

		}

		$sql .= " keywords = '$dept $shop_name' ";

		$sql .= " WHERE shop_id = $s_id";

		echo $sql;

		DBHandler::execute($sql);

		$sql = "UPDATE market SET seller = $new_seller WHERE shop = $s_id AND seller = $old_seller";
		echo $sql;

		DBHandler::execute($sql);

	}

	public static function addNewShop ($json_string) {
		$details = json_decode($json_string);
		$length = count($details);

		$seller = 0;
		$shop_name = '';
		$dept = '';
		$keys = '';
		$values = '';

		for ($i = 0; $i < $length; $i++) {

			foreach ($details[$i] as $key => $value) {

				if ($key == 'seller') {
					$seller = $value;
					continue;
				}

				if ($key == 'shop_name') {
					$shop_name = $value;
					continue;
				}

				if ($key == 'department') {
					$dept = $value;
					continue;
				}

				$values .= "'$value', ";
				$keys .= "$key,";

			}

		}

		$keys .= "keywords";
		$values .= "'$dept $shop_name'";

		$sql = "INSERT INTO shop_pool($keys) VALUES ($values)";

		echo $sql;
		$shop_id = DBHandler::execute($sql);

		$sql = "INSERT INTO market VALUES ($seller, $shop_id)";

		DBHandler::execute($sql);

	}

	public static function removeShop ($id) {

		$sql = "DELETE FROM shop_pool WHERE shop_id = $id";

		return DBHandler::execute($sql);

	}

}
