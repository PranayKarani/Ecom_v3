<?php

class ASearchController {

    public static function searchForProducts($search_text){
        return AProductController::getSearchedProducts($search_text);
    }

    public static function searchForShops($search_text){
        return AShopController::getSearchedShops($search_text);
    }

    public static function searchForCategories($search_text){
        return ACategoryController::getSearchedCategories($search_text);
    }


}