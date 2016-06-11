<?php

class ProductView {

    public static function showShopProducts ($shop_id) {

        $product_list = ProductController::getShopProducts($shop_id);

        $count = count($product_list);

        if ($count > 0) {

            echo "<tr>";
            echo "<th width='250' align='left'>Name</th>";
            echo "<th width='100' align='left'>Brand</th>";
            echo "<th width='100' align='left'>Quantity</th>";
            echo "<th width='150' align='left'>My Price</th>";
            echo "<th width='150' align='left'>MRP</th>";
            echo "</tr>";

            for ($i = 0; $i < $count; $i++) {

                $row = $product_list[$i];

                $id = $row['product_id'];
                $name = $row['product_name'];
                $brand = $row['brand'];
                $qty = $row['qty'];
                $price = $row['price'];
                $mrp = $row['mrp'];

                echo "<tr>";
                echo "<td><label class='product_link' id='$id'>$name</label></td>";
                echo "<td><label>$brand</label></td>";
                echo "<td><label>$qty</label></td>";
                echo "<td><label>$price</label></td>";
                echo "<td><label>$mrp</label></td>";

                echo "</tr>";


            }

//            echo "<pre>";
//            print_r($product_list);
//            echo "</pre>";

        } else {
            echo "No Products in your inventory";
        }

    }

    public static function showShopProductDetails ($json) {

        $details = ProductController::getShopProductDetails($json);

        $id = $details['product_id'];
        $name = $details['product_name'];
        $img = $details['thumbnail'];
        $brand = strtolower($details['brand']);
        $category = strtolower($details['category']);
        $mrp = $details['mrp'];
        $price = $details['price'];
        $qty = $details['qty'];
        $keywords = "$category $brand $name";

        echo "<form>";
        //TODO add image (thumbnail)
        // Product ID
        echo "ID: <input type='text' value='$id' id='product_id' disabled><br>";
        // Product Name
        echo "Product Name: <input type='text' value='$name' id='product_name' disabled/></br>";
        // Category
        echo "Category: <input type='text' value='$category' id='category' disabled/></br>";
        // brand
        echo "Brand: <input type='text' value='$brand' id='category' disabled/></br>";
        // mrp
        echo "Mrp: <input type='number' value='$mrp' min='0' id='mrp' disabled/><br>";

        // qty
        echo "Quantity: <input type='number' value='$qty' min='0' id='qty' class='input' /><br>";
        // My Price
        echo "My Price: <input type='number' value='$price' min='0' id='price' class='input' /><br>";

        // submit button
        echo "<input type='button' value='update' id='update'>";

        echo "</form>";


    }

    public static function showProductDetails ($json) {

        $details = ProductController::getShopProductDetails($json);

        // if product not in inventory, load from product pool without shop specific details
        if (!isset($details) || empty($details)) {
            $tmp_details = json_decode($json);

            $pID = 0;

            for ($i = 0; $i < count($tmp_details); $i++) {
                foreach ($tmp_details[$i] as $key => $value) {

                    if ($key == 'product') {
                        $pID = $value;
                    }
                }
            }
            $details = ProductController::getProductDetails($pID);
        }

        $id = $details['product_id'];
        $name = $details['product_name'];
        $img = $details['thumbnail'];
        $brand = strtolower($details['brand']);
        $category = strtolower($details['category']);
        $mrp = $details['mrp'];
        if (isset($details['price'])) {
            $price = $details['price'];
        } else {
            $price = 0;
        }
        if (isset($details['qty'])) {
            $qty = $details['qty'];
        } else {
            $qty = 0;
        }
        $keywords = "$category $brand $name";

        echo "<form>";
        //TODO add image (thumbnail)
        // Product ID
        echo "ID: <input type='text' value='$id' id='product_id' disabled><br>";
        // Product Name
        echo "Product Name: <input type='text' value='$name' id='product_name' disabled/></br>";
        // Category
        echo "Category: <input type='text' value='$category' id='category' disabled/></br>";
        // brand
        echo "Brand: <input type='text' value='$brand' id='category' disabled/></br>";
        // mrp
        echo "Mrp: <input type='number' value='$mrp' min='0' id='mrp' disabled/><br>";

        // qty
        echo "Quantity: <input type='number' value='$qty' min='0' id='qty' class='input' /><br>";
        // My Price
        echo "My Price: <input type='number' value='$price' min='0' id='price' class='input' /><br>";

        // submit button
        echo "<input type='button' value='update' id='update'>";

        echo "</form>";


    }


}