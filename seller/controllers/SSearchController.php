<?php

class SSearchController {
    public static function searchForProducts($search_text){
        return SProductController::getSearchedProducts($search_text);
    }
}