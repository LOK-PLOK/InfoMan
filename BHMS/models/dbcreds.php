<?php

class dbcreds {
    
    protected static $servername = "localhost";
    protected static $username = "root";
    protected static $password = "";
    protected static $dbname = "Munoz_BHMS";

    protected static function get_connection() {
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}

?>
