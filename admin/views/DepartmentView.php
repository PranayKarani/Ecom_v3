<?php


class DepartmentView {

    public static function showDepartmentSelector ($name = null, $id = null, $class = null, $d = null) {

        $list = DepartmentController::getAllDepartments();

        if ($d == true) {
            echo "Department: <select id='$id' class='$class' disabled>";
        } else {
            echo "Department: <select id='$id' class='$class' >";
        }
        foreach ($list as $dept) {
            $d_n = $dept['department_name'];
//            $d_n = $d_n;

            if (!isset($name)) {
                echo "<option value='$d_n'>$d_n</option>";
            } else {
                if ($d_n == $name) {
                    echo "<option value='$d_n' selected='selected'>$d_n</option>";
                } else {
                    echo "<option value='$d_n'>$d_n</option>";
                }
            }
        }
        echo "</select><br>";

    }

}