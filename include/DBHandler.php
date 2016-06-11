<?php

class DBHandler{


    private static $handler;

    private function __construct () {}

    private static function getHandler(){

        if(!isset(self::$handler)){

            try {

                self::$handler = new PDO(PDO_DSN, USER, PASS);
                // configure PDO to throw exceptions
                self::$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            } catch (PDOException $e) {
                self::close();
                trigger_error($e->errorInfo);
            }

        }

        return self::$handler;
    }

    // for INSERT, UPDATE, DELETE
    public static function execute($sql, $params = null){

        try {
            $db_handler = self::getHandler();
            $stmt_handler = $db_handler->prepare($sql);
            $stmt_handler->execute($params);

        } catch (PDOException $e) {
            self::close();
            trigger_error($e->errorInfo);
        }

    }

    // get multiple row
    public static function getAll ($sql, $params = null) {

        $result = null;

        try{

            $db_handler = self::getHandler();
            $stmt_handler = $db_handler->prepare($sql);
            $stmt_handler->execute($params);
            $result = $stmt_handler->fetchAll(PDO::FETCH_ASSOC);

        } catch(PDOException $e){
            self::close();
            trigger_error($e->getMessage());
        }

        return $result;
    }

    // get single row
    public static function getRow ($sql, $params = null) {
        $result = null;

        try{

            $db_handler = self::getHandler();
            $stmt_handler = $db_handler->prepare($sql);
            $stmt_handler->execute($params);
            $result = $stmt_handler->fetch(PDO::FETCH_ASSOC);

        } catch(PDOException $e){
            self::close();
            trigger_error($e->errorInfo);
        }

        return $result;
    }

    // get value
    public static function getValue ($sql, $params = null) {
        $result = null;

        try{

            $db_handler = self::getHandler();
            $stmt_handler = $db_handler->prepare($sql);
            $stmt_handler->execute($params);
            $result = $stmt_handler->fetch(PDO::FETCH_NUM);

            $result = $result[0];

        } catch(PDOException $e){
            self::close();
            trigger_error($e->errorInfo);
        }

        return $result;
    }

    private static function close(){
        self::$handler = null;
    }

}