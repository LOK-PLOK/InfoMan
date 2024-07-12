<?php

require_once '../models/RoomhistoryModel.php';
require_once 'GeneralController.php';

class RoomhistoryController extends GeneralController {
    
    public static function room_history($roomCode, $searchTerm) {
        return RoomhistoryModel::query_room_history($roomCode, $searchTerm);
    }

    public static function editOccupancy($editInfo) {
        return RoomhistoryModel::updateOccupancy($editInfo);
    }

    public static function delete_occupancy($occupancyID) {
        return RoomhistoryModel::delete_occupancy($occupancyID);
    }

}

?>