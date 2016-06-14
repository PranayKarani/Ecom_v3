<?php

class SProductController {

    public static function getSearchedProducts ($search_text) {
        $search_text = stripslashes($search_text);

        $replacements = array( '+', '-', '*', '~', '@', '%', '(', ')', '<', '>', '\'', '"', '\\' );
        $search_text = str_replace($replacements, '', $search_text);

//        $search_text = preg_replace('#[+*()%-~@\'"]#', '', $search_text);

        $text = explode(' ', trim($search_text));
        $strict_search_text = '';
        for ($i = 0; $i < count($text); $i++) {
            $txt = $text[$i];

            if (!empty(trim($txt))) {
                $strict_search_text .= " +$txt";
            }
        }
        $sql = "CALL get_searched_products('$strict_search_text','$search_text', 25)";

        return DBHandler::getAll($sql);
    }

    public static function getShopProducts ($shop_id) {
        $sql = "CALL get_shop_products('$shop_id')";

        return DBHandler::getAll($sql);
    }

    public static function getProductDetails ($pID) {
        $sql = "CALL get_product_details($pID)";

        return DBHandler::getRow($sql);
    }

    public static function getShopProductDetails ($json) {

        $details = json_decode($json);

        $s_id = 0;
        $p_id = 0;

        for ($i = 0; $i < count($details); $i++) {
            foreach ($details[$i] as $key => $value) {
                if ($key == 'shop') {
                    $s_id = $value;
                }
                if ($key == 'product') {
                    $p_id = $value;
                }
            }
        }

        $sql = "CALL get_shop_product_details($s_id, $p_id)";

        return DBHandler::getRow($sql);

    }

    public static function addInventoryProduct ($json) {

        $details = json_decode($json);
        $length = count($details);

        $keys = '';
        $values = '';

        $shop = 0;
        $qty = 0;

        for ($i = 0; $i < $length; $i++) {

            foreach ($details[$i] as $key => $value) {

                if ($key == 'shop') {
                    $shop = $value;
                }
                if ($key == 'qty') {
                    $qty = $value;
                }
                if ($i == $length - 1) {
                    $values .= "'$value'";
                    $keys .= $key;
                } else {
                    $values .= "'$value', ";
                    $keys .= "$key,";
                }
            }

        }

        $product_count = DBHandler::getValue("SELECT sum(qty) FROM inventory_pool WHERE shop = $shop");
        $product_count += $qty;
        $limit = DBHandler::getValue("SELECT inv_size FROM shop_pool WHERE shop_id = $shop");

        echo "pc: $product_count, limit: $limit\n";

        if($product_count <= $limit){
            $sql = "INSERT INTO inventory_pool($keys) VALUES ($values)";

            echo $sql;

            DBHandler::execute($sql);
        } else {
            echo "Product Limint exceeded";
        }

    }

    public static function updateInventoryProduct ($json) {
        $details = json_decode($json);

        $shop = 0;
        $product = 0;
        $qty = 0;

        $sql = "UPDATE inventory_pool SET";

        for ($i = 0; $i < count($details); $i++) {

            foreach ($details[$i] as $key => $value) {

                if ($key == 'shop') {
                    $shop = $value;
                    continue;
                }
                if ($key == 'product') {
                    $product = $value;
                    continue;
                }
                if ($key == 'qty') {
                    $qty = $value;
                }
                if ($i == count($details) - 1) {
                    $sql .= " $key = '$value' ";
                } else {
                    $sql .= " $key = '$value', ";
                }

            }

        }


        $product_count = DBHandler::getValue("SELECT sum(qty) FROM inventory_pool WHERE shop = $shop");
        $product_count += $qty;
        $limit = DBHandler::getValue("SELECT inv_size FROM shop_pool WHERE shop_id = $shop");

        echo "pc: $product_count, limit: $limit\n";

        if($product_count <= $limit){
            $sql .= "WHERE shop = $shop AND product = $product";

            echo $sql;

            DBHandler::execute($sql);
        } else {
            echo "Product Limint exceeded";
        }

    }

    public static function removeInventoryProduct ($json) {
        $details = json_decode($json);

        $shop = 0;
        $product = 0;

        for ($i = 0; $i < count($details); $i++) {

            foreach ($details[$i] as $key => $value) {

                if ($key == 'shop') {
                    $shop = $value;
                    continue;
                }
                if ($key == 'product') {
                    $product = $value;
                    continue;
                }

            }

        }

        $sql = "DELETE FROM inventory_pool WHERE shop = $shop AND product = $product";

        echo $sql;

        DBHandler::execute($sql);

    }

}
