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
	
	public function show_image () {
		echo '<input type="image" id="product_image" src="res/images/product/default0.jpg"/>';
	}
	
	public function show_wishlist_thumbnail () {
		
		wishlistThumbnail($this->details['w'], $this->id);
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
			echo "<input type='image' src='http://image.flaticon.com/icons/png/512/40/40403.png' style='width: 15px; margin-top: 5px'/> ";
		}
	}

	public function show_thumbnails () {
		// TODO change this method completey, this is demo mode
		for ($i = 0; $i < 5; $i++) {
			echo "<input type='image' class='thumbnail' id='$i' src='res/images/product/default$i.jpg'/>";
		}

	}

	public function show_quick_info () {
		$quick_info = $this->details['quick_info'];
		echo "<strong style='font-size: larger'>Quick Info</strong>";
		echo "$quick_info";

	}

	public function show_shop_availability () {
		$a_score = $this->details['a_score'];
		if ($a_score > 1) {
			echo "<strong>Available in <strong style='font-size: larger'>$a_score</strong> shops</strong>";
		} else {
			echo "<strong>Available in <strong style='font-size: larger'>$a_score</strong> shop</strong>";
		}

	}

	public function show_specs () {
		$filters = explode(' ', $this->details['filters']);
		$f_count = count($filters);
		echo "<h3 style='font-size: larger; text-align: center'>Specs</h3>";
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

	public function show_description () {
		$desc = $this->details['description'];
		echo $desc;

	}

	public function show_shop_list () {
		$shops = ShopController::getProductShops($this->id);
		$s_count = count($shops);
		
		$uID = cookieSet(COOKIE_USER_ID);
		$uID = $uID < 0 ? 0 : $uID;
		
		// TODO remove this for loop later
		for ($x = 0; $x < 1; $x++) {
			for ($i = 0; $i < $s_count; $i++) {

				$open = false;

				$id = $shops[$i]['shop_id'];
				$name = $shops[$i]['shop_name'];
				$contact = $shops[$i]['shop_contact'];
				$price = $shops[$i]['price'];
				$loc_x = $shops[$i]['loc_x'];
				$loc_y = $shops[$i]['loc_y'];
				$image = "res/images/shop/shop.png";

				$timeNow = strtotime(date("H:i:s", time()));

				$open_time = $shops[$i]['open_time'];
				$close_time = $shops[$i]['close_time'];
				$str_open_time = strtotime($open_time);
				$str_close_time = strtotime($close_time);

				$open_time_string = date("h:i a", $str_open_time);
				$close_time_string = date("h:i a", $str_close_time);

				$hD = $shops[$i]['home_delivery'];

				$homeDelivery = $hD == 1 ? true : false;

				if ($timeNow > $str_open_time && $timeNow < $str_close_time) {

					// OPEN
					$open = true;

				} // else CLOSED
				
				echo date("h:i:a", time());
				
				if ($open) {
					echo "<div class='shop_box_open' id='$id'>";

					// top
					echo "<div class='shop_box_top_open'>";
					echo "<input type='hidden' id='loc_x' value='$loc_x'/>";
					echo "<input type='hidden' id='loc_y' value='$loc_y'/>";
					// top left
					echo "<div class='shop_box_top_left_open'>";
					echo "<input type='image' src='$image' style='width: 100%;  float: left;'/>";
					echo "</div>";
					// top right
					echo "<div class='shop_box_top_right_open' data-id='$id'>";
					echo "<strong class='shop_name'>$name</strong><br>";
					echo "<span style='font-size: small'>Contact: $contact</span><br>";
					echo "Rate: <strong>$price Rs</strong><br>";
					echo "<span style='font-size: smaller'>($open_time_string - $close_time_string)</span><br>";
					echo "</div>";
					echo "</div>";

					// bottom
					echo "<div class='shop_box_bottom_open'>";
					if ($homeDelivery) {
						echo "<input class='order' type='button' value='order for home delivery'/>";
					} else {
						echo "<input class='order' type='button' value='no home delivery :(' disabled/>";
					}
					echo "<input class='walkIn' type='button' value='get route' data-uid='$uID' data-sid='$id' data-pid='$this->id' data-price='$price'/>";
					echo "<input class='cart' type='button' value='add to cart' onclick='addToCart($id, $this->id, $price)'/>";
					echo "</div>";
					echo "</div>";

				} else {

					echo "<div class='shop_box_close' id='$id'>";
					// top
					echo "<div class='shop_box_top_close'>";
					echo "<input type='hidden' id='loc_x' value='$loc_x'/>";
					echo "<input type='hidden' id='loc_y' value='$loc_y'/>";
					// top left
					echo "<div class='shop_box_top_left_close'>";
					echo "<input type='image' src='$image' style='width: 100%;  float: left;'/>";
					echo "</div>";
					// top right
					echo "<div class='shop_box_top_right_close'>";
					echo "<strong class='shop_name'>$name</strong><br>";
					echo "<span style='font-size: small'>Contact: $contact</span><br>";
					echo "Rate: <strong>$price Rs</strong><br>";
					echo "<span style='font-size: smaller'>($open_time_string - $close_time_string)</span><br>";
					echo "<strong style='color: red;'>CLOSED</strong><br>";
					echo "</div>";
					echo "</div>";

					// bottom
					echo "<div class='shop_box_bottom_close'>";
					if ($homeDelivery) {
						echo "<input class='order' type='button' value='order for home delivery' disabled/>";
					} else {
						echo "<input class='order' type='button' value='home delivery unavailable' disabled/>";
					}
					echo "<input class='walkIn' type='button' value='get route' data-uid='$uID' data-sid='$id' data-pid='$this->id' data-price='$price'/>";
					echo "<input class='cart' type='button' value='add to cart' onclick='addToCart($id, $this->id, $price)'/>";
					echo "</div>";
					echo "</div>";
				}

			}
		}

	}

	public function show_similar_products () {
		$s_count = count($this->similar);
		echo "<strong style='font-size: larger'>Similar Products</strong><br>";
		for ($i = 0; $i < $s_count; $i++) {
			$product = $this->similar[$i];
			ProductView::product_box($product, false);

		}

	}

}