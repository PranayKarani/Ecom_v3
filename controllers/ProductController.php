<?php


class ProductController {

    public static function getNewProducts ($lmt) {

        $sql = "SELECT * FROM product_pool ORDER BY product_id DESC LIMIT $lmt";

        return DBHandler::getAll($sql);

    }

    public static function getTopProducts ($lmt) {

        // TODO modify get top products query
        $sql = "SELECT * FROM product_pool LIMIT $lmt";

        return DBHandler::getAll($sql);
    }

    public static function getCategoryTopProducts ($category) {

        $sql = "SELECT * FROM product_pool WHERE category = '$category' LIMIT 5";

        return DBHandler::getAll($sql);

    }

    public static function getCategoryNewProducts ($category) {

        $sql = "SELECT * FROM product_pool WHERE category = '$category' LIMIT 5";

        return DBHandler::getAll($sql);

    }

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
        $sql = "CALL get_searched_products('$strict_search_text','$search_text', 5)";

        return DBHandler::getAll($sql);
    }

    public static function getProductDetails ($id) {
        $sql = "CALL get_product_details($id)";

        return DBHandler::getRow($sql);
    }

    public static function getCategoryProducts ($category) {

        $cat = str_replace(' ', '_', $category);
        $table = "c__" . strtolower(trim($cat));

        $sql = "SELECT * FROM product_pool JOIN $table ON product_pool.product_id = $table.product WHERE category = '$category'";

        return DBHandler::getAll($sql);

    }

    public static function getFilteredProducts ($json) {

        $data = json_decode($json);
        $count = count($data);


        $table = '';
        $conditions = '';

        for ($i = 0; $i < $count; $i++) {
            foreach ($data[$i] as $key => $value) {
                if ($key == 'table') {
                    $table = $value;
                }
                if ($key == 'string') {
                    $conditions = $value;
                }
            }
        }

        $category = str_replace('c__', '', $table);
        $category = str_replace('_', ' ', $category);

        $sql = "SELECT * FROM product_pool JOIN $table ON product_pool.product_id = $table.product WHERE ";
        $sql .= $conditions;
        $sql .= "category = '$category'";

        return DBHandler::getAll($sql);

    }

}