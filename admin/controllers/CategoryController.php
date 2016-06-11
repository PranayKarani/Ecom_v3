<?php

class CategoryController {

    public static function getCategories ($dept_name) {

        $sql = "CALL get_category_list(:dpt_name)";
        $params = array( ':dpt_name' => $dept_name );

        return DBHandler::getAll($sql, $params);

    }

    public static function getCategoryFilters ($category) {
        $sql = "CALL get_category_details(:c_name)";
        $params = array( ':c_name' => $category );

        $data = DBHandler::getRow($sql, $params);

        $filters = $data['filters'];

        return explode(" ", $filters);
    }

    public static function getSearchedCategories ($search_text) {
        $sql = "CALL get_searched_categories('$search_text')";

        return DBHandler::getAll($sql);
    }

    public static function getCategoryDetails ($name) {
        $sql = "CALL get_category_details('$name')";

        return DBHandler::getRow($sql);
    }

    public static function addNewCategory ($json_string) {
        // TODO also create new 'c__' table
        $details = json_decode($json_string);
        $length = count($details);
        $name = '';
        $filters = array();
//        echo "<pre>";
//        print_r($details);
//        echo "</pre>";

        $sql = "INSERT INTO category VALUES (";
        for ($i = 0; $i < $length; $i++) {

            foreach ($details[$i] as $key => $value) {
                if ($key == 'new_filters') {
                    $filters = explode(' ', $value);
                }
                if ($key == 'new_name') {
                    $name = $value;
                }
                if ($i == $length - 1) {
                    $sql .= "'$value');";
                } else {
                    $sql .= "'$value',";
                }
            }

        }

        echo $sql;
        echo "\n";
        DBHandler::execute($sql);

        // Creating new category table
        $name = str_replace(' ', '_', trim($name));
        $table_name = 'c__' . $name;

        $sql = "CREATE TABLE $table_name (product INT UNSIGNED,";
        foreach ($filters as $filter){
            $sql.="$filter VARCHAR(255), ";
        }

        $sql.="FOREIGN KEY (product) REFERENCES product_pool(product_id) ON DELETE CASCADE );";

        echo $sql;
        DBHandler::execute($sql);


    }

    public static function updateCategory ($json_string) {
        // change column name
        // add new column

    }

    public static function deleteCategory ($name) {

        $sql = "DELETE FROM category WHERE category_name = '$name'";
        DBHandler::execute($sql);
        echo $sql;
        echo "\n";


        $name = str_replace(' ', '_', trim($name));
        $table_name = 'c__' . $name;
        $sql = "DROP TABLE $table_name";
        DBHandler::execute($sql);
        echo $sql;



    }


}