<?php

/**
 * This class contains all the database credentials that are used in the application.
 * 
 * @method get_connection
 * @class dbcreds
 */
class dbcreds {
    
    /**
     * @var string $servername The server name.
     */
    protected static $servername = "localhost";
    /**
     * @var string $username The username.
     */
    protected static $username = "root";
    /**
     * @var string $password The password.
     */
    protected static $password = "";
    /**
     * @var string $dbname The database name.
     */
    protected static $dbname = "Munoz_BHMS";


    /**
     * This method is used to get the connection to the database.
     * 
     * @method get_connection
     * @return mysqli $conn - The connection to the database.
     */
    protected static function get_connection() {
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}

?>
