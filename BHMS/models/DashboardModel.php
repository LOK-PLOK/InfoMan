<?php

require 'dbcreds.php';

/**
 * This class contains all the methods/queries that are used in the dashboard page.
 *
 * @method residents_counter
 * @method occupied_bed_and_available_bed
 * @method total_available_rooms
 * @method add_new_tenant
 * @method query_add_new_rent
 * @method query_tenants
 * @method query_rooms
 * @method query_types
 * @method query_room_info
 * @method is_tenant_available
 * @method check_shared_room
 * @class DashboardModel
 * @extends dbcreds
 */
class DashboardModel extends dbcreds {

    /**
     * Gets the total number of residents
     * 
     * @method residents_counter
     * @param none
     * @return int The total number of residents
     */
    public static function residents_counter() {

        $conn = self::get_connection();
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
    }

    /**
     * Gets the total number of occupied beds and available beds
     * 
     * @method occupied_bed_and_available_bed
     * @param none
     * @return array The total number of occupied beds and available beds
     */
    public static function occupied_bed_and_available_bed() {
        
        $conn = self::get_connection();
        // Prepare the SQL statement with a parameter placeholder
        $query = "SELECT 
                    SUM(CASE WHEN isAvailable = 0 THEN capacity ELSE rentCount END) AS occupied_beds, 
                    SUM(CASE WHEN isAvailable = 0 THEN 0 ELSE capacity - rentCount END) AS available_beds 
                FROM room;";
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

    /**
     * Gets the total number of available rooms
     * 
     * @method total_available_rooms
     * @param none
     * @return int The total number of available rooms
     */
    public static function total_available_rooms() {
        
        $conn = self::get_connection();
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
    
    /**
     * Adds a new tenant to the database
     * 
     * @method add_new_tenant
     * @param array $new_tenant The array of tenant details
     * @param array $appliances The array of appliances
     * @return boolean The result of the query
     */
    public static function add_new_tenant($new_tenant,$appliances) {
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

        $tenFname = ucwords(strtolower($new_tenant['tenFname']));
        $tenLname = ucwords(strtolower($new_tenant['tenLname']));
        $tenMI = strtoupper($new_tenant['tenMI']);

        $query->bind_param(
            'sssssssssssssss',
            $tenFname, $tenLname, $tenMI,
            $new_tenant['tenHouseNum'], $new_tenant['tenSt'], $new_tenant['tenBrgy'],
            $new_tenant['tenCityMun'], $new_tenant['tenProvince'], $new_tenant['tenContact'],
            $new_tenant['tenBdate'], $new_tenant['tenGender'], $new_tenant['emContactFname'],
            $new_tenant['emContactLname'], $new_tenant['emContactMI'], $new_tenant['emContactNum']
        );
    
        if ($query->execute()) {
            $tenantID = $conn->insert_id;
            $query->close();
    
            foreach($appliances as $appliance) {
                $appInfo = $appliance['appInfo'];
                $appQuery = $conn->prepare("INSERT INTO appliance (tenID, appInfo, appRate) VALUES (?, ?, ?)");
                
                if ($appQuery === false) {
                    throw new Exception("Prepare failed for appliance: " . $conn->error);
                }
    
                $appRate = 100.00; // assuming a fixed rate, adjust if needed
                $appQuery->bind_param('isd', $tenantID, $appInfo, $appRate);
    
                if (!$appQuery->execute()) {
                    $appQuery->close();
                    $conn->close();
                    throw new Exception("Execution failed for appliance: " . $appQuery->error);
                }
    
                $appQuery->close();
            }
    
            $conn->close();
            return true;
        } else {
            $query->close();
            $conn->close();
            throw new Exception("Execution failed: " . $query->error);
            return false;
        }
    } 
    
    /**
     * Adds a new rent to the database
     * 
     * @method query_add_new_rent
     * @param array $create_rent The array of rent details
     * @return boolean The result of the query
     */
    public static function query_add_new_rent($create_rent) {
        try {

            $conn = self::get_connection();
            $query = $conn->prepare("INSERT INTO occupancy (
                tenID, 
                roomID, 
                occDateStart, 
                occDateEnd, 
                occTypeID, 
                occupancyRate
            ) VALUES (?, ?, ?, ?, ?, ?);");
    
            if ($query === false) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
    
            // Bind parameters
            $query->bind_param(
                'isssid',  
                $create_rent['tenID'], 
                $create_rent['roomID'], 
                $create_rent['occDateStart'],
                $create_rent['occDateEnd'], 
                $create_rent['occTypeID'], 
                $create_rent['occupancyRate']
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
     * Gets all the tenants from the database
     * 
     * @method query_tenants
     * @param none
     * @return array The array of tenants
     */
    public static function query_tenants(){
        
        $conn = self::get_connection();
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

    /**
     * Gets all the rooms from the database
     * 
     * @method query_rooms
     * @param none
     * @return array The array of rooms
     */
    public static function query_rooms() {
        
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
     * Gets all the occupancy types from the database
     * 
     * @method query_types
     * @param none
     * @return array The array of occupancy types
     */
    public static function query_types() {
        
        $conn = self::get_connection();
        $query = "SELECT * FROM occupancy_type";
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
     * Gets the room information
     * 
     * @method query_room_info
     * @param string $roomID The room ID
     * @return array The room information
     */
    public static function query_room_info($roomID){
        $conn = self::get_connection();
        $query = $conn->prepare("SELECT * FROM room WHERE roomID = ?");
        $query->bind_param('s', $roomID);
        $query->execute();
        $result = $query->get_result()->fetch_assoc();
        $query->close();
        $conn->close();
        return $result;
    }

    /**
     * Checks if a tenant is available
     * 
     * @method is_tenant_available
     * @param int $tenID The tenant ID
     * @param string $startDate The start date
     * @param string $endDate The end date
     * @return boolean The availability of the tenant
     */
    public static function is_tenant_available($tenID, $startDate, $endDate){

        $conn = self::get_connection();
        $query = $conn->prepare("SELECT COUNT(*) AS no_of_conflicts 
                                    FROM occupancy 
                                    WHERE tenID = ? 
                                    AND (
                                        (occDateStart <= ? AND occDateEnd >= ?) OR
                                        (occDateEnd >= ? AND occDateStart <= ?)
                                    );");
        $query->bind_param(
            'issss', 
            $tenID, 
            $startDate, $endDate, 
            $startDate, $endDate
        );
        $query->execute();
        $result = $query->get_result()->fetch_assoc();
        $query->close();
        $conn->close();
        // Return true if no_of_conflicts is 0, meaning tenant is available
        return $result['no_of_conflicts'] == 0;
    }

    /**
     * Checks if a room is shared
     * 
     * @method check_shared_room
     * @param array $check_rent The array of rent details
     * @return boolean The result of the query
     */
    public static function check_shared_room($check_rent) {
        $conn = self::get_connection();
        $query = $conn->prepare("SELECT COUNT(*) FROM occupancy WHERE roomID = ?
                                AND tenID = ? AND occDateStart = ? AND occDateEnd = ?");

        $query->bind_param('siss', $check_rent['roomID'], $check_rent['shareTenID'], $check_rent['occDateStart'], $check_rent['occDateEnd']);
        
        $query->execute();
        
        $result = $query->get_result()->fetch_assoc();
        
        $query->close();
        
        $conn->close();
        return $result['COUNT(*)'] > 0;
    }

    public static function query_create_billings($new_billing){
        $conn = self::get_connection();
        
        // Sanitize the inputs
        $tenID = $new_billing['tenID'];
        $billTotal = $new_billing['billTotal'];
        $billDateIssued = date('Y-m-d');

        $endDate = $new_billing['endDate'];
        $billDueDate = date('Y-m-d', strtotime($endDate . ' +7 days'));

        $query = "INSERT INTO `billing` (`billRefNo`, `tenID`, `billTotal`, `billDateIssued`, `billDueDate`, `isPaid`) 
                  VALUES (NULL, ?, ?, ?, ?, 0);";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param('idss', $tenID, $billTotal, $billDateIssued, $billDueDate);
        
        if ($stmt->execute() === FALSE) {
            die("Error executing query: " . $stmt->error);
        }

        $stmt->close();
        $conn->close();
    
        return true;
    }

    public static function query_count_appliances($tenID) {
        $conn = self::get_connection();
        $query = $conn->prepare("SELECT COUNT(*) AS count FROM appliance WHERE tenID = ?");
        $query->bind_param('i', $tenID);
        $query->execute();
        $result = $query->get_result()->fetch_assoc();
        $query->close();
        $conn->close();
        return $result['count'];    
    }

    public static function fetchApplianceRate(){
        try {
            // Create a connection to the database
            $conn = self::get_connection();

            // Prepare the SQL query to get the default value of the appRate column
            $stmt = $conn->prepare("
                SELECT COLUMN_DEFAULT 
                FROM INFORMATION_SCHEMA.COLUMNS 
                WHERE TABLE_NAME = 'appliance' 
                AND COLUMN_NAME = 'appRate'
            ");

            // Execute the statement
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();

            // Fetch the row as an associative array
            $row = $result->fetch_assoc();
            $default_value = $row['COLUMN_DEFAULT'];

            // Free the result
            $result->free();

            // Close the statement
            $stmt->close();

            // Close the connection
            $conn->close();

            // Return the default value
            return $default_value;
        } catch (Exception $e) {
            // Log the error to a file or handle it as needed
            error_log("Error getting appliance rate default value: " . $e->getMessage(), 3, '/var/log/php_errors.log');

            // Return null to indicate failure
            return null;
        }
    }

}

?>