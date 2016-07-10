<?php

namespace seller;

class DBHandler {


    private static $handler;

    private function __construct () {
    }

    public static function execute ($sql, $params = null) {

        try {
            $db_handler = self::getHandler();
            $stmt_handler = $db_handler->prepare($sql);
            $stmt_handler->execute($params);

            $last = $db_handler->lastInsertId();

            if (isset($last)) {
                return $last;
            } else {
                return null;
            }

        } catch (PDOException $e) {
            self::close();
            trigger_error($e->errorInfo);
        }

        return null;

    }

	// for INSERT, UPDATE, DELETE

	private static function getHandler () {

		if (!isset(self::$handler)) {

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

    // get multiple row

	private static function close () {
		self::$handler = null;
	}

	// get single row

    public static function getAll ($sql, $params = null) {

        $result = null;

        try {

            $db_handler = self::getHandler();
            $stmt_handler = $db_handler->prepare($sql);
            $stmt_handler->execute($params);
            $result = $stmt_handler->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            self::close();
            trigger_error($e->getMessage());
        }

        return $result;
    }

	// get value

    public static function getRow ($sql, $params = null) {
        $result = null;

        try {

            $db_handler = self::getHandler();
            $stmt_handler = $db_handler->prepare($sql);
            $stmt_handler->execute($params);
            $result = $stmt_handler->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            self::close();
            trigger_error($e->errorInfo);
        }

        return $result;
    }

    public static function getValue ($sql, $params = null) {
        $result = null;

        try {

            $db_handler = self::getHandler();
            $stmt_handler = $db_handler->prepare($sql);
            $stmt_handler->execute($params);
            $result = $stmt_handler->fetch(PDO::FETCH_NUM);

            $result = $result[0];

        } catch (PDOException $e) {
            self::close();
            trigger_error($e->errorInfo);
        }

        return $result;
    }

}