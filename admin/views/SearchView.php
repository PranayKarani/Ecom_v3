<?php

class SearchView {

    public static function showProductsSearch ($search_text) {

        $search_results = SearchController::searchForProducts($search_text);

        $search_size = count($search_results);

        if($search_size > 0){
            for($i = 0; $i < $search_size; $i++){
                $id = $search_results[$i]['product_id'];
                $name = $search_results[$i]['product_name'];
                $category = $search_results[$i]['category'];
                $brand = $search_results[$i]['brand'];
                if($i%2==0){
                    echo "<div class='search_result_link' style='background-color: #dfefff;'>";
                } else {
                    echo "<div class='search_result_link'>";
                }
                echo "<input type='hidden' name='id' value='$id'/>";
                echo "<input type='hidden' name='category' value='$category'/>";
                echo "<input type='hidden' name='brand' value='$brand'/>";
                echo "<span class='product_name_link'><b>$brand</b>, $name</span>";
                echo "<em style='color: gray; font-size: small'> ($category)</em>";
                echo "</div>";
            }
        } else {
            echo "no results found for <em>$search_text</em>";
        }


    }

    public static function showCategorySearch ($search_text) {

        $search_results = SearchController::searchForCategories($search_text);

        $search_size = count($search_results);

        if($search_size > 0){
            for($i = 0; $i < $search_size; $i++){
                $name = $search_results[$i]['category_name'];
                $dept = $search_results[$i]['department'];
                $filters = $search_results[$i]['filters'];

                echo "<div class='search_result_link'>";
                echo "<input type='hidden' name='name' value='$name'/>";
                echo "<input type='hidden' name='dept' value='$dept'/>";
                echo "<input type='hidden' name='filters' value='$filters'/>";
                echo $name;
                echo "</div>";
            }
        } else {
            echo "no results found for <em>$search_text</em>";
        }


    }

    public static function showShopSearch($search_text){
        $search_results = SearchController::searchForShops($search_text);

        $search_size = count($search_results);

        if($search_size > 0){
            for($i = 0; $i < $search_size; $i++){
                $id = $search_results[$i]['shop_id'];
                $name = $search_results[$i]['shop_name'];

                echo "<div class='search_result_link'>";
                echo "<input type='hidden' name='id' value='$id'/>";
                echo $name;
                echo "</div>";
            }
        } else {
            echo "no results found for <em>$search_text</em>";
        }
    }


}