<?php

require __DIR__ . '/../config.php';

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
    protected static $servername;
    /**
     * @var string $port The port number.
     */
    protected static $port;
    /**
     * @var string $username The username.
     */
    protected static $username;
    /**
     * @var string $password The password.
     */
    protected static $password;
    /**
     * @var string $dbname The database name.
     */
    protected static $dbname;


    /**
     * This method is used to get the connection to the database.
     * 
     * @method get_connection
     * @return mysqli $conn - The connection to the database.
     */
    protected static function get_connection() {
        self::$servername = $_ENV['DB_SERVER'];
        self::$port = $_ENV['DB_PORT'];
        self::$username = $_ENV['DB_USERNAME'];
        self::$password = $_ENV['DB_PASSWORD'];
        self::$dbname = $_ENV['DB_NAME'];
        
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname, self::$port);
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}

?>
