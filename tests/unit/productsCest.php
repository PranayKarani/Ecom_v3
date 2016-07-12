<?php

require_once 'include/config.php';
require_once 'include/DBHandler.php';
require_once 'controllers/ProductController.php';

class productsCest {

	/**
	 * Product authentication i.e. verifing the products details return for the given product_id
	 *
	 * @param UnitTester $I
	 */
	public function productAuth (UnitTester $I) {

		$I->amGoingTo("match name product_name with ID");
		$pID = 25;
		$exp_pname = "Bravia";
		$pname = ProductController::getProductDetails($pID)['product_name'];
		codecept_debug($pname);
		$I->assertEquals($exp_pname, $pname);

		$I->amGoingTo("match category with ID");
		$pID = 18;
		$exp_category = "laptop";
		$category = ProductController::getProductDetails($pID)['category'];
		codecept_debug($category);
		$I->assertEquals($exp_category, $category);
		
	}
	
	/**
	 * Testing whether the correct sql query is generated my getFilteredProducts for the gievn json input
	 *
	 * @param UnitTester $I
	 */
	public function filterVerify (UnitTester $I) {
		
		$json = '[{"table":"c__laptop"},{"string":"os=\'OS X\' AND\n"}]';
		codecept_debug($json);
		$exp_sql = "SELECT * FROM product_pool JOIN c__laptop ON product_pool.product_id = c__laptop.product WHERE os='OS X' AND category = 'laptop' ORDER BY brand";
		$exp_data = DBHandler::getAll($exp_sql);
		
		$data = ProductController::getFilteredProducts($json);
		
		$I->assertEquals($data, $exp_data);
		
	}
	
}
