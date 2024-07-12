<?php

require 'dbcreds.php';

class RoomhistoryModel extends dbcreds {

    public static function query_room_history($roomCode, $searchTerm) {
        $conn = self::get_connection();
        // Base query without the search condition
        $queryStr = "
            SELECT occupancy.*, 
                CONCAT(tenant.tenFname, 
                        IF(tenant.tenMI IS NOT NULL AND tenant.tenMI != '', CONCAT(' ', tenant.tenMI, '.'), ''), 
                        ' ', tenant.tenLname) AS tenantFullName,
                occupancy_type.occTypeName
            FROM occupancy 
            INNER JOIN tenant ON occupancy.tenID = tenant.tenID 
            INNER JOIN occupancy_type ON occupancy.occTypeID = occupancy_type.occTypeID
            WHERE roomID = ?
        ";
    
        // Check if $searchTerm is not null and not an empty string
        if ($searchTerm !== null && $searchTerm !== '') {
            $queryStr .= " AND LOWER(CONCAT(tenant.tenFname, ' ', IFNULL(tenant.tenMI, ''), ' ', tenant.tenLname)) LIKE ?";
            $searchTerm = '%' . strtolower($searchTerm) . '%';
        }
    
        $query = $conn->prepare($queryStr);
    
        // Bind parameters based on whether $searchTerm is provided
        if ($searchTerm !== null && $searchTerm !== '') {
            $query->bind_param('ss', $roomCode, $searchTerm);
        } else {
            $query->bind_param('s', $roomCode);
        }
    
        $query->execute();
        $result = $query->get_result();
        $conn->close();
    
        return $result;
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

    public static function delete_occupancy($occupancyID) {
        $conn = self::get_connection();
        $query = $conn->prepare("DELETE FROM occupancy WHERE occupancyID = ?");

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
}

?>