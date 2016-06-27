<?php

class ShopView {

	public static function showSearchedShops ($search) {
		$shops = ShopController::getSearchedShops($search);

		$noofP = count($shops);

		if ($noofP > 0) {
			echo "<strong>Shops</strong><br>";
			for ($i = 0; $i < $noofP; $i++) {

				$id = $shops[$i]['shop_id'];
				$name = $shops[$i]['shop_name'];

				echo "<div class='search_shop_link' id='$id'>";
				echo $name;
				echo "</div>";
			}
		}
	}

    public static function showShopInfo ($shop_id) {

        $details = ShopController::getShopInfo($shop_id);

        $name = $details['shop_name'];
        $dept = $details['department'];
        $desc = $details['shop_desc'];
        $contact = $details['shop_contact'];
        $addr = $details['shop_address'];

        $seller_name = $details['seller_name'];

        echo "<strong>Shop Info</strong><br>";
        echo "Name: $name<br>";
        echo "Deparment: $dept<br>";
        echo "Owner: $seller_name<br>";
        echo "Description: $desc<br>";
        echo "Contact: $contact<br>";
        echo "Address: $addr<br>";


    }

    public static function showSimilarShops ($shop_id) {

        $shops = ShopController::getSimilarShops($shop_id);
        $noofP = count($shops);


        if ($noofP > 0) {
            echo "<strong>Similar Shops</strong><br>";
            for ($i = 0; $i < $noofP; $i++) {

                $id = $shops[$i]['shop_id'];
                $name = $shops[$i]['shop_name'];

                echo "<div class='shop_list' id='$id'>";
                echo $name;
                echo "</div>";
            }
        } else {
            echo "no similar shops found";
        }
    }

    public static function showNearByShops ($search) {

        $shops = ShopController::getKeywordShops($search);

        $noofP = count($shops);


        if ($noofP > 0) {
            echo "<strong>Shops List</strong><br>";
            for ($i = 0; $i < $noofP; $i++) {

                $id = $shops[$i]['shop_id'];
                $name = $shops[$i]['shop_name'];

                echo "<div class='shop_list' id='$id'>";
                echo $name;
                echo "</div>";
            }
        } else {
            echo "no shops found for $search";
        }


    }

    public static function showCategoryShops ($category) {

        $shops = ShopController::getCategoryShops($category);

        $noofP = count($shops);


        if ($noofP > 0) {
            echo "<strong>Shops List</strong><br>";
            for ($i = 0; $i < $noofP; $i++) {

                $id = $shops[$i]['shop_id'];
                $name = $shops[$i]['shop_name'];

                echo "<div class='shop_list' id='$id'>";
                echo $name;
                echo "</div>";
            }
        } else {
            echo "no shops found for $category";
        }

    }

}