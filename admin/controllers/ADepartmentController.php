<?php

/**
 * Created by PhpStorm.
 * User: PranayKarani
 * Date: 29/05/2016
 * Time: 11:13 AM
 */
class ADepartmentController {

    public static function getAllDepartments () {
        $sql = "CALL get_dept_list()";

        return DBHandler::getAll($sql);
    }

}