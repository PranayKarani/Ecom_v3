<?php

class ProductView {

    private $id;
    private $details;

    public function __construct ($id) {
        $this->id = $id;

        $this->details = ProductController::getProductDetails($id);

    }

    public static function showNewProducts ($lmt) {
        $products = ProductController::getNewProducts($lmt);

        $noofP = count($products);

        if ($noofP > 0) {
            for ($i = 0; $i < $noofP; $i++) {
                // product box

                $id = $products[$i]['product_id'];
                $name = $products[$i]['product_name'];
                $brand = $products[$i]['brand'];

                echo "<span class='product_link' id='$id'>";
                echo "<strong>$brand</strong> $name";
                echo "</span><br>";
            }
        } else {
            echo "no products";
        }

    }

    public static function showTopProducts ($lmt) {
        $products = ProductController::getTopProducts($lmt);

        $noofP = count($products);

        if ($noofP > 0) {
            for ($i = 0; $i < $noofP; $i++) {
                // product box
                $id = $products[$i]['product_id'];
                $name = $products[$i]['product_name'];
                $brand = $products[$i]['brand'];

                echo "<span class='product_link' id='$id'>";
                echo "<strong>$brand</strong> $name";
                echo "</span><br>";
            }
        } else {
            echo "no products";
        }
    }

    public static function getCategoryTopProducts ($category) {

        $products = ProductController::getCategoryTopProducts($category);

        $noofP = count($products);

        if ($noofP > 0) {
            for ($i = 0; $i < $noofP; $i++) {
                // product box
                $id = $products[$i]['product_id'];
                $name = $products[$i]['product_name'];
                $brand = $products[$i]['brand'];

                echo "<span class='category_product_link' id='$id'>";
                echo "<strong>$brand</strong> $name";
                echo "</span><br>";
            }
        } else {
            echo "no products";
        }

    }

    public static function getCategoryNewProducts ($category) {

        $products = ProductController::getCategoryNewProducts($category);

        $noofP = count($products);

        if ($noofP > 0) {
            for ($i = 0; $i < $noofP; $i++) {
                // product box
                $id = $products[$i]['product_id'];
                $name = $products[$i]['product_name'];
                $brand = $products[$i]['brand'];

                echo "<span class='category_product_link' id='$id'>";
                echo "<strong>$brand</strong> $name";
                echo "</span><br>";
            }
        } else {
            echo "no products";
        }

    }

    public static function showSearchDropdownProducts ($search) {

        $products = ProductController::getSearchedProducts($search);

        $noofP = count($products);


        if ($noofP > 0) {
            echo "<strong>Products</strong><br>";
            for ($i = 0; $i < $noofP; $i++) {

                $id = $products[$i]['product_id'];
                $name = $products[$i]['product_name'];
                $category = $products[$i]['category'];

                echo "<div class='search_product_link' id='$id'>";
                echo "<input type='hidden' value='$category' name='product_category_name'/>";
                echo $name;
                echo " <em style='color: grey; font-size: small'>($category)</em>";
                echo "</div>";
            }
        }

    }

    public static function showSearchedProducts ($search) {
        $products = ProductController::getSearchedProducts($search);

        $noofP = count($products);

        echo "<strong>Products</strong><br>";

        if ($noofP > 0) {
            for ($i = 0; $i < $noofP; $i++) {

                $id = $products[$i]['product_id'];
                $name = $products[$i]['product_name'];
                $category = $products[$i]['category'];
                $brand = $products[$i]['brand'];

                echo "<span class='product_link' id='$id'>";
                echo "<input type='hidden' value='$category' name='product_category_name'/>";
                echo "<strong>$brand</strong> $name";
                echo "</span><br>";
            }
        } else {
            echo "no products like $search<br/>";
        }
    }

    public static function showFilteredProducts ($json) {

        $products = ProductController::getFilteredProducts($json);
        $count = count($products);

        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {

                // product box
                $id = $products[$i]['product_id'];
                $name = $products[$i]['product_name'];
                $brand = $products[$i]['brand'];

                echo "<span class='filtered_product_link' id='$id'>";
                echo "<strong>$brand</strong> $name";
                echo "</span><br>";

            }
        } else {
            echo "no such products found";
        }


    }

    public function show_basic_info () {

        $name = $this->details['product_name'];
        $brand = $this->details['brand'];
        $category = $this->details['category'];
        $mrp = $this->details['mrp'];
        $filters = explode(' ', $this->details['filters']);


        echo "<strong>$brand</strong> $name <br>";
        echo "$category <br>";
        echo "MRP: $mrp Rs <br>";
        echo "<br/>";
        for ($i = 0; $i < count($filters); $i++) {
            $key = $filters[$i];
            $value = $this->details[$filters[$i]];
            echo "$key: $value<br>";
        }

    }


}