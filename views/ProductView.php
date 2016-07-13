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
		echo "<br><h2>New Products</h2>";
		if ($noofP > 0) {
			for ($i = 0; $i < $noofP; $i++) {
				// product box
				self::product_box($products[$i], false);
			}
		} else {
			echo "no products";
		}
	}
	
	public static function product_box ($product, $compare) {
		$id = $product['product_id'];
		$name = $product['product_name'];
		$brand = $product['brand'];
		$quick_info = $product['quick_info'];
		$rating = $product['rating'];
		$category = $product['category'];
		if (isset($product['w'])) {
			$inWish = $product['w'];
		}
		$str_length = 18;
		if (strlen($name) > $str_length) {
			$name = substr($name, 0, $str_length) . "...";
		}
		echo "<div class='product_box' >";
		echo "<div class='product_link' id='$id' onclick='openProductInfo($id)'>";
		echo "<input type='image' class='product_image' src='res/images/product/default0.jpg'>";
		echo "<div class='name_raing_box'>";
		echo "$name<br>";
		echo "<span style='font-size: small'>from <strong style='font-weight: bolder'>$brand</strong></span><br>";
		echo "<input type='hidden' value='$category' name='product_category_name'/>";
		for ($i = 0; $i < $rating; $i++) {
			echo "<input type='image' src='res/images/extra/ratingStar.png' style='width: 15px; margin-top: 5px'/> ";
		}
		echo "</div>";
		echo "<div class='quick_info_box'>$quick_info</div>";
		echo "</div>";
		echo "<div class='button_box'>";
		if ($compare) {
			$compare_category = '"' . $category . '"';
			echo "<input type='button' value='compare' class='add_to_compare' onclick='addToCompare($id,$compare_category)'/>";
		}
		echo "</div>";
		
		if (isset($inWish)) {
			
			if ($inWish > 0) {
				echo "<span class='add_to_wishlist'>";
				echo "<input 
						class='wishlist_thumbnail' 
						type='image' 
						name='$id' 
						data-id='$id' 
						data-in='1' 
						onclick='toggleThumbnail(this)' 
						src='res/images/extra/cross.png' 
						style='width: 100%;outline: none' 
						title='remove from wishlist'/>";
				echo "</span>";
			} else {
				echo "<span class='add_to_wishlist'>";
				echo "<input 
						class='wishlist_thumbnail' 
						type='image' 
						name='$id' 
						data-id='$id' 
						data-in='0' 
						onclick='toggleThumbnail(this)' 
						src='res/images/extra/heart.png' 
						style='width: 100%;outline: none' 
						title='add to wishlist'/>";
				echo "</span>";
			}
			
		} else {// means, not logged in
			echo "<span class='add_to_wishlist' title='login to add to wishlist' onclick='showLoginModal()'>";
			echo "NA";
			echo "</span>";
			
		}

//		echo "<span class='tooltiptext'>add to wishlist</span>";
		echo "</span>";
		
		echo "</div>";
	}
	
	public static function showTopProducts ($lmt) {
		$products = ProductController::getTopProducts($lmt);
		$noofP = count($products);
		echo "<br><h2>Top Products</h2>";
		if ($noofP > 0) {
			for ($i = 0; $i < $noofP; $i++) {
				// product box
				self::product_box($products[$i], false);
			}
		} else {
			echo "no products";
		}
	}
	
	public static function showFilteredProducts ($json) {
		$products = ProductController::getFilteredProducts($json);
		$count = count($products);
		if ($count > 0) {
			echo "<strong style='font-size: larger'>Filtered Products</strong><br>";
			for ($i = 0; $i < $count; $i++) {
				self::product_box($products[$i], true);
			}
		} else {
			echo "no such products found";
		}
	}
	
	public static function showOrderedSearchedProducts ($json) {
		$products = ProductController::getOrderedSearchedProducts($json);
		$noofP = count($products);
		if ($noofP > 0) {
			echo "<strong style='font-size: larger'>Products</strong><br>";
			for ($i = 0; $i < $noofP; $i++) {
				self::product_box($products[$i], true);
			}
		} else {
			echo "no products found<br/>";
		}
	}
	
	public static function showComparisonProduct ($id) {
		$product = ProductController::getProductDetails($id);
		$id = $product['product_id'];
		$name = $product['product_name'];
		$str_length = 25;
		if (strlen($name) > $str_length) {
			$name = substr($name, 0, $str_length) . "...";
		}
		echo "<input type='image' src='res/images/product/default0.jpg' style='height: 100%; float: left'/>";
		echo "<span style='font-size: small'>$name</span><br>";
		echo "<span style='font-size: small'>$id</span>";
	}
	
	public static function showComparedProducts ($ids, $category) {
		
		$details_array = array();
		$ids_count = count($ids);
		$filters = array();
		
		for ($i = 0; $i < $ids_count; $i++) {
			array_push($details_array, ProductController::getProductDetails($ids[$i]));
			if (empty($filters)) {
				$filters = explode(' ', $details_array[$i]['filters']);
			}
		}
		
		echo "<table>";
		
		// image
		echo "<tr>";
		echo "<td></td>";
		for ($i = 0; $i < 4; $i++) {
			echo "<td>";
			if ($i < $ids_count) {
				$id = $ids[$i];
				$tmp_ids = $ids;
				unset($tmp_ids[$i]);
				$string = '"' . implode(" ", $tmp_ids) . '"';
				$cat = '"' . $category . '"';
				echo "<input type='image' src='res/images/extra/cross.png' class='remove_from_compare' onclick='removeThis($id,$string,$cat)'/>";
				echo "<input type='image' class='compare_product_image' src='res/images/product/default0.jpg'>";
			}
			echo "</td>";
		}
		echo "</tr>";
		
		// view product
		self::viewComparedProduct($details_array);
		
		// gap
		echo "<tr><td style='border: none'></td></tr>";
		
		// Name
		self::getCompareRow('Name', $details_array, 'product_name', false);
		
		// brand
		self::getCompareRow('Brand', $details_array, 'brand', false);
		
		// rating
		self::getCompareRow('Rating', $details_array, 'rating', false, 'true');
		
		// price range
		self::getCompareRow('Price Range', $details_array, null, true);
		
		// gap
		echo "<tr><td style='border: none'></td></tr>";
		
		// filters (advanced info)
		for ($i = 0; $i < count($filters); $i++) {
			$name = $filters[$i];
			self::getCompareRow($name, $details_array, $name, false);
		}
		
		// gap
		echo "<tr><td style='border: none'></td></tr>";
		
		// availability score
		self::getCompareRow('availability score', $details_array, 'a_score', false);
		
		// view product
		self::viewComparedProduct($details_array);
		
		echo "</table>";
		
	}
	
	private static function viewComparedProduct ($product) {
		// view product
		echo "<tr>";
		echo "<td style='border: none'></td>";
		for ($i = 0; $i < 4; $i++) {
			
			if (isset($product[$i])) {
				
				$value = $product[$i]['product_id'];
				$link = "productInfo.php?id=$value";
				echo "<td style='text-align: center'><a href='$link'>view this product</a></td>";
//				echo "<td><input type='button' value='view product' onclick='openProductInfo($value)' style='width: 98%;'/></td>";
			}
			
		}
		echo "</tr>";
	}
	
	private static function getCompareRow ($name, $product, $key, $isrange, $rating = null) {
		
		echo "<tr>";
		echo "<td>$name</td>";
		for ($i = 0; $i < 4; $i++) {
			
			if (isset($product[$i])) {
				
				if ($isrange) {
					
					$max = $product[$i]['max_p'];
					$min = $product[$i]['min_p'];
					echo "<td>";
					if ($max == $min) {
						echo "<strong>$max Rs</strong><br>";
					} else {
						echo "<strong>$min Rs - $max Rs</strong><br>";
					}
					echo "</td>";
					
				} else if ($rating != null) {
					
					$value = $product[$i][$key];
					echo "<td>";
					for ($x = 0; $x < $value; $x++) {
						echo "<input type='image' src='res/images/extra/ratingStar.png' style='width: 15px; margin-top: 5px'/> ";
					}
					echo "</td>";
					
				} else {
					
					$value = $product[$i][$key];
					echo "<td>$value</td>";
					
				}
			}
			
		}
		echo "</tr>";
		
	}
	
	/** Search Stuff */
	public static function showSearchDropdownProducts ($search) {
		$products = ProductController::getSearchedProducts($search);
		$noofP = count($products);
		if ($noofP > 0) {
			echo "<strong style='font-size: larger'>Products</strong><br>";
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
			echo "<strong style='font-size: larger'>Products</strong><br>";
			for ($i = 0; $i < $noofP; $i++) {
				self::product_box($products[$i], true);
			}
		} else {
			echo "no products like $search<br/>";
		}
	}
	
	/** Category Stuff */
	public static function showCategoryTopProducts ($category) {
		$products = ProductController::getCategoryTopProducts($category);
		$noofP = count($products);
		if ($noofP > 0) {
			echo "<strong style='font-size: larger'>Top Products for $category</strong><br>";
			for ($i = 0; $i < $noofP; $i++) {
				// product box
				self::product_box($products[$i], false);
			}
		} else {
			echo "no products";
		}
	}
	
	public static function showCategoryNewProducts ($category) {
		$products = ProductController::getCategoryNewProducts($category);
		$noofP = count($products);
		if ($noofP > 0) {
			echo "<strong style='font-size: larger'>New Products for $category</strong><br>";
			for ($i = 0; $i < $noofP; $i++) {
				// product box
				self::product_box($products[$i], false);
			}
		} else {
			echo "no products";
		}
	}
	
	public static function showCategoryRatingFilters ($category) {
		$ratings = ProductController::getCategoryRatingFilters($category);
		$count = count($ratings);
		
		if ($count > 0) {
			$cat = str_replace(' ', '_', $category);
			$table = "c__" . strtolower(trim($cat));
			
			echo "<strong style='font-size: larger'>Ratings</strong><br>";
			echo "<div>";
			for ($j = 0; $j < $count; $j++) {
				$n = $ratings[$j]['rating'];
				$c = $ratings[$j]['c'];
				echo "<input type='checkbox' class='filter_checkbox' name='rating' datatype='$table' value='$n'/>$n ";
				echo "<span style='font-size: small; color: grey'>[$c]</span><br/>";
			}
			echo "</div><br>";
		} else {
			echo ":(<br/>";
		}
	}
	
	/** Shop Stuff */
	public static function showShopProducts ($shop_id) {
		$products = ProductController::getShopProducts($shop_id);
		$count = count($products);
		if ($count > 0) {
			for ($i = 0; $i < $count; $i++) {
				// product box
//                $id = $products[$i]['product_id'];
//                $name = $products[$i]['product_name'];
//                $brand = $products[$i]['brand'];
//
//                echo "<span class='shop_product_link' id='$id'>";
//                echo "<strong>$brand</strong> $name";
//                echo "</span><br>";
				self::product_box($products[$i], false);
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
//                $id = $products[$i]['product_id'];
//                $name = $products[$i]['product_name'];
//                $brand = $products[$i]['brand'];
//
//                echo "<span class='shop_product_link' id='$id'>";
//                echo "<strong>$brand</strong> $name";
//                echo "</span><br>";
				self::product_box($products[$i], false);
			}
		} else {
			echo "no $category" . "s found in this shop";
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