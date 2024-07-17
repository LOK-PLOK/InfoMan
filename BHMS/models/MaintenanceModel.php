<?php

require 'dbcreds.php';

/**
 * This class contains all the controllers/methods that are used in the maintenance page and MaintenanceViews File.
 * 
 * @method query_rooms
 * @method query_new_maintenance
 * @method query_On_going_data
 * @method query_completed_data
 * @method query_cancelled_data
 * @method edit_maintenance
 * @method deleteMaintenanceById
 * @method query_On_going_data_RoomCode 
 * @method query_On_going_data_Cost
 * @method query_On_going_data_Date
 * @method query_completed_data_RoomCode
 * @method query_completed_data_Cost
 * @method query_completed_data_Date
 * @method query_cancelled_data_RoomCode
 * @method query_cancelled_data_Cost
 * @method query_cancelled_data_Date
 * @method query_On_going_data_search
 * @method query_completed_data_search
 * @method query_cancelled_data_search
 * @class MaintenanceModel
 * @extends dbcreds
 */

class MaintenanceModel extends dbcreds {

    /**
     * Gets the room data
     * 
     * @method query_rooms
     * @param none
     * @return array
     */
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

    /**
     * Adds a new maintenance to the database
     * 
     * @method query_new_maintenance
     * @param $create_maintenance
     * @return boolean
     */
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

    /**
     * Gets the ongoing maintenance data
     * 
     * @method query_On_going_data
     * @param none
     * @return array
     */
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

    /**
     * Gets the completed maintenance data
     * 
     * @method query_completed_data
     * @param none
     * @return array
     */
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

    /**
     * Gets the cancelled maintenance data
     * 
     * @method query_cancelled_data
     * @param none
     * @return array
     */
    public static function query_cancelled_data(){
        // Get the database connection
        $conn = self::get_connection();

        // The SQL query to select "On-going" maintenance data
        $sql = "SELECT * FROM maintenance WHERE maintStatus = 'Cancelled'";

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
    
    /**
     * Edits a maintenance record in the database
     * 
     * @method edit_maintenance
     * @param $edit_maintenance
     * @return boolean
     */
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

    /**
     * Deletes a maintenance record from the database
     * 
     * @method deleteMaintenanceById
     * @param $maintenanceID
     * @return boolean
     */
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

    /**
     * Fethces the data from the database where the maintStatus is "On-going" and orders it by roomID
     * 
     * @method query_On_going_data_RoomCode
     * @param none
     * @return array
     */
    public static function query_On_going_data_RoomCode(){
        // Get the database connection
        $conn = self::get_connection();

        // The SQL query to select "On-going" maintenance data
        $sql = "SELECT * FROM maintenance WHERE maintStatus = 'On-going' ORDER BY roomID ASC";

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
    
    /**
     * Fethces the data from the database where the maintStatus is "On-going" and orders it by maintCost
     * 
     * @method query_On_going_data_Cost
     * @param none
     * @return array
     */
    public static function query_On_going_data_Cost(){
        // Get the database connection
        $conn = self::get_connection();

        // The SQL query to select "On-going" maintenance data
        $sql = "SELECT * FROM maintenance WHERE maintStatus = 'On-going' ORDER BY maintCost DESC";

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

    /**
     * Fethces the data from the database where the maintStatus is "On-going" and orders it by maintDate
     * 
     * @method query_On_going_data_Date
     * @param none
     * @return array
     */
    public static function query_On_going_data_Date(){
        // Get the database connection
        $conn = self::get_connection();

        // The SQL query to select "On-going" maintenance data
        $sql = "SELECT * FROM maintenance WHERE maintStatus = 'On-going' ORDER BY maintDate DESC";

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

    /**
     * Fethces the data from the database where the maintStatus is "Completed" and orders it by roomID
     * 
     * @method query_completed_data_RoomCode
     * @param none
     * @return array
     */
    public static function query_completed_data_RoomCode(){
        // Get the database connection
        $conn = self::get_connection();

        // The SQL query to select "On-going" maintenance data
        $sql = "SELECT * FROM maintenance WHERE maintStatus = 'Completed' ORDER BY roomID ASC";

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

    /**
     * Fethces the data from the database where the maintStatus is "Completed" and orders it by maintCost
     * 
     * @method query_completed_data_Cost
     * @param none
     * @return array
     */
    public static function query_completed_data_Cost(){
        // Get the database connection
        $conn = self::get_connection();

        // The SQL query to select "On-going" maintenance data
        $sql = "SELECT * FROM maintenance WHERE maintStatus = 'Completed' ORDER BY maintCost DESC";

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

    /**
     * Fethces the data from the database where the maintStatus is "Completed" and orders it by maintDate
     * 
     * @method query_completed_data_Date
     * @param none
     * @return array
     */
    public static function query_completed_data_Date(){
        // Get the database connection
        $conn = self::get_connection();

        // The SQL query to select "On-going" maintenance data
        $sql = "SELECT * FROM maintenance WHERE maintStatus = 'Completed' ORDER BY maintDate DESC";

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

    /**
     * Fethces the data from the database where the maintStatus is "Cancelled" and orders it by roomID
     * 
     * @method query_cancelled_data_RoomCode
     * @param none
     * @return array
     */
    public static function query_cancelled_data_RoomCode(){
        // Get the database connection
        $conn = self::get_connection();

        // The SQL query to select "On-going" maintenance data
        $sql = "SELECT * FROM maintenance WHERE maintStatus = 'Cancelled' ORDER BY roomID ASC";

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

    /**
     * Fethces the data from the database where the maintStatus is "Cancelled" and orders it by maintCost
     * 
     * @method query_cancelled_data_Cost
     * @param none
     * @return array
     */
    public static function query_cancelled_data_Cost(){
        // Get the database connection
        $conn = self::get_connection();

        // The SQL query to select "On-going" maintenance data
        $sql = "SELECT * FROM maintenance WHERE maintStatus = 'Cancelled' ORDER BY maintCost DESC";

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

    /**
     * Fethces the data from the database where the maintStatus is "Cancelled" and orders it by maintDate
     * 
     * @method query_cancelled_data_Date
     * @param none
     * @return array
     */
    public static function query_cancelled_data_Date(){
        // Get the database connection
        $conn = self::get_connection();

        // The SQL query to select "On-going" maintenance data
        $sql = "SELECT * FROM maintenance WHERE maintStatus = 'Cancelled' ORDER BY maintDate DESC";

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

    /**
     * Fethces the data from the database where the maintStatus is "On-going" and orders it by roomID
     * 
     * @method query_On_going_data_search
     * @param none
     * @return array
     */
    public static function query_On_going_data_search($search){
        // Get the database connection
        $conn = self::get_connection();

        // The SQL query to select "On-going" maintenance data
        $sql = "SELECT * FROM maintenance WHERE maintStatus = 'On-going' AND roomID LIKE '%$search%' OR maintDesc LIKE '%$search%'";

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

    /**
     * Fethces the data from the database where the maintStatus is "Completed" and orders it by roomID
     * 
     * @method query_completed_data_search
     * @param none
     * @return array
     */
    public static function query_completed_data_search($search){
        // Get the database connection
        $conn = self::get_connection();

        // The SQL query to select "On-going" maintenance data
        $sql = "SELECT * FROM maintenance WHERE maintStatus = 'Completed' AND roomID LIKE '%$search%'";

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

    /**
     * Fethces the data from the database where the maintStatus is "Cancelled" and orders it by roomID
     * 
     * @method query_cancelled_data_search
     * @param none
     * @return array
     */
    public static function query_cancelled_data_search($search){
        // Get the database connection
        $conn = self::get_connection();

        // The SQL query to select "On-going" maintenance data
        $sql = "SELECT * FROM maintenance WHERE maintStatus = 'Cancelled' AND roomID LIKE '%$search%'";

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