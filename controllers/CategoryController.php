<?php

class CategoryController {

    public static function getCategories($dept_name){

        $sql = "CALL get_category_list(:dpt_name)";
        $params = array(':dpt_name'=>$dept_name);

        return DBHandler::getAll($sql, $params);

    }

    public static function getSearchedCategories($search){

        $search = stripslashes($search);
//        $search = preg_replace('#[+*()%-~@\'"]#', '', $search);
        $replacements = array( '+', '-', '*', '~', '@', '%', '(', ')', '<', '>', '\'', '"', '\\' );
        $search = str_replace($replacements, '', $search);

        $sql = "CALL get_searched_categories('$search',3)";

        return DBHandler::getAll($sql);

    }

    public static function getFilters ($category) {

//        $cat = str_replace(' ','_',$category);
//        $table = "c__".strtolower(trim($cat));
        $sql = "SELECT filters FROM category WHERE category_name = '$category'";

        return DBHandler::getValue($sql);

    }

    public static function getFilterData ($table, $filter) {

        $sql = "SELECT $filter, COUNT($filter) AS c FROM $table GROUP BY $filter";

        return DBHandler::getAll($sql);

    }

}