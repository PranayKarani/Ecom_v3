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
		$actual_pname = "Bravia";
		$pname = ProductController::getProductDetails($pID)['product_name'];
		codecept_debug($pname);
		$I->assertEquals($actual_pname, $pname);

		$I->amGoingTo("match category with ID");
		$pID = 18;
		$actual_category = "laptop";
		$category = ProductController::getProductDetails($pID)['category'];
		codecept_debug($category);
		$I->assertEquals($actual_category, $category);

	}

}
