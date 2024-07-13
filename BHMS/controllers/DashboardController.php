<?php

require '../models/DashboardModel.php'; 
require 'GeneralController.php';

/**
 * This class contains all the controllers/methods that are used in the dashboard page.
 *
 * @method total_current_residents
 * @method total_occupied_beds_and_available_beds
 * @method available_rooms
 * @method create_new_tenant
 * @method create_new_rent
 * @method get_tenants
 * @method get_rooms
 * @method get_types
 * @class DashboardController
 * @extends GeneralController
 */
class DashboardController extends GeneralController{

    /**
     * Gets the total number of current residents
     * 
     * @method total_current_residents
     * @param none
     * @return DashboardModel::residents_counter
     */
    public static function total_current_residents(){
        return DashboardModel::residents_counter();
    }

    /**
     * Gets the total number of occupied beds and available beds
     * 
     * @method total_occupied_beds_and_available_beds
     * @param none
     * @return DashboardModel::occupied_bed_and_available_bed
     */
    public static function total_occupied_beds_and_available_beds(){
        return DashboardModel::occupied_bed_and_available_bed();
    }

    /**
     * Gets the total number of available rooms
     * 
     * @method available_rooms
     * @param none
     * @return DashboardModel::total_available_rooms
     */
    public static function available_rooms() {
        return DashboardModel::total_available_rooms();
    }

    /**
     * Adds a new tenant to the database
     * 
     * @method create_new_tenant
     * @param $new_tenant, $appliances
     * @return DashboardModel::add_new_tenant
     */
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
     * @param $create_rent
     * @return DashboardModel::query_add_new_rent
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
                self::create_billings($new_billing);
                DashboardModel::query_add_new_rent($create_rent);
                return "Success - Rent";
            }
        } else {
            return "Error - Tenant Rent Error";
        }
    }

    /**
     * Gets all tenants in the database
     * 
     * @method get_tenants
     * @param none
     * @return DashboardModel::query_tenants
     */
    public static function get_tenants() {
        return DashboardModel::query_tenants();
    }

    /**
     * Gets all rooms in the database
     * 
     * @method get_rooms
     * @param none
     * @return DashboardModel::query_rooms
     */
    public static function get_rooms() {
        return DashboardModel::query_rooms();
    }

    /**
     * Gets all types in the database
     * 
     * @method get_types
     * @param none
     * @return DashboardModel::query_types
     */
    public static function get_types() {
        return DashboardModel::query_types();
    }

    public static function create_billings($new_billing){
        $tenantApplianceCount = self::count_appliances($new_billing['tenID']);
        $appRate = DashboardModel::fetchApplianceRate();
        $new_billing['billTotal'] = round($new_billing['billTotal'] + ($tenantApplianceCount * $appRate), 2);
        return DashboardModel::query_create_billings($new_billing);
    }

    public static function count_appliances($tenID){
        return DashboardModel::query_count_appliances($tenID);
    }
}

?>