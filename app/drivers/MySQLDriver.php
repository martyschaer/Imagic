<?php

require_once "app/utilities/ConstantsUtility.php";

class dbDriverMySQL
{
    private static $conn;
    private static $ROOT_PATH = "../../";
    private static $isInstantiated = false;

    public static function create(){
        self::$conn = new PDO('mysql:host=localhost;dbname=imagic', constants::DB_USER, constants::DB_PASS);
        self::$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        if(self::testConn()){
            self::$isInstantiated = true;
            return true;
        }else{
            self::destroy();
            return false;
        }
    }

    /** This function will prep the query, execute it and return an assoc-array with the results.
     *  Write statements like so: "INSERT INTO TableName (col1, col2, col3) VALUES (:col1, :col2, :col3)"
     *  Pass the parameters like so: array(":col1" => "val1", ":col2" => "val2", ":col3" => "val3");
     * @param $query
     * @param $params
     */
    public static function query($query, $params){
        if(!self::$isInstantiated) {
            self::create();
        }
        try{
            $statement = self::$conn->prepare($query);
            foreach($params as $col => $value){
                $statement->bindValue($col, $value);
            }
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $result = array();
            while($row = $statement->fetch()){
                $result[] = $row;
            }
            return $result;
        }catch(PDOException $e){
            error_log($e->getMessage());
        }
        return [];
    }

    private static function testConn(){
        $statement = self::$conn->query('SELECT * FROM test');
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if($row['test'] == 'ok'){
            return true;
        }
        return false;
    }

    public static function destroy(){
        self::$isInstantiated = false;
        self::$conn = null;
    }
}