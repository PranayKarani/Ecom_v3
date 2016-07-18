<?php

class ProductController {
	
	public static function getNewProducts ($lmt) {
		
		$uID = cookieSet(COOKIE_USER_ID);
		$w = "";
		if ($uID > 0) {
			$w = ",(SELECT count(product) FROM wishlist_pool WHERE customer = $uID AND product = product_pool.product_id) AS w";
		}
		
		$sql = "SELECT *$w FROM product_pool ORDER BY product_id DESC LIMIT $lmt";
		
		return DBHandler::getAll($sql);
		
	}
	
	public static function getTopProducts ($lmt) {
		
		$uID = cookieSet(COOKIE_USER_ID);
		$w = "";
		if ($uID > 0) {
			$w = ",(SELECT count(product) FROM wishlist_pool WHERE customer = $uID AND product = product_pool.product_id) AS w";
		}
		
		$sql = "SELECT *$w FROM product_pool ORDER BY rating DESC, product_name ASC LIMIT $lmt";
		
		return DBHandler::getAll($sql);
	}
	
	public static function getProductDetails ($id) {
		
		$sql = "SELECT category FROM product_pool WHERE product_id = $id";
		$category = DBHandler::getValue($sql);
		$table_name = 'c__' . str_replace(' ', '_', trim($category));
		$uID = cookieSet(COOKIE_USER_ID);
		
		$sql = "CALL get_product_details($id,'$table_name',$uID)";
		
		return DBHandler::getRow($sql);
	}
	
	public static function getFilteredProducts ($json) {
		
		$data = json_decode($json, true);
		$count = count($data);
		
		$table = '';
		$conditions = '';
		$order = '';
		
		for ($i = 0; $i < $count; $i++) {
			foreach ($data[$i] as $key => $value) {
				if ($key == 'table') {
					$table = $value;
				}
				if ($key == 'string') {
					$conditions = $value;
				}
				if ($key == 'order') {
					$order = $value;
				}
			}
		}
		
		$category = str_replace('c__', '', $table);
		$category = str_replace('_', ' ', $category);
		
		// wishlist stuff
		$uID = cookieSet(COOKIE_USER_ID);
		$w = "";
		if ($uID != null) {
			$w = ",(SELECT count(product) FROM wishlist_pool WHERE customer = $uID AND product = product_pool.product_id) AS w";
		}
		
		$sql = "SELECT DISTINCT product_pool.* $w FROM product_pool JOIN $table ON product_pool.product_id = $table.product JOIN inventory_pool ON product_pool.product_id = inventory_pool.product WHERE ";
		$sql .= $conditions;
		if ($order == '') {
			$sql .= "category = '$category' ORDER BY brand";
		} else {
			$sql .= "category = '$category' $order, brand";
		}
		
		return DBHandler::getAll($sql);
		
	}
	
	public static function getSimilarProducts ($pID) {
		$uID = cookieSet(COOKIE_USER_ID);
		$sql = "CALL get_similar_products($pID,$uID)";
		
		return DBHandler::getAll($sql);
	}
	
	/** Search Stuff */
	
	public static function getSearchedProducts ($search_text) {
		
		$search_text = stripslashes($search_text);
		
		$search_text = str_replace(unserialize(ESC_STR), '', $search_text);
		
		$uID = cookieSet(COOKIE_USER_ID);
		
		if ($search_text != '') {
			
			$text = explode(' ', trim($search_text));
			$strict_search_text = '';
			for ($i = 0; $i < count($text); $i++) {
				$txt = $text[$i];
				
				if (!empty(trim($txt))) {
					$strict_search_text .= " +$txt";
				}
			}
			
			$sql = "CALL get_searched_products('$strict_search_text','$search_text', 5, $uID)";
			
			return DBHandler::getAll($sql);
			
		} else {
			return null;
			
		}
	}
	
	public static function getOrderedSearchedProducts ($json) {
		
		$data = json_decode($json);
		$count = count($data);
		
		$search_text = '';
		$order = '';
		
		for ($i = 0; $i < $count; $i++) {
			foreach ($data[$i] as $key => $value) {
				if ($key == 'search') {
					$search_text = $value;
				}
				if ($key == 'order') {
					$order = $value;
				}
			}
		}
		
		$search_text = stripslashes($search_text);
		
		$search_text = str_replace(unserialize(ESC_STR), '', $search_text);
		
		$text = explode(' ', trim($search_text));
		$strict_search_text = '';
		for ($i = 0; $i < count($text); $i++) {
			$txt = $text[$i];
			
			if (!empty(trim($txt))) {
				$strict_search_text .= " +$txt";
			}
		}
		
		$uID = cookieSet(COOKIE_USER_ID);
		$w = "";
		if ($uID != null) {
			$w = ",(SELECT count(product) FROM wishlist_pool WHERE customer = $uID AND product = product_pool.product_id) AS w";
		}
		
		$sql = "SELECT *$w FROM product_pool
WHERE MATCH(keywords) AGAINST('$strict_search_text' IN BOOLEAN MODE)
UNION SELECT *$w
      FROM product_pool
      WHERE keywords LIKE '%$search_text%'
 $order
LIMIT 5;";
		
		return DBHandler::getAll($sql);
		
	}
	
	/** Category Stuff */
	
	public static function getCategoryProducts ($category) {
		
		$cat = str_replace(' ', '_', $category);
		$table = "c__" . strtolower(trim($cat));
		
		$uID = cookieSet(COOKIE_USER_ID);
		$w = "";
		if ($uID != null) {
			$w = ",(SELECT count(product) FROM wishlist_pool WHERE customer = $uID AND product = product_pool.product_id) AS w";
		}
		
		$sql = "SELECT *$w FROM product_pool JOIN $table ON product_pool.product_id = $table.product WHERE category = '$category'";
		
		return DBHandler::getAll($sql);
		
	}
	
	public static function getCategoryTopProducts ($category) {
		
		$uID = cookieSet(COOKIE_USER_ID);
		$w = "";
		if ($uID > 0) {
			$w = ",(SELECT count(product) FROM wishlist_pool WHERE customer = $uID AND product = product_pool.product_id) AS w";
		}
		$sql = "SELECT *$w FROM product_pool WHERE category = '$category' ORDER BY rating DESC, product_name ASC LIMIT 5";
		
		return DBHandler::getAll($sql);
		
	}
	
	public static function getCategoryNewProducts ($category) {
		
		$uID = cookieSet(COOKIE_USER_ID);
		$w = "";
		if ($uID > 0) {
			$w = ",(SELECT count(product) FROM wishlist_pool WHERE customer = $uID AND product = product_pool.product_id) AS w";
		}
		$sql = "SELECT *$w FROM product_pool WHERE category = '$category' ORDER BY product_id DESC LIMIT 5";
		
		return DBHandler::getAll($sql);
		
	}
	
	public static function getCategoryBrandFilters ($category) {
		
		$sql = "SELECT brand, COUNT(brand) AS c FROM product_pool WHERE category = '$category' GROUP BY brand";
		
		return DBHandler::getAll($sql);
		
	}
	
	public static function getCategoryRatingFilters ($category) {
		
		$sql = "SELECT rating, COUNT(rating) AS c FROM product_pool WHERE category = '$category' GROUP BY rating ORDER BY rating DESC";
		
		return DBHandler::getAll($sql);
		
	}
	
	/** Shop Stuff */
	
	public static function getShopProducts ($shop_id) {
		$uID = cookieSet(COOKIE_USER_ID);
		$sql = "CALL get_shop_products($shop_id, $uID)";
		
		return DBHandler::getAll($sql);
	}
	
	public static function getShopCategoryProducts ($shop_id, $category) {
		
		$uID = cookieSet(COOKIE_USER_ID);
		$sql = "CALL get_shop_category_products('$category', $shop_id, $uID)";
		
		return DBHandler::getAll($sql);
		
	}
	
	public static function getShopSearchedProducts ($shop_id, $search_txt) {
		
		$uID = cookieSet(COOKIE_USER_ID);
		$sql = "CALL get_shop_searched_products($shop_id, '$search_txt', $uID)";
		
		return DBHandler::getAll($sql);
		
	}
	
}