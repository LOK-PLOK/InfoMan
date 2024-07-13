<?php

require_once '../models/RoomhistoryModel.php';
require_once 'GeneralController.php';

/**
 * This class contains all the controllers/methods that are used in the room history page.
 *
 * @method room_history
 * @method editOccupancy
 * @method delete_occupancy
 * @class RoomhistoryController
 * @extends GeneralController
 */
class RoomhistoryController extends GeneralController {
    
    /**
     * Fetches the room history of a room
     * 
     * @method room_history
     * @param $roomCode, $searchTerm
     * @return RoomhistoryModel::query_room_history
     */
    public static function room_history($roomCode, $searchTerm) {
        return RoomhistoryModel::query_room_history($roomCode, $searchTerm);
    }

    /**
     * Edits the occupancy of a room
     * 
     * @method editOccupancy
     * @param $editInfo
     * @return RoomhistoryModel::updateOccupancy
     */
    public static function editOccupancy($editInfo) {
        return RoomhistoryModel::updateOccupancy($editInfo);
    }

    /**
     * Deletes the occupancy of a room
     * 
     * @method delete_occupancy
     * @param $occupancyID
     * @return RoomhistoryModel::delete_occupancy
     */
    public static function delete_occupancy($occupancyID) {
        return RoomhistoryModel::delete_occupancy($occupancyID);
    }

}

?>