<?php

class AProductView {

    private $p_details;
    private $category_list;
    private $brand_list;

    public function __construct ($p_id) {
        $this->p_details = AProductController::getProductDetails($p_id);
        $this->category_list = ACategoryController::getCategories($this->p_details['department']);
        $this->brand_list = ABrandController::getBrands();
    }

    /**
     * Show UI for adding basic details for the new product
     */
    public static function show_ui_for_new ($category) {

        $filters = ACategoryController::getCategoryFilters($category);

        $quick_info = 'this is quick info';
        $thumbnail = 'NA.jpg';

        echo "<form>";
        echo "<h3>Basic</h3><br>";
        //TODO add image (thumbnail)
        // Product Name
        echo "Product Name: <input type='text' id='new_product_name' class='input_basic_new'/></br>";
        echo "<input type='hidden' value='$category' class='input_basic_new'/>";
        echo "<input type='hidden' id='quick_info' value='$quick_info' class='input_basic_new'/>";
        // brand
        ABrandView::showBrandSelector("new_brand", "input_basic_new");
        echo "Image: <input type='hidden' value='$thumbnail' class='input_basic_new'/><br>";
        // mrp
        echo "Mrp: <input type='number' min='0' id='new_mrp' class='input_basic_new'/><br>";
        // keywords
        echo "Keywords: <input type='text' style='width: 400px;' value='$category' id='new_keywords' class='input_basic_new' disabled/><br>";


        echo "<h3>Advance</h3><br>";


        echo "<input type='hidden' value='c__$category' id='table_name_new' class='input_advance_new'/>";
        foreach ($filters as $filter) {
            echo $filter;
            echo ": <input type='text' id='$filter' class='input_advance_new'><br/>";
        }

        // submit button
        echo "<input type='button' value='add' id='submit_new'>";

        echo "</form>";
    }

    /**
     * Show product basic info for all.
     * Non editable
     */
    public function show_basic(){

    }

    public function show_advance(){

    }

    /**
     * Shows basic product details are editable. e.g brand, price etc.
     * This is function is for admin
     * @param $p_id
     */
    public function show_basic_for_admin () {

        $id = $this->p_details['product_id'];
        $name = $this->p_details['product_name'];
        $img = $this->p_details['thumbnail'];
        $category = strtolower($this->p_details['category']);
        $brand = strtolower($this->p_details['brand']);
        $quick_info = strtolower($this->p_details['quick_info']);
        $mrp = $this->p_details['mrp'];
        $keywords = "$category $brand $name";

        echo "<form>";
        //TODO add image (thumbnail)
        // Product ID
        echo "ID: <input type='text' value='$id' id='product_id' class='input_basic' disabled><br>";
        // Product Name
        echo "Product Name: <input type='text' value='$name' id='product_name' class='input_basic'/></br>";
        // Category
        ACategoryView::showCategorySelector($this->p_details['department'], "category", "input_basic", $category, true);
        // quick info
        echo "Quick Info: <input type='text' value='$quick_info' id='quick_info' class='input_basic' disabled/><br>";
        // brand
        ABrandView::showBrandSelector("brand", "input_basic", $brand);
        // mrp
        echo "Mrp: <input type='number' value='$mrp' min='0' id='mrp' class='input_basic'/><br>";
        // keywords
        echo "Keywords: <input type='text' style='width: 400px' value='$keywords' id='keywords' class='input_basic' disabled/><br>";

        // submit button
        echo "<input type='button' value='update basic info' id='submit_basic' disabled>";

        echo "</form>";

    }

    public function show_advance_for_admin () {

        $filters_array = explode(' ', $this->p_details['filters']);

        $table_name = 'c__' . strtolower($this->p_details['category']);
        $id = $this->p_details['product_id'];

        echo "<form>";
        foreach ($filters_array as $filter) {
            $detail = $this->p_details[$filter];
            echo $filter;
            echo ": <input type='text' value='$detail' id='$filter' class='input_advance'><br/>";
        }
        echo "<input type='hidden' value='$table_name' id='table_name' class='input_advance'>";
        echo "<input type='hidden' value='$id' id='product' class='input_advance'>";
        echo "<input type='button' value='update additional info' id='submit_advance' disabled>";
        echo "</form>";

    }

}