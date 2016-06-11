<?php

class CategoryView {

    private $name;
    private $c_details;

    public function __construct ($name) {
        $this->name = $name;
        $this->c_details = CategoryController::getCategoryDetails($name);
    }

    public function show_details () {

        $dept = $this->c_details['department'];
        $filters = $this->c_details['filters'];

        echo "<form>";

        echo "Name: <input type='text' value='$this->name' id='name' class='input'/><br>";
        DepartmentView::showDepartmentSelector($dept, "department", "input");
        echo "Filters: <input type='text' value='$filters' id='filters' class='input' style='width: 100%'/><br>";

//        echo "<input type='button' value='update category' id='submit_update' disabled>";
        echo "Update the category directly in the database<br>";
        echo "<ul>";
        echo "<li><em>Changing Name</em>: change table name of this category i.e. c__table_name</li>";
        echo "<li><em>Changing department</em>: change department directly</li>";
        echo "<li><em>Changing filters</em>: change column names of the category table</li>";
        echo "<li><em>Adding/removing filters</em>: modify the category table</li>";
        echo "</ul><br>";
        echo "</form>";

    }

    public static function showCategorySelector ($dept, $element_id = null, $element_class = null, $category = null, $disable = null) {

        $category_list = CategoryController::getCategories($dept);

        $id = '';
        if (isset($element_id)) {
            $id = $element_id;
        }
        $class = '';
        if (isset($element_class)) {
            $class = $element_class;
        }
        $d = '';
        if (isset($disable)) {
            $d = 'disabled';
        }

        echo "Category: <select id='$id' class='$class' $d>";
        foreach ($category_list as $cat) {
            $c_n = $cat['category_name'];
            $c_n = strtolower($c_n);

            if (!isset($category)) {
                echo "<option value='$c_n'>$c_n</option>";
            } else {
                if ($c_n == $category) {
                    echo "<option value='$c_n' selected='selected'>$c_n</option>";
                } else {
                    echo "<option value='$c_n'>$c_n</option>";
                }
            }
        }
        echo "</select><br>";

    }

}