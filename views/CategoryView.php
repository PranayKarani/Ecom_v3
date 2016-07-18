<?php

class CategoryView {

	public static function show ($dept) {

		$category_array = CategoryController::getCategories($dept);

		for ($i = 0; $i < count($category_array); $i++) {

			$cat_name = $category_array[$i]['category_name'];
			
			echo "<div class='category_link'>";
			echo "<div class='category_link_name' data-name='$cat_name'>";
			echo "$cat_name";
			echo "</div>";
			echo "<div class='category_link_viewall'>";
			echo " <a href='category.php?category=$cat_name'>view all</a>";
			echo "</div>";
			echo "</div>";

		}
	}

	public static function showSearchedCategories ($search_text) {

		$cats = CategoryController::getSearchedCategories($search_text);

		$noofP = count($cats);

		if ($noofP > 0) {
			echo "<strong>Categories</strong><br>";
			for ($i = 0; $i < $noofP; $i++) {

				$name = $cats[$i]['category_name'];

				echo "<div class='search_category_link' id='$name'>";
				echo $name;
				echo "</div>";
			}
		}

	}

	public static function showFilters ($category) {
		
		// price range filter
		$range = CategoryController::getPriceFilterRange($category);
		$min_price = $range['min'];
		$max_price = $range['max'];
		echo "<div>";
		echo "<strong style='font-size: larger'>price range</strong><br>";
		echo "<input type='number' value='$min_price' id='min_price' min='$min_price' max='$max_price' data-price='$min_price'/> Rs to ";
		echo "<input type='number' value='$max_price' id='max_price' min='$min_price' max='$max_price' data-price='$max_price'/> Rs<br/>";
		echo "<input type='button' value='go' id='price_range_filter_go' onclick='loadProducts()'/>";
		echo "<input type='button' value='reset' id='price_range_filter_reset' onclick='resetFilterPrice()'/>";
		echo "</div><br/>";
		
		// category filters
		$filters = CategoryController::getFilters($category);
		$filters = $filters == "" ? null : explode(' ', $filters);
		$filter_count = count($filters);
		
		if ($filter_count != null) {
			$cat = str_replace(' ', '_', $category);
			$table = "c__" . strtolower(trim($cat));
			
			for ($i = 0; $i < $filter_count; $i++) {
				$name = $filters[$i];

				$result = CategoryController::getFilterData($table, $name);
				$count = count($result);

				echo "<div>";
				echo "<strong style='font-size: larger'>$name</strong><br>";
				for ($j = 0; $j < $count; $j++) {
					$n = $result[$j][$name];
					$c = $result[$j]['c'];
					echo "<input type='checkbox' class='filter_checkbox' name='$name' data-table='$table' value='$n' data-group='$name'/>$n ";
					echo "<span style='font-size: small; color: grey'>[$c]</span><br/>";
				}
				echo "</div><br/>";

			}
		} else {
			echo ":(";
		}

	}
	
	/** For Header category stuff */
	
	public static function showInHeader ($dept_name) {
		
		$category_array = CategoryController::getCategories($dept_name);
		
		for ($i = 0; $i < count($category_array); $i++) {
			
			$cat_name = $category_array[$i]['category_name'];
			
			echo "<div class='header_category_link'>";
			echo "<div class='header_category_link_name' data-name='$cat_name'>";
			echo "$cat_name";
			echo "</div>";
			echo "<div class='header_category_link_viewall'>";
			echo " <a href='category.php?category=$cat_name'>view all</a>";
			echo "</div>";
			echo "</div>";
			
		}
		
	}
	
}