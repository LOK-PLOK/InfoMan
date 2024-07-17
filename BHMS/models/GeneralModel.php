<?php

require_once 'dbcreds.php';

class GeneralModel extends dbcreds {
 
    public static function query_rooms(){

        $conn = self::get_connection();
        $query = "SELECT * FROM room r WHERE r.isDeleted = 0";
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
        $query = $conn->prepare("SELECT * FROM occupancy o WHERE roomID = ? AND o.isDeleted = 0 ORDER BY occDateStart DESC");
        
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

    public static function query_current_room_tenants($room_code) {
        $conn = self::get_connection();

        $query = $conn->prepare("SELECT * FROM occupancy o WHERE roomID = ? AND CURRENT_DATE BETWEEN occDateStart AND occDateEnd AND DATEDIFF(occDateEnd, occDateStart) >= 30 AND o.isDeleted = 0;");
        
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

    public static function update_rent_status($tenant_id, $isRent) {
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

    public static function check_recent_rent($tenant_id) {
        $conn = self::get_connection();
        $query = $conn->prepare("SELECT COUNT(*) AS rent_count FROM occupancy o WHERE tenID = ? AND CURRENT_DATE BETWEEN occDateStart AND occDateEnd AND DATEDIFF(occDateEnd, occDateStart) >= 30 AND o.isDeleted = 0;");
    
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

    public static function get_all_tenants() {
        $conn = self::get_connection();
        $query = "SELECT * FROM tenant t WHERE t.isDeleted = 0";
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

    public static function update_room_availability($roomID, $status){
        $conn = self::get_connection();
        $query = $conn->prepare("UPDATE room SET isAvailable = ? WHERE roomID = ?");

        if ($query === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $query->bind_param('is', $status, $roomID);

        if (!$query->execute()) {
            throw new Exception("Execute failed: " . $query->error);
        }

        $query->close();
        $conn->close();
    }

    public static function query_user_info($userID){
        $conn = self::get_connection();
        $query = $conn->prepare("SELECT * FROM user WHERE userID = ? AND isDeleted = 0");

        if ($query === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $query->bind_param('i', $userID);

        if (!$query->execute()) {
            throw new Exception("Execute failed: " . $query->error);
        }

        $result = $query->get_result();
        $userInfo = $result->fetch_assoc();

        $query->close();
        $conn->close();

        return $userInfo;
    }

    public static function check_recent_eviction($tenant_id) {
        $conn = self::get_connection();
        $query = $conn->prepare("SELECT COUNT(*) AS eviction_count FROM occupancy o WHERE tenID = ? AND DATEDIFF(occDateEnd, occDateStart) < 30 AND o.isDeleted = 0;");
    
        if ($query === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
    
        $query->bind_param('i', $tenant_id);
    
        if (!$query->execute()) {
            throw new Exception("Execute failed: " . $query->error);
        }
    
        $result = $query->get_result();
        $row = $result->fetch_assoc();
        $eviction_count = $row['eviction_count'];
    
        $query->close();
        $conn->close();
    
        return $eviction_count > 0; // Return true if there are recent evictions, false otherwise
    }

}

?>