<?php

class CategoryView {

    public static function show($dept){

        $category_array = CategoryController::getCategories($dept);

        for ($i = 0; $i < count($category_array); $i++) {

            $cat_name = $category_array[$i]['category_name'];

            echo "<div class='category_link'>";
            echo $cat_name;
            echo "</div>";

        }
    }

    public static function showSearchedCategories($search_text){

        $cats = CategoryController::getSearchedCategories($search_text);

        $noofP = count($cats);

        echo "<strong>Categories</strong><br>";

        if ($noofP > 0) {
            for ($i = 0; $i < $noofP; $i++) {

                $name = $cats[$i]['category_name'];

                echo "<div class='search_category_link' id='$name'>";
                echo $name;
                echo "</div>";
            }
        } else {
            echo "no such categories like $search_text<br>";
        }

    }

}