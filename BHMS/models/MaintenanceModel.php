<?php

require 'dbcreds.php';

class MaintenanceModel extends dbcreds {

    public static function query_rooms(){
        $conn = self::get_connection();
        $query = "SELECT * FROM room";
        $stmt = $conn->query($query);
    
        if ($stmt === false) {
            $conn->close();
            throw new Exception("Error executing query: " . $conn->error);
        }
    
        $results = [];
        while ($row = $stmt->fetch_assoc()) {
            $results[] = $row;
        }
    
        $stmt->close();
        $conn->close();
    
        return $results;
    }

    public static function query_new_maintenance($create_maintenance){
        try {

            $conn = self::get_connection();
            $query = $conn->prepare("INSERT INTO maintenance (
                roomID, 
                maintDate, 
                maintStatus, 
                maintDesc, 
                maintCost
            ) VALUES (?, ?, ?, ?, ?);");
    
            if ($query === false) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
    
            // Bind parameters
            $query->bind_param(
                'ssssd',  
                $create_maintenance['roomID'], 
                $create_maintenance['maintDate'], 
                $create_maintenance['maintStatus'],
                $create_maintenance['maintDesc'], 
                $create_maintenance['maintCost'], 
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

    public static function query_On_going_data() {
        // Get the database connection
        $conn = self::get_connection();

        // The SQL query to select "On-going" maintenance data
        $sql = "SELECT * FROM maintenance WHERE maintStatus = 'On-going'";

        // Execute the query
        $result = $conn->query($sql);

        // Check for errors
        if (!$result) {
            die("Query failed: " . $conn->error);
        }

        // Fetch all rows as an associative array
        $data = $result->fetch_all(MYSQLI_ASSOC);

        // Close the connection
        $conn->close();

        return $data;
    }

    public static function query_completed_data(){
        // Get the database connection
        $conn = self::get_connection();

        // The SQL query to select "On-going" maintenance data
        $sql = "SELECT * FROM maintenance WHERE maintStatus = 'Completed'";

        // Execute the query
        $result = $conn->query($sql);

        // Check for errors
        if (!$result) {
            die("Query failed: " . $conn->error);
        }

        // Fetch all rows as an associative array
        $data = $result->fetch_all(MYSQLI_ASSOC);

        // Close the connection
        $conn->close();

        return $data;
    }

    public static function get_canceled_data(){
        // Get the database connection
        $conn = self::get_connection();

        // The SQL query to select "On-going" maintenance data
        $sql = "SELECT * FROM maintenance WHERE maintStatus = 'Canceled'";

        // Execute the query
        $result = $conn->query($sql);

        // Check for errors
        if (!$result) {
            die("Query failed: " . $conn->error);
        }

        // Fetch all rows as an associative array
        $data = $result->fetch_all(MYSQLI_ASSOC);

        // Close the connection
        $conn->close();

        return $data;
    }
    
    public static function edit_maintenance($edit_maintenance){
        // Extract values from $edit_maintenance array
        $maintID = $edit_maintenance['Edit-maintID'];
        $roomID = $edit_maintenance['Edit-roomID'];
        $maintDate = $edit_maintenance['Edit-maintDate'];
        $maintStatus = $edit_maintenance['Edit-maintStatus'];
        $maintDesc = $edit_maintenance['Edit-maintDesc'];
        $maintCost = $edit_maintenance['Edit-maintCost'];
    
        // Validate and sanitize input if necessary
    
        // Database connection settings

    
        // Create connection
        $conn = self::get_connection();
    
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        // Prepare SQL statement
        $sql = "UPDATE maintenance SET roomID=?, maintDate=?, maintStatus=?, maintDesc=?, maintCost=? WHERE maintID=?";
    
        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssdi", $roomID, $maintDate, $maintStatus, $maintDesc, $maintCost, $maintID);
    
        // Execute the statement
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            return true;
        } else {
            $stmt->close();
            $conn->close();
            return false;
        }
    }

    public static function deleteMaintenanceById($maintenanceID){
        try {
            // Create a connection to the database
            $conn = self::get_connection();
    
            // Check for connection errors
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }
    
            // Prepare the DELETE statement with a parameterized query to prevent SQL injection
            $stmt = $conn->prepare("DELETE FROM maintenance WHERE maintID = ?");
    
            // Bind the parameter to the statement
            $stmt->bind_param("i", $maintenanceID);
    
            // Execute the statement
            if ($stmt->execute()) {
                // Return true if deletion was successful
                return true;
            } else {
                // Return false or handle the failure as needed
                return false;
            }
    
            // Close the statement
            $stmt->close();
    
            // Close the connection
            $conn->close();
    
        } catch (Exception $e) {
            // Log the error to a file or handle it as needed
            error_log("Error deleting tenant: " . $e->getMessage(), 3, '/var/log/php_errors.log');
    
            // Return false to indicate failure
            return false;
        }
    }
 
}

?>