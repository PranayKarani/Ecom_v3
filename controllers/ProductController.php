<?php


class ProductController {

    public static function getNewProducts () {

        $sql = "SELECT * FROM product_pool ORDER BY product_id DESC LIMIT 10";

        return DBHandler::getAll($sql);

    }

    public static function getTopProducts () {

        // TODO modify get top products query
        $sql = "SELECT * FROM product_pool LIMIT 10";

        return DBHandler::getAll($sql);
    }

    public static function getCategoryTopProducts ($category){

        $sql = "SELECT * FROM product_pool WHERE category = '$category' LIMIT 5";

        return DBHandler::getAll($sql);

    }

    public static function getSearchedProducts ($search_text) {
        $sql = "CALL get_searched_products('$search_text', 5)";

        return DBHandler::getAll($sql);
    }

    public static function getProductDetails($id){
        $sql = "CALL get_product_details($id)";

        return DBHandler::getRow($sql);
    }

}