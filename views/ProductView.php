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

    public static function showCategoryTopProducts ($category) {

        $products = ProductController::getCategoryTopProducts($category);

        $noofP = count($products);

        if ($noofP > 0) {
            echo "<strong style='font-size: larger'>Top Products</strong><br>";
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

    public static function showCategoryNewProducts ($category) {

        $products = ProductController::getCategoryNewProducts($category);

        $noofP = count($products);

        if ($noofP > 0) {
            echo "<strong style='font-size: larger'>New Products</strong><br>";
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


        if ($noofP > 0) {
            echo "<strong>Products</strong><br>";
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
            echo "<strong>Products</strong><br>";
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

    public static function showRatingFilters ($category) {

        $ratings = ProductController::getCategoryRatingFilters($category);
        $count = count($ratings);

        $cat = str_replace(' ', '_', $category);
        $table = "c__" . strtolower(trim($cat));

        echo "<div>";
        for ($j = 0; $j < $count; $j++) {
            $n = $ratings[$j]['rating'];
            $c = $ratings[$j]['c'];
            echo "<input type='checkbox' class='filter_checkbox' name='rating' datatype='$table' value='$n'/>$n ";
            echo "<span style='font-size: small; color: grey'>[$c]</span><br/>";
        }
        echo "</div><br>";

    }

    public static function showShopProducts ($shop_id) {
        $products = ProductController::getShopProducts($shop_id);
        $count = count($products);

        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {

                // product box
                $id = $products[$i]['product_id'];
                $name = $products[$i]['product_name'];
                $brand = $products[$i]['brand'];

                echo "<span class='shop_product_link' id='$id'>";
                echo "<strong>$brand</strong> $name";
                echo "</span><br>";

            }
        } else {
            echo "no products found";
        }
    }

    public static function showShopCategoryProducts ($shop_id, $category) {

        $products = ProductController::getShopCategoryProducts($shop_id, $category);
        $count = count($products);

        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {

                // product box
                $id = $products[$i]['product_id'];
                $name = $products[$i]['product_name'];
                $brand = $products[$i]['brand'];

                echo "<span class='shop_product_link' id='$id'>";
                echo "<strong>$brand</strong> $name";
                echo "</span><br>";

            }
        } else {
            echo "no $category" . "s found in this shop";
        }

    }

    public static function showOrderedSearchedProducts ($json) {
        $products = ProductController::getOrderedSearchedProducts($json);

        $noofP = count($products);


        if ($noofP > 0) {
            echo "<strong>Products</strong><br>";
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
            echo "no products found<br/>";
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