<?php

class BrandView {

    public static function showCategoryBrands ($category) {

        $brands = BrandController::getCategoryBrands($category);

//        $cat = str_replace(' ', '_', $category);
//        $table = "c__" . strtolower(trim($cat));

        for ($i = 0; $i < count($brands); $i++) {

            $name = $brands[$i]['brand'];
            echo "$name<br>";

        }

    }

    public static function showBrandFilters ($category) {

        $brands = ProductController::getCategoryBrandFilters($category);
        $count = count($brands);

        $cat = str_replace(' ', '_', $category);
        $table = "c__" . strtolower(trim($cat));

        echo "<div>";
        for ($j = 0; $j < $count; $j++) {
            $n = $brands[$j]['brand'];
            $c = $brands[$j]['c'];
            echo "<input type='checkbox' class='filter_checkbox' name='brand' datatype='$table' value='$n'/>$n ";
            echo "<span style='font-size: small; color: grey'>[$c]</span><br/>";
        }
        echo "</div><br>";

    }

}