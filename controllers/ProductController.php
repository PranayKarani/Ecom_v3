<?php


class ProductController {

    public static function getNewProducts ($lmt) {

        $sql = "SELECT * FROM product_pool ORDER BY product_id DESC LIMIT $lmt";

        return DBHandler::getAll($sql);

    }

    public static function getTopProducts ($lmt) {

        $sql = "SELECT * FROM product_pool ORDER BY rating DESC, product_name ASC LIMIT $lmt";

        return DBHandler::getAll($sql);
    }

    public static function getProductDetails ($id) {
        $sql = "CALL get_product_details($id)";

        return DBHandler::getRow($sql);
    }

    public static function getFilteredProducts ($json) {

        $data = json_decode($json);
        $count = count($data);


        $table = '';
        $conditions = '';
        $order = '';

        for ($i = 0; $i < $count; $i++) {
            foreach ($data[$i] as $key => $value) {
                if ($key == 'table') {
                    $table = $value;
                }
                if ($key == 'string') {
                    $conditions = $value;
                }
                if ($key == 'order') {
                    $order = $value;
                }
            }
        }

        $category = str_replace('c__', '', $table);
        $category = str_replace('_', ' ', $category);

        $sql = "SELECT * FROM product_pool JOIN $table ON product_pool.product_id = $table.product WHERE ";
        $sql .= $conditions;
        if ($order == '') {
            $sql .= "category = '$category' ORDER BY brand";
        } else {
            $sql .= "category = '$category' $order, brand";
        }

        return DBHandler::getAll($sql);

    }

    /** Search Stuff */

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

    public static function getOrderedSearchedProducts ($json) {

        $data = json_decode($json);
        $count = count($data);

        $search_text = '';
        $order = '';

        for ($i = 0; $i < $count; $i++) {
            foreach ($data[$i] as $key => $value) {
                if ($key == 'search') {
                    $search_text = $value;
                }
                if ($key == 'order') {
                    $order = $value;
                }
            }
        }

        $search_text = stripslashes($search_text);

        $replacements = array( '+', '-', '*', '~', '@', '%', '(', ')', '<', '>', '\'', '"', '\\' );
        $search_text = str_replace($replacements, '', $search_text);

        $text = explode(' ', trim($search_text));
        $strict_search_text = '';
        for ($i = 0; $i < count($text); $i++) {
            $txt = $text[$i];

            if (!empty(trim($txt))) {
                $strict_search_text .= " +$txt";
            }
        }

        $sql = "SELECT * FROM product_pool
WHERE MATCH(keywords) AGAINST('$strict_search_text' IN BOOLEAN MODE)
UNION SELECT *
      FROM product_pool
      WHERE keywords LIKE '%$search_text%'
 $order
LIMIT 5;";

        return DBHandler::getAll($sql);

    }

    /** Category Stuff */

    public static function getCategoryProducts ($category) {

        $cat = str_replace(' ', '_', $category);
        $table = "c__" . strtolower(trim($cat));

        $sql = "SELECT * FROM product_pool JOIN $table ON product_pool.product_id = $table.product WHERE category = '$category'";

        return DBHandler::getAll($sql);

    }

    public static function getCategoryTopProducts ($category) {

        $sql = "SELECT * FROM product_pool WHERE category = '$category' ORDER BY rating DESC, product_name ASC LIMIT 5";

        return DBHandler::getAll($sql);

    }

    public static function getCategoryNewProducts ($category) {

        $sql = "SELECT * FROM product_pool WHERE category = '$category' ORDER BY product_id DESC LIMIT 5";

        return DBHandler::getAll($sql);

    }

    public static function getCategoryBrandFilters ($category) {

        $sql = "SELECT brand, COUNT(brand) AS c FROM product_pool WHERE category = '$category' GROUP BY brand";

        return DBHandler::getAll($sql);

    }

    public static function getCategoryRatingFilters ($category) {

        $sql = "SELECT rating, COUNT(rating) AS c FROM product_pool WHERE category = '$category' GROUP BY rating ORDER BY rating DESC";

        return DBHandler::getAll($sql);

    }

    /** Shop Stuff */

    public static function getShopProducts ($shop_id) {
        $sql = "CALL get_shop_products($shop_id)";

        return DBHandler::getAll($sql);
    }

    public static function getShopCategoryProducts ($shop_id, $category) {

        $sql = "CALL get_shop_category_products('$category', $shop_id)";

        return DBHandler::getAll($sql);

    }

    public static function getShopSearchedProducts ($shop_id, $search_txt) {

        $sql = "CALL get_shop_searched_products($shop_id, '$search_txt')";

        return DBHandler::getAll($sql);

    }

}