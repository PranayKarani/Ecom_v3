<?php

use admin\DBHandler;

class AProductController {
	
	private static $lastID;
	
	public static function getAllProducts () {
		$sql = "CALL get_products_list()";
		
		return DBHandler::getAll($sql);
	}
	
	public static function getSearchedProducts ($search_text) {
		$search_text = stripslashes($search_text);
		
		$replacements = array( '+', '-', '*', '~', '@', '%', '(', ')', '<', '>', '\'', '"', '\\' );
		$search_text = str_replace($replacements, '', $search_text);

//        $search_text = preg_replace('#[+*()%-~@\'"]#', '', $search_text);
		
		$text = explode(' ', trim($search_text));
		$strict_search_text = '';
		for ($i = 0; $i < count($text); $i++) {
			$txt = $text[$i];
			
			if (!empty(trim($txt))) {
				$strict_search_text .= " +$txt";
			}
		}
		$sql = "CALL get_searched_products('$strict_search_text','$search_text', 50, -46)";
		
		return DBHandler::getAll($sql);
	}
	
	public static function getProductDetails ($p_id) {
		
		$sql = "SELECT category FROM product_pool WHERE product_id = $p_id";
		$category = DBHandler::getValue($sql);
		$table_name = 'c__' . str_replace(' ', '_', trim($category));
		$sql = "CALL get_product_details($p_id,'$table_name',-465)";
		
		return DBHandler::getRow($sql);
		
	}
	
	public static function updateBasicProductDetails ($json_string) {
		
		$details = json_decode($json_string);
		
		$p_id = 0;
		$sql = "UPDATE product_pool SET";
		for ($i = 0; $i < count($details); $i++) {
			
			foreach ($details[$i] as $key => $value) {
				
				if ($key != "product_id") {
					
					if ($i == count($details) - 1) {
						$sql .= " $key = '$value' ";
					} else {
						$sql .= " $key = '$value', ";
					}
				} else {
					$p_id = $value;
				}
			}
			
		}
		$sql .= " WHERE product_id = $p_id";
		
		echo $sql;
		
		DBHandler::execute($sql);
		
	}
	
	public static function updateAdvanceProductDetails ($json_string) {
		
		$details = json_decode($json_string);
		$length = count($details);
		// get the table_name
		$table_name = null;
		for ($i = 0; $i < $length; $i++) {
			
			if (isset($table_name)) {
				break;
				
			} else {
				
				foreach ($details[$i] as $key => $value) {
					
					if ($key == "table_name") {
						$value = trim($value);
						$table_name = str_replace(' ', '_', $value);
						break;
					}
					
				}
				
			}
			
		}
		
		$p_id = 0;
		$sql = "UPDATE $table_name SET";
		for ($i = 0; $i < $length; $i++) {
			
			foreach ($details[$i] as $key => $value) {
				
				if ($key == 'table_name') {
					continue;
				}
				
				if ($key != "product") {
					
					$sql .= " $key = '$value', ";
					
				} else {
					$p_id = $value;
				}
			}
			
		}
		$sql .= " product = $p_id WHERE product = $p_id";
		
		echo $sql;
		
		DBHandler::execute($sql);
		
	}
	
	public static function addNewBasicProductDetails ($json_string) {
		
		$details = json_decode($json_string);
		$length = count($details);
		
		$sql = "INSERT INTO product_pool VALUES (0,";
		
		for ($i = 0; $i < $length; $i++) {
			
			foreach ($details[$i] as $key => $value) {
				if ($i == $length - 1) {
					$sql .= "'$value')";
				} else {
					$sql .= "'$value', ";
				}
			}
			
		}
		
		echo DBHandler::execute($sql);
	}
	
	public static function addNewAdvancedProductDetails ($json_string) {
		$details = json_decode($json_string);
		$length = count($details);
		// get the table_name
		$table_name = null;
		$p_id = null;
		for ($i = 0; $i < $length; $i++) {
			
			if (isset($table_name) && isset($p_id)) {
				break;
				
			} else {
				
				foreach ($details[$i] as $key => $value) {
					
					if ($key == "table_name_new") {
						$value = trim($value);
						$table_name = str_replace(' ', '_', $value);
						break;
					}
					if ($key == "product_id") {
						$p_id = $value;
						break;
					}
					
				}
				
			}
			
		}
		
		$sql = "INSERT INTO $table_name VALUES ($p_id,";
		for ($i = 0; $i < $length; $i++) {
			
			foreach ($details[$i] as $key => $value) {
				
				if ($key == 'table_name_new') {
					continue;
				}
				
				if ($key != "product_id") {
					
					if ($i == $length - 1) {
						$sql .= "'$value')";
					} else {
						$sql .= "'$value',";
					}
				}
			}
			
		}
		
		echo $sql;
		DBHandler::execute($sql);
	}
	
	public static function deleteProduct ($id) {
//        $details = json_decode($json_string);
//
//        echo "<pre>";
//        print_r($details);
//        echo "</pre>";
//
////        echo $details['pID'];
//
//        $id = null;
//        $table_name = null;
//
//        for ($i = 0; $i < count($details); $i++) {
//
//            if (isset($table_name) && isset($id)) {
//                break;
//
//            } else {
//
//                foreach ($details[$i] as $key => $value) {
//
//                    if ($key == "table") {
//                        $table_name = $value;
//                    }
//                    if ($key == "pID") {
//                        $id = $value;
//                    }
//
//                }
//
//            }
//
//        }
		
		$sql = "DELETE FROM product_pool WHERE product_id = $id";
		
		DBHandler::execute($sql);
		
		echo $sql;
		
	}
	
}