<?php

class ProductController {

    private static $lastID;

    public static function getAllProducts () {
        $sql = "CALL get_products_list()";

        return DBHandler::getAll($sql);
    }

    public static function getSearchedProducts ($search_text) {
        $sql = "CALL get_searched_products('$search_text', 10)";

        return DBHandler::getAll($sql);
    }

    public static function getProductDetails ($p_id) {

        $sql = "CALL get_product_details($p_id)";

        return DBHandler::getRow($sql);

    }

    public static function updateBasicProductDetails ($json_string) {


        $details = json_decode($json_string);


        $p_id = 0;
        $sql = "UPDATE product_pool SET";
        for ($i = 0; $i < count($details); $i++) {

            foreach ($details[$i] as $key => $value) {

                if ($key != "product_id") {

                    if ($i == count($details) - 1) {
                        $sql .= " $key = '$value' ";
                    } else {
                        $sql .= " $key = '$value', ";
                    }
                } else {
                    $p_id = $value;
                }
            }

        }
        $sql .= " WHERE product_id = $p_id";

        echo $sql;

        DBHandler::execute($sql);

    }

    public static function updateAdvanceProductDetails ($json_string) {

        $details = json_decode($json_string);
        $length = count($details);
        // get the table_name
        $table_name = null;
        for ($i = 0; $i < $length; $i++) {

            if (isset($table_name)) {
                break;

            } else {

                foreach ($details[$i] as $key => $value) {

                    if ($key == "table_name") {
                        $value = trim($value);
                        $table_name = str_replace(' ','_',$value);
                        break;
                    }

                }

            }

//            echo "<pre>";
//            print_r($details);
//            echo "</pre>";

        }

        $p_id = 0;
        $sql = "UPDATE $table_name SET";
        for ($i = 0; $i < $length; $i++) {

            foreach ($details[$i] as $key => $value) {

                if ($key == 'table_name') {
                    continue;
                }

                if ($key != "product") {

                    if ($i == $length - 1) {
                        $sql .= " $key = '$value' ";
                    } else {
                        $sql .= " $key = '$value', ";
                    }
                } else {
                    $p_id = $value;
                }
            }

        }
        $sql .= " WHERE product = $p_id";

        echo $sql;

        DBHandler::execute($sql);

    }

    public static function addNewBasicProductDetails ($json_string) {

        $details = json_decode($json_string);
        $length = count($details);

        $sql = "INSERT INTO product_pool VALUES (0,";

        for ($i = 0; $i < $length; $i++) {

            foreach ($details[$i] as $key => $value) {
                if ($i == $length - 1) {
                    $sql .= "'$value')";
                } else {
                    $sql .= "'$value', ";
                }
            }

        }

        echo DBHandler::execute($sql);
    }

    public static function addNewAdvancedProductDetails ($json_string) {
        $details = json_decode($json_string);
        $length = count($details);
        // get the table_name
        $table_name = null;
        $p_id = null;
        for ($i = 0; $i < $length; $i++) {

            if (isset($table_name) && isset($p_id)) {
                break;

            } else {

                foreach ($details[$i] as $key => $value) {

                    if ($key == "table_name_new") {
                        $value = trim($value);
                        $table_name = str_replace(' ','_',$value);
                        break;
                    }
                    if ($key == "product_id") {
                        $p_id = $value;
                        break;
                    }

                }

            }

        }

        $sql = "INSERT INTO $table_name VALUES ($p_id,";
        for ($i = 0; $i < $length; $i++) {

            foreach ($details[$i] as $key => $value) {

                if ($key == 'table_name_new') {
                    continue;
                }

                if ($key != "product_id") {

                    if ($i == $length - 1) {
                        $sql .= "'$value')";
                    } else {
                        $sql .= "'$value',";
                    }
                }
            }

        }

        echo $sql;
        DBHandler::execute($sql);
    }

    public static function deleteProduct($id){
//        $details = json_decode($json_string);
//
//        echo "<pre>";
//        print_r($details);
//        echo "</pre>";
//
////        echo $details['pID'];
//
//        $id = null;
//        $table_name = null;
//
//        for ($i = 0; $i < count($details); $i++) {
//
//            if (isset($table_name) && isset($id)) {
//                break;
//
//            } else {
//
//                foreach ($details[$i] as $key => $value) {
//
//                    if ($key == "table") {
//                        $table_name = $value;
//                    }
//                    if ($key == "pID") {
//                        $id = $value;
//                    }
//
//                }
//
//            }
//
//        }

        $sql = "DELETE FROM product_pool WHERE product_id = $id";

        DBHandler::execute($sql);

        echo $sql;

    }

}