<?php

class SProductView {

    public static function showShopProducts ($shop_id) {

        $product_list = SProductController::getShopProducts($shop_id);

        $count = count($product_list);


        if ($count > 0) {

            echo "<table id='inventory_table'>";
            echo "<tr>";
            echo "<th width='150' align='left' class='table_header'>Category</th>";
            echo "<th width='300' align='left' class='table_header'>Name</th>";
            echo "<th width='100' align='left' class='table_header'>Brand</th>";
            echo "<th width='30' align='left' class='table_header'>Qty</th>";
            echo "<th width='100' align='left' class='table_header'>My Price</th>";
            echo "<th width='100' align='left' class='table_header'>MRP</th>";
            echo "</tr>";

            $total_qty = 0;
            $total_price = 0;
            $total_mrp = 0;

            for ($i = 0; $i < $count; $i++) {

                $row = $product_list[$i];

                $id = $row['product_id'];
                $name = $row['product_name'];
                $category = $row['category'];
                $brand = $row['brand'];
                $qty = $row['qty'];
                $price = $row['price'];
                $mrp = $row['mrp'];

                $total_qty += $qty;
                $total_price += $price;
                $total_mrp += $mrp;

                echo "<tr class='product_link' id='$id'>";
                echo "<td class='table_element'><label>$category</label></td>";
                echo "<td class='table_element'><label>$name</label></td>";
                echo "<td class='table_element'><label>$brand</label></td>";
                echo "<td class='table_element'><label>$qty</label></td>";
                echo "<td class='table_element'><label>$price</label></td>";
                echo "<td class='table_element'><label>$mrp</label></td>";
                echo "</tr>";


            }
            echo "<tr id='table_total'>";
            echo "<td><label style='font-size: large'>Total</label></td>";
            echo "<td><label></label></td>";
            echo "<td><label></label></td>";
            echo "<td class='table_element'><label>$total_qty</label></td>";
            echo "<td class='table_element'><label>$total_price</label></td>";
            echo "<td class='table_element'><label>$total_mrp</label></td>";
            echo "</tr>";
            echo "</table>";


        } else {
            echo "No Products in your inventory";
        }

    }

    public static function showShopProductDetails ($json) {

        $details = SProductController::getShopProductDetails($json);

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
	    echo "Quantity: <input type='number' value='$qty' min='1' id='qty' class='input' /><br>";
        // My Price
        echo "My Price: <input type='number' value='$price' min='0' id='price' class='input' /><br>";

        // submit button
	    echo "<input type='button' value='update' id='update'> <span style='color: red'>Add Remove button later</span>";

        echo "</form>";


    }

    public static function showProductDetails ($json) {

        $details = SProductController::getShopProductDetails($json);

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
            $details = SProductController::getProductDetails($pID);
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