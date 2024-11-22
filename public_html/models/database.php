<?php

namespace Bosbar\Models;

use Bosbar\Model;
use PDO;
use PDOException;

class Database extends Model
{
    private static $db;

    public static function init($data = null) {
        if ($data) {
            $host = $data['host'];
            $dbname = $data['dbname'];
            $username = $data['username'];
            $password = $data['password'];
            $port = $data['port'];
        } else {
            $host = DB_HOST;
            $dbname = DB_NAME;
            $username = DB_USER;
            $password = DB_PASSWORD;
            $port = DB_PORT;
        }
        if (!self::$db) {
            try {
                $dsn = 'mysql:host=' . $host . ';port=' . $port . ';dbname=' . $dbname . ';charset=utf8';
                self::$db = new PDO($dsn, $username, $password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                error_log($e->getMessage());
                die("A database error was encountered -> " . $e->getMessage());
            }
        }
        return self::$db;
    }
}