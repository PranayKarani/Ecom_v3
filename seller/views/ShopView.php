<?php

/**
 * Created by PhpStorm.
 * User: PranayKarani
 * Date: 11/06/2016
 * Time: 02:08 AM
 */
class ShopView {

    public static function showShopsSelector ($seller_id, $id = null, $class = null, $d = null) {
        $list = SellerController::getSellerShopsList($seller_id);

        if ($d == true) {
            echo "Shop Select: <select id='$id' class='$class' disabled>";
        } else {
            echo "Shop Select: <select id='$id' class='$class' >";
        }
        foreach ($list as $shop) {
            $s_n = $shop['shop_name'];
            $s_id = $shop['shop_id'];

            echo "<option value='$s_id'>$s_n</option>";

        }
        echo "</select>";
    }

}