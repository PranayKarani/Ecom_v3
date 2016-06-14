<?php

/**
 * Created by PhpStorm.
 * User: PranayKarani
 * Date: 11/06/2016
 * Time: 01:52 AM
 */
class SSearchController {
    public static function searchForProducts($search_text){
        return SProductController::getSearchedProducts($search_text);
    }
}