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
            // Use self to access static variables within the static method
            $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
            // Check for connection errors
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }
    
            // Prepare the SQL statement
            $query = $conn->prepare("INSERT INTO tenant (tenFname, tenLname, tenMI, tenHouseNum, tenSt, 
            tenBrgy, tenCityMun, tenProvince, tenContact, tenBdate, tenGender, emContactFname, 
            emContactLname, emContactMI, emContactNum, isRenting) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0');");
    
            // Check if the statement was prepared successfully
            if ($query === false) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
    
            // Bind the parameters
            $query->bind_param('s', $new_tenant['tenFname']);
            $query->bind_param('s', $new_tenant['tenLname']);
            $query->bind_param('s', $new_tenant['tenMI']);
            $query->bind_param('i', (int)$new_tenant['tenHouseNum']);
            $query->bind_param('s', $new_tenant['tenSt']);
            $query->bind_param('s', $new_tenant['tenBrgy']);
            $query->bind_param('s', $new_tenant['tenCityMun']);
            $query->bind_param('s', $new_tenant['tenProvince']);
            $query->bind_param('s', $new_tenant['tenContact']);
            $query->bind_param('s', $new_tenant['tenBdate']);
            $query->bind_param('s', $new_tenant['tenGender']);
            $query->bind_param('s', $new_tenant['emContactFname']);
            $query->bind_param('s', $new_tenant['emContactLname']);
            $query->bind_param('s', $new_tenant['emContactMI']);
            $query->bind_param('s', $new_tenant['emContactNum']);
    
            // Execute the statement
            if (!$query->execute()) {
                throw new Exception("Execute failed: " . $query->error);
            }
    
            // Close the statement and connection
            $query->close();
            $conn->close();
            
            echo '<script>console.log("Tenant added successfully")</script>';
        } catch (Exception $e) {
            // Handle any exceptions
            echo '<script>console.log("Error: "' . $e->getMessage() . '</script>';
        }
    }
    
 
}

?>