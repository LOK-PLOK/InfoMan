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

            echo '<script>console.log(' . json_encode($create_maintenance) . ');</script>';

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
 
}

?>