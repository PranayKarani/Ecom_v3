<?php

require_once '../controllers/ProductController.php';
require_once '../include/config.php';
require_once '../include/DBHandler.php';

class ProductControllerTest extends PHPUnit_Framework_TestCase {


    public function testGetShopProducts () {

        $data = AProductController::getShopProducts(1);

        $this->assertArrayHasKey('product_id', $data[0]);

    }
}
