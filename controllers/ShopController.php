<?php

class ShopController {

    public static function getShopInfo ($shop_id) {

        $sql = "CALL get_shop_details($shop_id)";

        return DBHandler::getRow($sql);

    }

    public static function getSimilarShops ($shop_id) {

        $sql = "CALL get_similar_shops($shop_id)";

        return DBHandler::getAll($sql);

    }

    public static function getKeywordShops ($search) {

        $sql = "CALL get_searched_keyword_shop('$search')";

        return DBHandler::getAll($sql);

    }

    public static function getCategoryShops ($category) {

        $sql = "CALL get_category_shops('$category')";

        return DBHandler::getAll($sql);

    }

}