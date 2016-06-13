<?php

class BrandView {

    public static function showCategoryBrands ($category) {

        $brands = BrandController::getCategoryBrands($category);

        $cat = str_replace(' ', '_', $category);
        $table = "c__" . strtolower(trim($cat));

        for ($i = 0; $i < count($brands); $i++) {

            $name = $brands[$i]['brand'];
            echo "<input type='checkbox' class='filter_checkbox' name='brand' datatype='$table' value='$name'/>$name <br>";

        }

    }

}