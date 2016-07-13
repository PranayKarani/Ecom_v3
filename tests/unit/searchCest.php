<?php

require_once 'include/config.php';
require_once 'include/DBHandler.php';
require_once 'controllers/ProductController.php';
require_once 'controllers/CategoryController.php';
require_once 'controllers/ShopController.php';

class searchCest {
	
	/**
	 * Testing whether crap search gives expected results in search dropdown
	 *
	 * @param UnitTester $I
	 */
	public function searchDropdownTest (UnitTester $I) {
		
		$search_text = "dgksadfgafa";
		$I->amGoingTo("enter random-crap [$search_text] text into search");
		$data = ProductController::getSearchedProducts($search_text);
		$I->assertIsEmpty($data);
		
		$search_text = "'";
		$I->amGoingTo("enter invalid character [$search_text] into search");
		$data = ProductController::getSearchedProducts($search_text);
		$I->assertIsEmpty($data);
		
		$search_text = "Ma@cbook Pr#o";
		$I->amGoingTo("enter $search_text into search");
		$data = ProductController::getSearchedProducts($search_text);
		$I->assertNotEmpty($data);
		
	}
	
	/**
	 * Testing search functions in ProductController class
	 *
	 * @param UnitTester $I
	 */
	public function searchInProductControllerTest (UnitTester $I) {
		
		// product
		$search_text = "macbook pro";
		$I->amGoingTo("enter search product: $search_text");
		$data = ProductController::getSearchedProducts($search_text);
		$exp_pID = 18;
		$pID = $data[0]['product_id'];
		$I->assertEquals($exp_pID, $pID);
		
		// category
		$search_text = "microwave oven";
		$I->amGoingTo("enter search category: $search_text");
		$data = ProductController::getSearchedProducts($search_text);
		$exp_category = "microwave oven";
		$category = $data[0]['category'];
		$I->assertEquals($exp_category, $category);
		
		// brand
		$search_text = "sony";
		$I->amGoingTo("enter search brand: $search_text");
		$data = ProductController::getSearchedProducts($search_text);
		$exp_brand = "sony";
		$brand = $data[0]['brand'];
		$I->assertEquals($exp_brand, $brand);
		
		// shop
		$search_text = "XYZ Electronics";
		$I->amGoingTo("enter search shop: $search_text");
		$data = ProductController::getSearchedProducts($search_text);
		$I->assertIsEmpty($data);
		
	}
	
	/**
	 * Testing search functions in CategoryController class
	 *
	 * @param UnitTester $I
	 */
	public function searchInCategoryControllerTest (UnitTester $I) {
		
		// product
		$search_text = "macbook pro";
		$I->amGoingTo("enter search product: $search_text");
		$data = CategoryController::getSearchedCategories($search_text);
		$I->assertIsEmpty($data);
		
		// category
		$search_text = "microwave oven";
		$I->amGoingTo("enter search category: $search_text");
		$data = CategoryController::getSearchedCategories($search_text);
		$exp_filters = "type capacity power_output";
		$filters = $data[0]['filters'];
		$I->assertEquals($exp_filters, $filters);
		
		// brand
		$search_text = "sony";
		$I->amGoingTo("enter search brand: $search_text");
		$data = CategoryController::getSearchedCategories($search_text);
		$I->assertIsEmpty($data);
		
		// shop
		$search_text = "XYZ Electronics";
		$I->amGoingTo("enter search shop: $search_text");
		$data = CategoryController::getSearchedCategories($search_text);
		$I->assertIsEmpty($data);
		
	}
	
	/**
	 * Testing search functions in ShopController class
	 *
*@param UnitTester $I
	 */
	public function searchInShopControllerTest (UnitTester $I) {
		
		// product
		$search_text = "macbook pro";
		$I->amGoingTo("enter search product: $search_text");
		$data = ShopController::getSearchedShops($search_text);
		$I->assertIsEmpty($data);
		
		// category
		$search_text = "microwave oven";
		$I->amGoingTo("enter search category: $search_text");
		$data = ShopController::getSearchedShops($search_text);
		$I->assertIsEmpty($data);
		
		// brand
		$search_text = "sony";
		$I->amGoingTo("enter search brand: $search_text");
		$data = ShopController::getSearchedShops($search_text);
		$I->assertIsEmpty($data);
		
		// shop
		$search_text = "XYZ Electronics";
		$I->amGoingTo("enter search shop: $search_text");
		$data = ShopController::getSearchedShops($search_text);
		$exp_contact = "333444";
		$contact = $data[0]['shop_contact'];
		$I->assertEquals($exp_contact, $contact);
		
	}
	
}
