<?php

require_once '../controllers/BrandController.php';
require_once '../include/config.php';
require_once '../include/DBHandler.php';

/**
 * Created by PhpStorm.
 * User: PranayKarani
 * Date: 14/06/2016
 * Time: 09:44 AM
 */
class BrandControllerTest extends PHPUnit_Framework_TestCase {

    public function testCategoryBrands () {
        $array = ABrandController::getCategoryBrands('laptop');

        $this->assertArrayHasKey('brand', $array[0]);
    }

}
