<?php

require 'dbcreds.php';

class BillingsModel extends dbcreds {

    public static function query_tenants(){
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT * FROM tenant";
        $stmt = $conn->query($query);

        if ($stmt === false) {
            die("Error executing query: " . $conn->error);
        }
    
        $results = [];
        while ($row = $stmt->fetch_assoc()) {
            $results[] = $row;
        }
    
        $stmt->close();
        $conn->close();
    
        return $results;
    }

    public static function query_paid_billings() {
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $query = "SELECT b.*, t.tenFname AS tenant_first_name, t.tenLname AS tenant_last_name
                  FROM billing b
                  INNER JOIN tenant t ON b.tenID = t.tenID
                  WHERE b.isPaid = 1";
        
        $stmt = $conn->query($query);
    
        if ($stmt === false) {
            die("Error executing query: " . $conn->error);
        }
    
        $results = [];
        while ($row = $stmt->fetch_assoc()) {
            $results[] = $row;
        }
    
        $stmt->close();
        $conn->close();
    
        return $results;
    }

    public static function query_unpaid_billings() {
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $query = "SELECT b.*, t.tenFname AS tenant_first_name, t.tenLname AS tenant_last_name
                  FROM billing b
                  INNER JOIN tenant t ON b.tenID = t.tenID
                  WHERE b.isPaid = 0";
        
        $stmt = $conn->query($query);
    
        if ($stmt === false) {
            die("Error executing query: " . $conn->error);
        }
    
        $results = [];
        while ($row = $stmt->fetch_assoc()) {
            $results[] = $row;
        }
    
        $stmt->close();
        $conn->close();
    
        return $results;
    } 
}

?>