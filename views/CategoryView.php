<?php

class CategoryView {

	public static function show ($dept) {

		$category_array = CategoryController::getCategories($dept);

		for ($i = 0; $i < count($category_array); $i++) {

			$cat_name = $category_array[$i]['category_name'];

			echo "<div class='category_link' datatype='$cat_name'>";
			echo "$cat_name";
			echo " <button class='view_all' id='$cat_name'>view all</button>";
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
					echo "<input type='checkbox' class='filter_checkbox' name='$name' datatype='$table' value='$n'/>$n ";
					echo "<span style='font-size: small; color: grey'>[$c]</span><br/>";
				}
				echo "</div><br>";

			}
		} else {
			echo ":(";
		}

	}

}