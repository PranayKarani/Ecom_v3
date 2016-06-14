<?php

class AShopView {

    private $s_id;
    private $s_details;// shop details
    private $o_details;// owner details

    public function __construct ($id) {
        $this->s_id = $id;
        $this->s_details = AShopController::getShopDetails($id);
        $this->o_details = AShopController::getShopOwnerDetails($id);

    }

    public static function showAddNewShop () {

        echo "<form>";

        echo "Name: <input type='text' id='shop_name' class='input_new'/><br>";
        ADepartmentView::showDepartmentSelector(null, 'department', 'input_new', false);
        self::showOwnerSelector(null, 'seller', 'input_new');
        echo "Contact: <input type='text'  id='shop_contact' class='input_new'/><br>";
        echo "<input type='hidden' id='shop_image' value='NA.jpg' class='input_new'/>";
        echo "Description: <input type='text' id='shop_desc' class='input_new'/><br>";
        echo "Address: <input type='text' id='shop_address' class='input_new'/><br>";
        echo "Loc X: <input type='number'  id='loc_x' class='input_new'/><br>";
        echo "Loc Y: <input type='number'  id='loc_y' class='input_new'/><br>";
//        echo "<input type='hidden' id='keywords' value='-' class='input_new'/>";
//        echo "<input type='hidden' id='open' value='-' class='input_new'/>";
        echo "Inventory Size: <input type='number' value='250' id='inv_size' class='input_new' min='250' step='50'/><br>";


        // submit button
        echo "<input type='button' value='add new shop' id='submit_new'>";

        echo "</form>";


    }

    public function show_details () {

        $id = $this->s_details['shop_id'];
        $name = $this->s_details['shop_name'];
        $dept = $this->s_details['department'];
        $desc = $this->s_details['shop_desc'];
        $contact = $this->s_details['shop_contact'];
        $addr = $this->s_details['shop_address'];
        $locX = $this->s_details['loc_x'];
        $locY = $this->s_details['loc_y'];
        $inv = $this->s_details['inv_size'];


        $seller_id = $this->o_details['seller_id'];

        echo "<form>";

        echo "ID: <input type='text' value='$id' id='shop_id' class='input' disabled><br>";
        echo "Name: <input type='text' value='$name' id='shop_name' class='input'/><br>";
        echo "<input type='hidden' value='$seller_id' id='old_seller' class='input'/>";
        ADepartmentView::showDepartmentSelector($dept, 'department', 'input', true);
        self::showOwnerSelector($seller_id, 'seller', 'input');
        echo "Description: <input type='text' value='$desc' id='shop_desc' class='input'/><br>";
        echo "Contact: <input type='text' value='$contact' id='shop_contact' class='input'/><br>";
        echo "Address: <input type='text' value='$addr' id='shop_address' class='input'/><br>";
        echo "Loc X: <input type='number' value='$locX' id='loc_x' class='input'/><br>";
        echo "Loc Y: <input type='number' value='$locY' id='loc_y' class='input'/><br>";
        echo "Inventory Size: <input type='number' value='$inv' id='inv_size' class='input' min='250' step='50'/><br>";

        // submit button
        echo "<input type='button' value='update info' id='submit_update' disabled>";

        echo "</form>";


    }

    public static function showOwnerSelector ($seller_id = null, $id = null, $class = null, $d = null) {

        $list = AShopController::getSellersList();

        echo "Shop Owner: <select id='$id' class='$class' $d>";
        foreach ($list as $dept) {
            $o_n = $dept['seller_name'];
            $o_id = $dept['seller_id'];

            if (!isset($seller_id)) {
                echo "<option value='$o_id'>$o_n</option>";
            } else {
                if ($o_id == $seller_id) {
                    echo "<option value='$o_id' selected='selected'>$o_n</option>";
                } else {
                    echo "<option value='$o_id'>$o_n</option>";
                }
            }
        }
        echo "</select><br>";

    }

    public function show_products () {

        $p_list = AShopController::getShopProducts($this->s_id);

        if (count($p_list) == 0) {
            echo "No Products";
        } else {
            foreach ($p_list as $item) {
                $name = $item['product_name'];
                echo "$name </br>";
            }

        }
    }

}
