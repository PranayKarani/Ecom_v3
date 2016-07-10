<?php

use admin\DBHandler;

class ADepartmentController {

    public static function getAllDepartments () {
        $sql = "CALL get_dept_list()";

        return DBHandler::getAll($sql);
    }

}