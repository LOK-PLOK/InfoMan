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
        if($editInfo['occDateStart'] == NULL ||
            $editInfo['occDateEnd'] == NULL ||
            $editInfo['roomID'] == NULL ||
            $editInfo['occupancyID'] == NULL){
            return "Error - Empty Fields";
        }

        $checkRoom = RoomlogsModel::query_room_info($editInfo['roomID']);

        $rentCount = (int)$checkRoom['rentCount'];
        $capacity = (int)$checkRoom['capacity'];
        $isAvailable = (int)$checkRoom['isAvailable'];

        if($editInfo['occTypeID'] != 1){
            return "Error - Already Renting a Room";
        } else if($rentCount < $capacity && $isAvailable == 0){
            return "Error - Shared Only";
        } else if ($rentCount >= $capacity && $isAvailable == 0) {
            return "Error - Room Full";
        } else {
            RoomlogsModel::updateOccupancy($editInfo);
            return "Success - Edit";
        }
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
        if($newRoomInfo['capacity'] == NULL){
            $newRoomInfo['capacity'] = 1;
        }
        return RoomlogsModel::addNewRoom($newRoomInfo);
    }

    public static function editRoom($editRoomInfo) {
        return RoomlogsModel::editRoom($editRoomInfo);
    }

    public static function deleteRoom($roomCode) {
        return RoomlogsModel::deleteRoom($roomCode);
    }

    public static function create_new_rent($create_rent, $new_billing) {

        if($create_rent['occDateStart'] == NULL ||
            $create_rent['occDateEnd'] == NULL ||
            $create_rent['occTypeID'] == NULL ||
            $create_rent['roomID'] == NULL ||
            $create_rent['tenID'] == NULL ||
            $new_billing['billTotal'] == NULL){
            return "Error - Empty Fields";
        }

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
                    return "Success - Shared";
                } else {
                    return "Error - Shared";
                }
            } else if ($create_rent['occTypeID'] != $bedSpacerID && $tenant_count > 0) {
                return "Error - Bed Spacer only";
            } else if ($roomInfo['isAvailable'] == 0) {
                return "Error - Room Full";
            } else {
                self::create_billings($new_billing);
                RoomlogsModel::query_add_new_rent($create_rent);
                return "Success - Rent";
            }
        } else {
            return "Error - Tenant Rent Error";
        }
    }

    public static function deact_occupancy($deactOccInfo) {
        return RoomlogsModel::query_deact_occupancy($deactOccInfo);
    }

    public static function is_room_has_overdue($room_code) {
        return RoomlogsModel::query_overdue_occupancy($room_code);
    }

    public static function create_billings($new_billing){
        $tenantApplianceCount = self::count_appliances($new_billing['tenID']);
        $appRate = RoomlogsModel::fetchApplianceRate();
        $new_billing['billTotal'] = round($new_billing['billTotal'] + ($tenantApplianceCount * $appRate), 2);
        return RoomlogsModel::query_create_billings($new_billing);
    }

    public static function count_appliances($tenID){
        return RoomlogsModel::query_count_appliances($tenID);
    }

}

?>