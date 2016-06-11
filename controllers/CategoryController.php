<?php

class CategoryController {

    public static function getCategories($dept_name){

        $sql = "CALL get_category_list(:dpt_name)";
        $params = array(':dpt_name'=>$dept_name);

        return DBHandler::getAll($sql, $params);

    }

    public static function getSearchedCategories($search){

        $sql = "CALL get_searched_categories('$search',3)";

        return DBHandler::getAll($sql);

    }

}