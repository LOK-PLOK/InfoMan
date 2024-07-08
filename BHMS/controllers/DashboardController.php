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
        return DashboardModel::add_new_tenant($new_tenant,$appliances);
    }

    public static function create_new_rent($create_rent) {
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
                    return "Room can be shared! Tenant Count: ".$tenant_count." Room Capacity: ".$roomInfo['capacity'];
                } else {
                    return "Room cannot be shared!";
                }
            } else if ($create_rent['occTypeID'] != $bedSpacerID && $tenant_count > 0) {
                return "Room can only be occupied for bedspacers!";
            } else if ($roomInfo['isAvailable'] == 0) {
                return "Room is already in Full Capacity!";
            } else {
                DashboardModel::query_add_new_rent($create_rent);
                return true;
            }
        } else {
            return "Tenant is already occupied on the selected date!";
        }
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