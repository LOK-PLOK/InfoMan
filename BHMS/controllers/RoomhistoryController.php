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
     * Gets the room history of a specific room
     * 
     * @method room_history
     * @param string $roomCode The room code
     * @param string $searchTerm The search term
     * @return array The array of room history
     */
    public static function room_history($roomCode, $searchTerm) {
        return RoomhistoryModel::query_room_history($roomCode, $searchTerm);
    }

    /**
     * Edits the occupancy of a room
     * 
     * @method editOccupancy
     * @param array $editInfo The array of occupancy details
     * @return boolean The result of the query
     */
    public static function editOccupancy($editInfo) {
        return RoomhistoryModel::updateOccupancy($editInfo);
    }

    /**
     * Deletes an occupancy
     * 
     * @method delete_occupancy
     * @param int $occupancyID The occupancy ID
     * @return boolean The result of the query
     */
    public static function delete_occupancy($occupancyID) {
        return RoomhistoryModel::delete_occupancy($occupancyID);
    }

}

?>