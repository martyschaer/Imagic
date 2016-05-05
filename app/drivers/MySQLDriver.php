<?php
namespace Drivers;

use \Utilities\ConstantsUtility;
use \PDO;
use \PDOException;

class MySQLDriver
{
    //keeps the connection alive, as not to re-instantiate it every time a query is issued
    private static $conn;
    private static $isInstantiated = false;

    /**
     * instantiates a new database connection.
     * this does not need to happen explicitly
     * it's implicitly called when a query is executed
     * @return bool
     */
    public static function create()
    {
        self::$conn = new PDO('mysql:host=localhost;dbname=imagic', ConstantsUtility::DB_USER, ConstantsUtility::DB_PASS);
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if (self::testConn()) {
            self::$isInstantiated = true;
            return true;
        } else {
            self::destroy();
            return false;
        }
    }

    /**
     * This function will prep the query, execute it and return an assoc-array with the results.
     *  Write statements like so: "INSERT INTO TableName (col1, col2, col3) VALUES (:col1, :col2, :col3)"
     * Pass the parameters like so: array(":col1" => "val1", ":col2" => "val2", ":col3" => "val3");
     * @param $query
     * @param $params
     */
    public static function query($query, $params)
    {
        if (!self::$isInstantiated) {
            self::create();
        }
        try {
            $statement = self::$conn->prepare($query);
            foreach ($params as $col => $value) {
                $statement->bindValue($col, $value);
            }
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $result = array();
            while ($row = $statement->fetch()) {
                $result[] = $row;
            }
            return $result;
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
        return [];
    }

    /**
     * function to test the connection
     * it selects a value from the test table
     * and returns a boolean if the expected value is returned.
     * if not, the connection is destroyed and an exception is thrown.
     * @return bool
     */
    private static function testConn()
    {
        $statement = self::$conn->query('SELECT * FROM test');
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if ($row['test'] == 'ok') {
            return true;
        }
        return false;
    }

    /**
     * destroys the connection.
     */
    public static function destroy()
    {
        self::$isInstantiated = false;
        self::$conn = null;
    }
}