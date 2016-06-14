<?php

class DepartmentController {

    /**
     * Get all departments
     * @return array|null
     */
    public static function getAllDepartments(){
        $result = DBHandler::getAll("CALL get_dept_list()");
        return $result;
    }

}