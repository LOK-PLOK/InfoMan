<?php

require_once __DIR__ . '/../models/GeneralModel.php';

class GeneralController {

    public static function all_rooms() {
        return GeneralModel::query_rooms();
    }

    public static function updateTenantRentStatus() {
        $get_tenants = GeneralModel::get_all_tenants();
        
        foreach($get_tenants as $tenant) {
            $tenant_id = $tenant['tenID'];
            
            $check_rent = GeneralModel::check_recent_rent($tenant_id);
            GeneralModel::update_rent_status($tenant_id, $check_rent ? 1 : 0);
        }
    }

    public static function updateRoomAvailability() {
        $get_rooms = self::all_rooms();

        foreach($get_rooms as $room) {
            
            $roomID = $room['roomID'];
            $roomCount = $room['rentCount'];
            $roomCapacity = $room['capacity'];

            if($roomCount === $roomCapacity) {
                $status = 0;
            } else {
                $status = 1;
            }

            GeneralModel::update_room_availability($roomID, $status);
        }
    }

    public static function updateRoomTenantCount() {
        $get_rooms = self::all_rooms();
        
        foreach ($get_rooms as $room) {
            $bedSpacerID = 1;
            $tenants = GeneralModel::query_current_room_tenants($room['roomID']);
            $tenant_count = count($tenants);

            if($tenant_count === 1 && $tenants[0]['occTypeID'] !== $bedSpacerID){
                $tenant_count = $room['capacity'];
            }
            
            GeneralModel::update_room_count($room['roomID'], $tenant_count);
        }
    }

    public static function current_room_tenants($roomID) {
        return GeneralModel::query_current_room_tenants($roomID);
    }

}

?>