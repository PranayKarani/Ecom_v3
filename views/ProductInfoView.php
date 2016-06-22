<?php

/**
 * Class ProductInfoView
 * For formatting and displaying info of selected Product
 */
class ProductInfoView {

    private $id;
    private $details;
    private $similar;
    private $count;

    public function __construct ($id) {

        $this->id = $id;
        $this->details = ProductController::getProductDetails($id);
        $this->similar = ProductController::getSimilarProducts($id);
        $this->count = count($this->details);

    }

    public function show_name_and_brand () {

        $name = $this->details['product_name'];
        $brand = $this->details['brand'];

        echo "<strong style='font-size: 32px'>$name</strong><br>";
        echo "from <strong style='font-size: larger'>$brand</strong><br>";

    }

    public function show_price_range () {

        $max = $this->details['max_p'];
        $min = $this->details['min_p'];
        if ($max == $min) {
            echo "<strong>$max Rs</strong><br>";
        } else {
            echo "<strong>$min Rs - $max Rs</strong><br>";
        }

    }

    public function show_rating_stars () {
        $rating = $this->details['rating'];
        for ($i = 0; $i < $rating; $i++) {
            echo "<input type='image' src='http://www.clipartbest.com/cliparts/aTq/ogj/aTqogjjpc.png' style='width: 10px; margin-top: 5px'/> ";
        }
    }

    public function show_thumbnails () {

        // TODO change this method completey, this is demo mode
        for ($i = 0; $i < 4; $i++) {
            echo "<input type='image' class='thumbnail' src='res/images/product/default.png'/>";
        }

    }

    public function show_quick_info () {

        $quick_info = $this->details['quick_info'];

        echo "<strong style='font-size: larger'>Quick Info</strong>";
        echo "$quick_info";

    }

    public function show_shop_availability () {

        $a_score = $this->details['a_score'];

        echo "<strong>Available in <strong style='font-size: larger'>$a_score</strong> shops</strong>";

    }

    public function show_specs () {

        $filters = explode(' ', $this->details['filters']);
        $f_count = count($filters);

        echo "<strong style='font-size: larger'>Specs</strong>";
        echo "<table id='spec_table'>";
        foreach ($this->details as $key => $value) {

            for ($j = 0; $j < $f_count; $j++) {

                $filter = $filters[$j];

                if ($key == $filter) {
                    echo "<tr>";
                    echo "<td style='width: 125px'>$filter</td>";
                    echo "<td>$value</td>";
                    echo "</tr>";
                }

            }

        }
        echo "</table>";

    }

    public function show_shop_list () {

        $shops = ShopController::getProductShops($this->id);
        $s_count = count($shops);

        // TODO remove this for loop later
        for ($x = 0; $x < 1; $x++) {
            for ($i = 0; $i < $s_count; $i++) {

                $id = $shops[$i]['shop_id'];
                $name = $shops[$i]['shop_name'];
                $contact = $shops[$i]['shop_contact'];
                $price = $shops[$i]['price'];
                $loc_x = $shops[$i]['loc_x'];
                $loc_y = $shops[$i]['loc_y'];

                $image = "res/images/shop/shop.png";

                echo "<div class='shop_box' id='$id'>";
                echo "<input type='hidden' id='loc_x' value='$loc_x'/>";
                echo "<input type='hidden' id='loc_y' value='$loc_y'/>";
                // left
                echo "<div class='shop_box_left'>";
                echo "<input type='image' src='$image' style='width: 100%;  float: left;'/>";
                echo "</div>";
                // right
                echo "<div class='shop_box_right'>";
                echo "<strong class='shop_name'>$name</strong><br>";
                echo "Contact: $contact<br>";
                // TODO show open or not
                // TODO explore shop option (go to shop page)
                echo "Rate: <strong>$price Rs</strong><br>";
                echo "<input type='button' value='order'/>";
                echo "<input class='walkIn' type='button' value='get route'/>";
                echo "</div>";
                echo "</div>";

            }
        }

    }

    public function show_similar_products () {

        $s_count = count($this->similar);

        echo "<strong style='font-size: larger'>Similar Products</strong><br>";
        for ($i = 0; $i < $s_count; $i++) {

            $product = $this->similar[$i];

            ProductView::product_box($product);

        }

    }

}