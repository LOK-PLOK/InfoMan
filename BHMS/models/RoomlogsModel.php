<?php

require 'dbcreds.php';

class RoomlogsModel extends dbcreds {

    public static function query_rooms(){

        $conn = self::get_connection();
        $query = "SELECT * FROM room";
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
        $query = $conn->prepare("SELECT * FROM occupancy WHERE roomID = ?");
        
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
        $query = $conn->prepare("SELECT * FROM tenant WHERE tenID = ?");
        
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

}

?>