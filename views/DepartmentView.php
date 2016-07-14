<?php

class DepartmentView {


    public static function show () {

        $dept_array = DepartmentController::getAllDepartments();

        for ($i = 0; $i < count($dept_array); $i++) {

            $dept_name = $dept_array[$i]['department_name'];

            echo "<div class='dept_link'>";
            echo $dept_name;
            echo "</div>";

        }

    }
	
	public static function showInHeader () {
		
		$dept_array = DepartmentController::getAllDepartments();
		
		for ($i = 0; $i < count($dept_array); $i++) {
			
			$dept_name = $dept_array[$i]['department_name'];
			
			echo "<div class='header_dept_link' data-name='$dept_name'>";
			echo $dept_name;
			echo "</div>";
			
		}
		
	}


}