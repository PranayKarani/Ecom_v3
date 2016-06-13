<?php

class BrandController {

    public static function getCategoryBrands ($category) {

        $sql = "SELECT brand FROM product_pool WHERE category = '$category' GROUP BY brand ORDER BY brand";

        return DBHandler::getAll($sql);

    }

}