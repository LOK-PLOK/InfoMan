<?php

require 'dbcreds.php';

class DashboardModel extends dbcreds {

    public static function residents_counter() {
        // Use self to access static variables within the static method
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
        // Check for connection errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        // Prepare the SQL statement with a parameter placeholder
        $query = "SELECT COUNT(*) AS count FROM tenant WHERE isRenting = 1";
        $stmt = $conn->query($query);
    
        if ($stmt === false) {
            die("Error executing query: " . $conn->error);
        }
    
        // Fetch the result
        $row = $stmt->fetch_assoc();
        $result = $row['count'];
    
        // Close the statement and connection
        $stmt->close();
        $conn->close();
    
        // Return the result
        return $result;

        echo '<script>console.log('.json_encode("test").')</script>';
        
    }

    public static function occupied_bed_and_available_bed() {
        // Use self to access static variables within the static method
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
        // Check for connection errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        // Prepare the SQL statement with a parameter placeholder
        $query = "SELECT SUM(rentCount) AS occupied_beds, (SUM(capacity) - SUM(rentCount)) AS available_beds FROM room;";
        $stmt = $conn->query($query);
    
        if ($stmt === false) {
            die("Error executing query: " . $conn->error);
        }
    
        // Fetch the result
        $result = $stmt->fetch_assoc();
    
        // Close the statement and connection
        $stmt->close();
        $conn->close();
    
        // Return the result
        return $result;
        
    }

    public static function total_available_rooms() {
        // Use self to access static variables within the static method
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
        // Check for connection errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        // Prepare the SQL statement with a parameter placeholder
        $query = "SELECT COUNT(*) AS available_rooms FROM room WHERE rentCount = 0;";
        $stmt = $conn->query($query);
    
        if ($stmt === false) {
            die("Error executing query: " . $conn->error);
        }
    
        // Fetch the result
        $result = $stmt->fetch_assoc();
    
        // Close the statement and connection
        $stmt->close();
        $conn->close();
    
        // Return the result
        return $result['available_rooms'];
        
    }
    
    public static function add_new_tenant($new_tenant) {
        try {
            $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }
    
            $query = $conn->prepare("INSERT INTO tenant (
                tenFname, 
                tenLname, 
                tenMI, 
                tenHouseNum, 
                tenSt, 
                tenBrgy, 
                tenCityMun, 
                tenProvince, 
                tenContact, 
                tenBdate, 
                tenGender, 
                emContactFname, 
                emContactLname, 
                emContactMI, 
                emContactNum, 
                isRenting
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0);");
    
            if ($query === false) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
    
            $query->bind_param(
                'sssssssssssssss',
                $new_tenant['tenFname'], $new_tenant['tenLname'], $new_tenant['tenMI'],
                $new_tenant['tenHouseNum'], $new_tenant['tenSt'], $new_tenant['tenBrgy'],
                $new_tenant['tenCityMun'], $new_tenant['tenProvince'], $new_tenant['tenContact'],
                $new_tenant['tenBdate'], $new_tenant['tenGender'], $new_tenant['emContactFname'],
                $new_tenant['emContactLname'], $new_tenant['emContactMI'], $new_tenant['emContactNum']
            );
    
            if (!$query->execute()) {
                throw new Exception("Execute failed: " . $query->error);
            }
    
            $query->close();
            $conn->close();
    
            return true;
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage(), 3, '/var/log/php_errors.log');
            return false;
        }
    }    
    
 
}

?>