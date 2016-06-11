<?php

class DepartmentController {

    public static function getAllDepartments(){
        $result = DBHandler::getAll("CALL get_dept_list()");
        return $result;
    }

}