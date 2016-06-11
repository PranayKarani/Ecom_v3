<?php

class ProductView {

    private $id;
    private $details;

    public function __construct ($id) {
        $this->id = $id;

        $this->details = ProductController::getProductDetails($id);

    }

    public function show_basic_info(){

        $name = $this->details['product_name'];
        $brand = $this->details['brand'];
        $category = $this->details['category'];
        $filters = explode(' ',$this->details['filters']);


        echo "<strong>$brand</strong> $name <br>";
        echo "$category <br>";
        echo "<br/>";
        for($i = 0; $i < count($filters); $i++){
            $key = $filters[$i];
            $value = $this->details[$filters[$i]];
            echo "$key: $value<br>";
        }

    }

    public static function showNewProducts () {
        $products = ProductController::getNewProducts();

        $noofP = count($products);

        if ($noofP > 0) {
            for ($i = 0; $i < $noofP; $i++) {
                // product box
                $id = $products[$i]['product_id'];
                echo "<span class='product_link' id='$id'>";
                echo $products[$i]['product_name'];
                echo "</span><br>";
            }
        } else {
            echo "no products";
        }

    }

    public static function showTopProducts () {
        $products = ProductController::getTopProducts();

        $noofP = count($products);

        if ($noofP > 0) {
            for ($i = 0; $i < $noofP; $i++) {
                // product box
                $id = $products[$i]['product_id'];
                echo "<span class='product_link' id='$id'>";
                echo $products[$i]['product_name'];
                echo "</span><br>";
            }
        } else {
            echo "no products";
        }
    }

    public static function getCategoryTopProducts($category){

        $products = ProductController::getCategoryTopProducts($category);

        $noofP = count($products);

        if ($noofP > 0) {
            for ($i = 0; $i < $noofP; $i++) {
                // product box
                $id = $products[$i]['product_id'];
                echo "<div class='category_product_link' id='$id'>";
                echo $products[$i]['product_name'];
                echo "</div>";
            }
        } else {
            echo "no products";
        }

    }

    public static function showSearchProducts($search){

        $products = ProductController::getSearchedProducts($search);

        $noofP = count($products);

        echo "<strong>Products</strong><br>";

        if ($noofP > 0) {
            for ($i = 0; $i < $noofP; $i++) {

                $id = $products[$i]['product_id'];
                $name = $products[$i]['product_name'];
                $category = $products[$i]['category'];

                echo "<div class='search_product_link' id='$id'>";
                echo $name;
                echo " <em style='color: grey; font-size: small'>($category)</em>";
                echo "</div>";
            }
        } else {
            echo "no products like $search<br/>";
        }


    }



}