<?php

require_once __DIR__ . '/../models/GeneralModel.php';

class GeneralController {

    public static function all_rooms() {
        return GeneralModel::query_rooms();
    }

    public static function rentCountUpdater() {
        $get_rooms = self::all_rooms();
        
        foreach ($get_rooms as $room) {
            $tenants = GeneralModel::query_current_room_tenants($room['roomID']);
            $tenant_count = count($tenants);
            
            // Assuming query_room_tenants is necessary for additional details not covered by query_current_room_tenants
            $all_tenants = GeneralModel::query_room_tenants($room['roomID']);
            
            // Server-side logging example (consider using a proper logging library)
            error_log("Room Code: " . $room['roomID'] . " - Tenants: " . json_encode($all_tenants));
            
            foreach ($all_tenants as $tenant) {
                $result = GeneralModel::check_recent_rent($tenant['tenID']);
                GeneralModel::update_tenant_rent($tenant['tenID'], $result ? 1 : 0);
            }
            
            if ($tenant_count > 0) {
                GeneralModel::update_room_count($room['roomID'], $tenant_count);
            }
        }
    }

}

?>