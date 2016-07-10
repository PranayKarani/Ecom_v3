<?php

use admin\DBHandler;

class ABrandController {

    public static function getBrands () {
        return DBHandler::getAll("SELECT * FROM brands ORDER BY brand_name");
    }

    public static function addNewBrand($name){
        return DBHandler::execute("INSERT INTO brands VALUES ('$name')");
    }

}