<?php


class BrandView {

    public static function showBrandSelector ($element_id = null, $element_class = null, $brand = null) {

        $brand_list = BrandController::getBrands();

        $id = '';
        if (isset($element_id)) {
            $id = $element_id;
        }
        $class = '';
        if (isset($element_class)) {
            $class = $element_class;
        }

        echo "Brand: <select id='$id' class='$class'>";
        foreach ($brand_list as $b) {
            $b_n = $b['brand_name'];
            $b_n = strtolower($b_n);
            if ($b_n == $brand) {
                echo "<option value='$b_n' selected='selected'>$b_n</option>";
            } else {
                echo "<option value='$b_n'>$b_n</option>";
            }
        }
        echo "</select><br>";

    }

}