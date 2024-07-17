<?php

require '../models/DashboardModel.php'; 
require 'GeneralController.php';

class DashboardController extends GeneralController{

    public static function total_current_residents(){
        return DashboardModel::residents_counter();
    } 

    public static function total_occupied_beds_and_available_beds(){
        return DashboardModel::occupied_bed_and_available_bed();
    }

    public static function available_rooms() {
        return DashboardModel::total_available_rooms();
    }

    public static function create_new_tenant($new_tenant,$appliances) {
        foreach($new_tenant as $key => $value) {
            $new_tenant[$key] = $value === "" ? NULL : $value;
        }
        return DashboardModel::add_new_tenant($new_tenant,$appliances);
    }

    /**
     * Adds a new rent to the database
     * 
     * @method create_new_rent
     * @param array $create_rent The array of rent details
     * @return boolean The result of the query
     */
    public static function create_new_rent($create_rent, $new_billing) {
        $tenant_count = count(self::current_room_tenants($create_rent['roomID']));
        $roomInfo = DashboardModel::query_room_info($create_rent['roomID']);

        $tenID = $create_rent['tenID'];
        $startDate = $create_rent['occDateStart'];
        $endDate = $create_rent['occDateEnd'];

        $checkTenant = DashboardModel::is_tenant_available($tenID, $startDate, $endDate);
        if($checkTenant){
            $bedSpacerID = 1;
            $sharedRoomID = 6;
            if ($create_rent['occTypeID'] == $sharedRoomID) {
                $checkValidity = DashboardModel::check_shared_room($create_rent);
                if ($checkValidity == 1 && $tenant_count < $roomInfo['capacity']) {
                    DashboardModel::query_add_new_rent($create_rent);
                    return "Success - Shared";
                } else {
                    return "Error - Shared";
                }
            } else if ($create_rent['occTypeID'] != $bedSpacerID && $tenant_count > 0) {
                return "Error - Bed Spacer only";
            } else if ($roomInfo['isAvailable'] == 0) {
                return "Error - Room Full";
            } else {
                DashboardModel::query_add_new_rent($create_rent);
                return "Success - Rent";
            }
        } else {
            return "Error - Tenant Rent Error";
        }
        return true;
    }

    public static function get_tenants() {
        return DashboardModel::query_tenants();
    }

    public static function get_rooms() {
        return DashboardModel::query_rooms();
    }

    public static function get_types() {
        return DashboardModel::query_types();
    }

}

?>