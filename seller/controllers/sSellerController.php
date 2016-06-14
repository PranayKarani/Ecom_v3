<?php

class SSellerController {

    public static function authorize($username, $password){
        $sql = "SELECT * FROM seller WHERE seller_name = :un AND seller_password = :pw";
        $params = array(':un'=>$username,':pw'=>$password);
        return DBHandler::getRow($sql, $params);
    }

    public static function getSellerShopsList($seller_id){

        $sql = "SELECT * FROM market JOIN shop_pool ON market.shop = shop_pool.shop_id WHERE seller = $seller_id";

        return DBHandler::getAll($sql);

    }

}