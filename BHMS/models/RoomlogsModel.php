<?php

require 'dbcreds.php';

class RoomlogsModel extends dbcreds {

    public static function query_rooms(){

        $conn = self::get_connection();
        $query = "SELECT * FROM room WHERE isDeleted = 0";
        $stmt = $conn->query($query);

        if ($stmt === false) {
            die("Error executing query: " . $conn->error);
        }

        // Fetch the result
        $results = [];
        while ($row = $stmt->fetch_assoc()) {
            $results[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $results;
    }

    public static function query_room_tenants($room_code) {
        $conn = self::get_connection();
        $query = $conn->prepare("
            SELECT * FROM occupancy 
            WHERE roomID = ? 
            AND (
                (CURRENT_DATE() BETWEEN occDateStart AND occDateEnd AND DATEDIFF(occDateEnd, occDateStart) >= 30 AND isDeactivated = 0 AND isDeleted = 0) 
                OR 
                (CURRENT_DATE > occDateEnd AND isDeactivated = 0 AND isDeleted = 0)
            )
            ORDER BY occDateEnd DESC;
        ");
        
        if ($query === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
    
        $query->bind_param('s', $room_code);
    
        if (!$query->execute()) {
            throw new Exception("Execute failed: " . $query->error);
        }
    
        $result = $query->get_result();
        $results = [];
    
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
    
        $query->close();
        $conn->close();
    
        return $results;
    }

    public static function query_room_tenant_info($room_tenant_id) {
        $conn = self::get_connection();
        $query = $conn->prepare("SELECT * FROM tenant WHERE tenID = ? AND isDeleted = 0;");
        
        if ($query === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
    
        $query->bind_param('i', $room_tenant_id);
    
        if (!$query->execute()) {
            throw new Exception("Execute failed: " . $query->error);
        }
    
        $result = $query->get_result();
        $tenant_info = $result->fetch_assoc();
    
        $query->close();
        $conn->close();
    
        return $tenant_info;
    }

    public static function query_current_room_tenants($room_code) {
        $conn = self::get_connection();

        $query = $conn->prepare("SELECT * FROM occupancy WHERE roomID = ? AND CURRENT_DATE BETWEEN occDateStart AND occDateEnd AND isDeleted = 0;");
        
        if ($query === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
    
        $query->bind_param('s', $room_code);
    
        if (!$query->execute()) {
            throw new Exception("Execute failed: " . $query->error);
        }
    
        $result = $query->get_result();
        $results = [];
    
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
    
        $query->close();
        $conn->close();
    
        return $results;
    }

    public static function update_room_count($room_code, $tenant_count) {
        $conn = self::get_connection();
        $query = $conn->prepare("UPDATE room SET rentCount = ? WHERE roomID = ?");

        if ($query === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $query->bind_param('is', $tenant_count, $room_code);

        if (!$query->execute()) {
            throw new Exception("Execute failed: " . $query->error);
        }

        $query->close();
        $conn->close();
    }

    public static function update_tenant_rent($tenant_id, $isRent) {
        $conn = self::get_connection();
        $query = $conn->prepare("UPDATE tenant SET isRenting = ? WHERE tenID = ?");

        if ($query === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $query->bind_param('ii', $isRent, $tenant_id);

        if (!$query->execute()) {
            throw new Exception("Execute failed: " . $query->error);
        }

        $query->close();
        $conn->close();
    }

    public static function updateOccupancy($editInfo) {
        $conn = self::get_connection();
        $query = $conn->prepare("UPDATE occupancy SET roomID = ?, occDateStart = ?, occDateEnd = ? WHERE occupancyID = ?");

        if ($query === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $query->bind_param(
            'sssi', 
            $editInfo['roomID'], $editInfo['occDateStart'], 
            $editInfo['occDateEnd'], $editInfo['occupancyID']
        );

        if (!$query->execute()) {
            $query->close();
            $conn->close();
            throw new Exception("Execute failed: " . $query->error);
            return false;
        } else {
            $query->close();
            $conn->close();
            return true;
        }
    }

    public static function check_recent_rent($tenant_id) {
        $conn = self::get_connection();
        $query = $conn->prepare("SELECT COUNT(*) AS rent_count FROM `occupancy` WHERE tenID = ? AND CURRENT_DATE BETWEEN occDateStart AND occDateEnd AND isDeleted = 0;");
    
        if ($query === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
    
        $query->bind_param('i', $tenant_id);
    
        if (!$query->execute()) {
            throw new Exception("Execute failed: " . $query->error);
        }
    
        $result = $query->get_result();
        $row = $result->fetch_assoc();
        $rent_count = $row['rent_count'];
    
        $query->close();
        $conn->close();
    
        return $rent_count > 0; // Return true if there are recent rents, false otherwise
    }

    public static function delete_occupancy($occupancyID) {
        $conn = self::get_connection();
        $query = $conn->prepare("UPDATE occupancy SET isDeleted = 1 WHERE occupancyID = ?");

        if ($query === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $query->bind_param('i', $occupancyID);

        if (!$query->execute()) {
            throw new Exception("Execute failed: " . $query->error);
        }

        $query->close();
        $conn->close();

        return true;
    }

    public static function get_occupancy($occupancyID) {
        $conn = self::get_connection();
        $query = $conn->prepare("SELECT * FROM occupancy WHERE occupancyID = ? AND isDeleted = 0");

        if ($query === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $query->bind_param('i', $occupancyID);

        if (!$query->execute()) {
            throw new Exception("Execute failed: " . $query->error);
        }

        $result = $query->get_result();
        $occupancy = $result->fetch_assoc();

        $query->close();
        $conn->close();

        return $occupancy;
    }

    public static function get_occ_type($occTypeID) {
        $conn = self::get_connection();
        $query = $conn->prepare("SELECT * FROM occupancy_type WHERE occTypeID = ?");

        if ($query === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $query->bind_param('i', $occTypeID);

        if (!$query->execute()) {
            throw new Exception("Execute failed: " . $query->error);
        }

        $result = $query->get_result();
        $occ_type = $result->fetch_assoc();

        $query->close();
        $conn->close();

        return $occ_type;
    }

    public static function query_tenants(){
        
        $conn = self::get_connection();
        $query = "SELECT * FROM tenant WHERE isDeleted = 0";
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

    public static function addNewRoom($newRoomInfo) {
        try {
            $conn = self::get_connection();
            $query = $conn->prepare("INSERT INTO room (roomID, capacity) VALUES (?, ?)");

            if ($query === false) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            $query->bind_param('si', $newRoomInfo['roomID'], $newRoomInfo['capacity']);

            if (!$query->execute()) {
                throw new Exception("Execute failed: " . $query->error);
            }

            $query->close();
            $conn->close();
            
            return true;
        } catch (Exception $e) {
            // Handle the exception
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public static function editRoom($editRoomInfo) {
        try {
            $conn = self::get_connection();
            $query = $conn->prepare("UPDATE room SET roomID = ? ,capacity = ? WHERE roomID = ?");

            if ($query === false) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            $query->bind_param('sis', $editRoomInfo['newRoomID'], $editRoomInfo['capacity'], $editRoomInfo['roomID']);

            if (!$query->execute()) {
                throw new Exception("Execute failed: " . $query->error);
            }

            $query->close();
            $conn->close();
            
            return true;
        } catch (Exception $e) {
            // Handle the exception
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public static function deleteRoom($roomCode) {
        try {
            $conn = self::get_connection();
            $query = $conn->prepare("UPDATE room SET isDeleted = 1 WHERE roomID = ?");

            if ($query === false) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            $query->bind_param('s', $roomCode);

            if (!$query->execute()) {
                throw new Exception("Execute failed: " . $query->error);
            }

            $query->close();
            $conn->close();
            
            return true;
        } catch (Exception $e) {
            // Handle the exception
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public static function query_room_info($roomID){
        $conn = self::get_connection();
        $query = $conn->prepare("SELECT * FROM room WHERE roomID = ? AND isDeleted = 0");
        $query->bind_param('s', $roomID);
        $query->execute();
        $result = $query->get_result()->fetch_assoc();
        $query->close();
        $conn->close();
        return $result;
    }

    public static function is_tenant_available($tenID, $startDate, $endDate){

        $conn = self::get_connection();
        $query = $conn->prepare("SELECT COUNT(*) AS no_of_conflicts 
                                    FROM occupancy 
                                    WHERE tenID = ? 
                                    AND (
                                        (occDateStart <= ? AND occDateEnd >= ?) OR
                                        (occDateEnd >= ? AND occDateStart <= ?)
                                    )
                                    AND isDeleted = 0;");
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


    public static function check_shared_room($check_rent) {
        $conn = self::get_connection();
        $query = $conn->prepare("SELECT COUNT(*) FROM occupancy WHERE roomID = ?
                                AND tenID = ? AND occDateStart = ? AND occDateEnd = ? AND isDeleted = 0");

        $query->bind_param('siss', $check_rent['roomID'], $check_rent['shareTenID'], $check_rent['occDateStart'], $check_rent['occDateEnd']);
        
        $query->execute();
        
        $result = $query->get_result()->fetch_assoc();
        
        $query->close();
        
        $conn->close();
        return $result['COUNT(*)'] > 0;
    }

    public static function query_deact_occupancy($deactOccInfo) {
        try {
            echo '<script>console.log("(MODEL)deactOccInfo: ",'.json_encode($deactOccInfo).');</script>';
            $conn = self::get_connection();
            $query = $conn->prepare("UPDATE occupancy SET isDeactivated = 1 WHERE occupancyID = ?");

            if ($query === false) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            $query->bind_param('i', $deactOccInfo);

            if (!$query->execute()) {
                throw new Exception("Execute failed: " . $query->error);
            }

            $query->close();
            $conn->close();

            return true;
        } catch (Exception $e) {
            // Handle the exception
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public static function query_overdue_occupancy($roomID) {
        try {
            $conn = self::get_connection();
            // Prepare the SQL query using the provided roomID as a parameter
            $query = $conn->prepare("SELECT COUNT(*) AS overdue_count FROM occupancy WHERE roomID = ? AND CURRENT_DATE > occDateEnd AND isDeactivated = 0 AND isDeleted = 0");

            if ($query === false) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            // Bind the roomID parameter to the query
            $query->bind_param('s', $roomID);

            if (!$query->execute()) {
                throw new Exception("Execute failed: " . $query->error);
            }

            $result = $query->get_result();
            $row = $result->fetch_assoc(); // Fetch the result row

            $query->close();
            $conn->close();

            return $row['overdue_count'] > 0; // Return the count of overdue occupancies
        } catch (Exception $e) {
            // Handle the exception
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


}

?>