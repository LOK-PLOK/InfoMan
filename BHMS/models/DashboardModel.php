<?php

require 'dbcreds.php';

class DashboardModel extends dbcreds {

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

    public static function occupied_bed_and_available_bed() {
        
        $conn = self::get_connection();
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
    
        $query->bind_param(
            'sssssssssssssss',
            $new_tenant['tenFname'], $new_tenant['tenLname'], $new_tenant['tenMI'],
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
        }
    } 
    
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
    
}

?>