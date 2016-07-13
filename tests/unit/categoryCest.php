<?php

require_once 'include/config.php';
require_once 'include/DBHandler.php';
require_once 'include/common.php';
require_once 'controllers/CategoryController.php';

class categoryCest {
	
	public function getCategoriesTest (UnitTester $I) {
		
		$dept = "Electronics";
		$category = "Air Conditioner";
		$data = CategoryController::getCategories($dept);
		$category_names = "";
		for ($i = 0; $i < count($data); $i++) {
			$category_names .= $data[$i]['category_name'] . ",";
		}
		codecept_debug($category_names);
		$I->assertTrue(strstr($category_names, $category) != null);
	}
	
	public function getFiltersTest (UnitTester $I) {
		
		$category = 'Air Conditioner';
		
		$exp_filter = 'type';
		$filters = CategoryController::getFilters($category);
		
		$I->assertTrue(strstr($filters, $exp_filter) != null);
		
	}
	
	public function getFilterDataTest (UnitTester $I) {
		
		$name = "type";
		$table = "c__camera";
		$result = CategoryController::getFilterData($table, $name);
		$data = "";
		for ($i = 0; $i < count($result); $i++) {
			$data .= $result[$i][$name] . ",";
		}
		codecept_debug($data);
		$I->assertTrue(strstr($data, 'DSLR') != null);
		
	}
	
}
