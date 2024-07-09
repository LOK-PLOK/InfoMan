<?php

require_once '../models/RoomlogsModel.php';
require_once 'GeneralController.php';

class RoomlogsController extends GeneralController{

    public static function all_rooms() {
        return RoomlogsModel::query_rooms();
    }

    public static function room_tenants($room_code) {
        return RoomlogsModel::query_room_tenants($room_code);
    } 

    public static function editOccupancy($editInfo) {
        return RoomlogsModel::updateOccupancy($editInfo);
    }

    public static function room_tenant_info($room_tenant_id){
        return RoomlogsModel::query_room_tenant_info($room_tenant_id);
    }

    public static function delete_occupancy($occupancyID) {
        return RoomlogsModel::delete_occupancy($occupancyID);
    }

    public static function get_occupancy($occupancyID) {
        return RoomlogsModel::get_occupancy($occupancyID);
    }

    public static function get_occ_type($occTypeID) {
        return RoomlogsModel::get_occ_type($occTypeID);
    }

    public static function get_tenants() {
        return RoomlogsModel::query_tenants();
    }

    public static function get_rooms() {
        return RoomlogsModel::query_rooms();
    }

    public static function get_types() {
        return RoomlogsModel::query_types();
    }

    public static function addNewRoom($newRoomInfo) {
        return RoomlogsModel::addNewRoom($newRoomInfo);
    }

    public static function editRoom($editRoomInfo) {
        return RoomlogsModel::editRoom($editRoomInfo);
    }

    public static function deleteRoom($roomCode) {
        return RoomlogsModel::deleteRoom($roomCode);
    }

    public static function create_new_rent($create_rent) {
        $tenant_count = count(self::current_room_tenants($create_rent['roomID']));
        $roomInfo = RoomlogsModel::query_room_info($create_rent['roomID']);

        $tenID = $create_rent['tenID'];
        $startDate = $create_rent['occDateStart'];
        $endDate = $create_rent['occDateEnd'];

        $checkTenant = RoomlogsModel::is_tenant_available($tenID, $startDate, $endDate);
        if($checkTenant){
            $bedSpacerID = 1;
            $sharedRoomID = 6;
            if ($create_rent['occTypeID'] == $sharedRoomID) {
                $checkValidity = RoomlogsModel::check_shared_room($create_rent);
                if ($checkValidity == 1 && $tenant_count < $roomInfo['capacity']) {
                    RoomlogsModel::query_add_new_rent($create_rent);
                } else {
                    return "Room cannot be shared!";
                }
            } else if ($create_rent['occTypeID'] != $bedSpacerID && $tenant_count > 0) {
                return "Room can only be occupied for bedspacers!";
            } else if($roomInfo['isAvailable'] == 0 && $tenant_count < $roomInfo['capacity']){
                return "Room can only be shared!";
            } else if ($roomInfo['isAvailable'] == 0) {
                return "Room is already in Full Capacity!";
            } else {
                RoomlogsModel::query_add_new_rent($create_rent);
                return true;
            }
        } else {
            return "Tenant is already occupied on the selected date!";
        }
    }

}

?>