<?php

namespace connection;

require_once 'credentials.php';

use PDO;

/**
 * Class connection
 * Create the instance DB to make queries
 *
 * @package connection
 */
class connection
{

    /**
     * Variable with the db
     */
    private static $_db = null;

    /**
     * PDO Variable
     */
    private static $_pdo;

    /**
     * connection constructor.
     */

    final private function __construct()
    {
        try {
            //
            self::getDB();
        } catch (PDOException $e) {
            //
        }


    }

    /**
     * Connection descructor
     */

    function _destructor()
    {
        self::$_pdo = null;
    }

    /**
     * Returns the instance
     * @return connection|null
     */
    public static function getInstance()
    {
        if (self::$_db === null) {
            self::$_db = new self();
        }
        return self::$_db;
    }

    /**
     * Create a PDO connection
     * @return PDO Object
     */
    public function getDB()
    {
        if (self::$_pdo == null) {
            self::$_pdo = new PDO(
                'mysql:dbname=' . DB .
                ';host=' . HOST . ";", USER, PASSWORD,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
            self::$_pdo->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION);
        }

        return self::$_pdo;
    }




}