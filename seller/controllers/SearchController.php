<?php

/**
 * Created by PhpStorm.
 * User: PranayKarani
 * Date: 11/06/2016
 * Time: 01:52 AM
 */
class SearchController {
    public static function searchForProducts($search_text){
        return ProductController::getSearchedProducts($search_text);
    }
}