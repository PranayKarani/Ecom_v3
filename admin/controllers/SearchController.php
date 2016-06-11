<?php

class SearchController {

    public static function searchForProducts($search_text){
        return ProductController::getSearchedProducts($search_text);
    }

    public static function searchForShops($search_text){
        return ShopController::getSearchedShops($search_text);
    }

    public static function searchForCategories($search_text){
        return CategoryController::getSearchedCategories($search_text);
    }


}