<?php

/**
 * Created by PhpStorm.
 * User: PranayKarani
 * Date: 11/06/2016
 * Time: 01:51 AM
 */
class SearchView {

    public static function showProductsSearch ($search_text) {

        $search_results = SearchController::searchForProducts($search_text);

        $search_size = count($search_results);

        if ($search_size > 0) {
            for ($i = 0; $i < $search_size; $i++) {
                $id = $search_results[$i]['product_id'];

                $name = $search_results[$i]['product_name'];
                $brand = $search_results[$i]['brand'];
                $category = $search_results[$i]['category'];
                $mrp = $search_results[$i]['mrp'];
                $info = $search_results[$i]['quick_info'];

                echo "<div class='search_result_link'>";
                echo "<input type='hidden' name='id' value='$id'/>";
                echo "<input type='hidden' name='category' value='$category'/>";
                echo "<input type='hidden' name='brand' value='$brand'/>";
                echo "<input type='hidden' name='mrp' value='$mrp'/>";
                echo "<input type='hidden' name='info' value='$info'/>";
                echo $name;
                echo "</div>";
            }
        } else {
            echo "no results found for <em>$search_text</em>";
        }


    }
}