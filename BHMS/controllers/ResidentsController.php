<?php

require '../models/ResidentsModel.php';
require 'GeneralController.php';

/**
 * This class contains all the controllers/methods that are used in the residents page and ResidentsViews File.
 *
 * @method total_current_residents
 * @method create_new_tenant
 * @method get_appliances
 * @method get_occupancy
 * @method get_last_inserted_tenant_id
 * @method appliance_tenID
 * @method residents_table_data
 * @method residents_table_data_Active
 * @method residents_table_data_Inactive
 * @method residents_table_data_Evicted
 * @method deleteTenantById
 * @method edit_tenant
 * @method all_rooms
 * @method room_tenants
 * @method get_rooms
 * @method delete_occupancy
 * @method residents_table_data_Name
 * @method residents_table_data_Search
 * @method evictTenant
 * @class ResidentsController
 * @extends GeneralController
 */
class ResidentsController extends GeneralController{

    /**
     * Gets the total number of current residents
     * 
     * @method total_current_residents
     * @param none
     * @return ResidentsModel::residents_counter
     */
    public static function total_current_residents(){
        return ResidentsModel::residents_counter();
    }

    /**
     * Adds a new tenant to the database
     * 
     * @method create_new_tenant
     * @param $new_tenant, $appliances
     * @return ResidentsModel::add_new_tenant
     */
    public static function create_new_tenant($new_tenant, $appliances) {
        foreach($new_tenant as $key => $value) {
            $new_tenant[$key] = $value === "" ? NULL : $value;
        }
        return ResidentsModel::add_new_tenant($new_tenant, $appliances);
    }

    /**
     * Fetches all appliances of a tenant
     * 
     * @method get_appliances
     * @param $tenantID
     * @return ResidentsModel::get_appliances
     */
    public static function get_appliances($tenantID){
        return ResidentsModel::get_appliances($tenantID);
    }

    /**
     * Fetches the occupancy of a tenant
     * 
     * @method get_occupancy
     * @param $tenantID
     * @return ResidentsModel::get_occupancy
     */
    public static function get_occupancy($tenantID){
        return ResidentsModel::get_occupancy($tenantID);
    }

    /**
     * Fetches the last inserted tenant ID
     * 
     * @method get_last_inserted_tenant_id
     * @param none
     * @return ResidentsModel::get_last_inserted_tenant_id
     */
    public static function get_last_inserted_tenant_id(){
        return ResidentsModel::get_last_inserted_tenant_id();
    }

    /**
     * Fetches the appliances of a tenant
     * 
     * @method appliance_tenID
     * @param $appliances, $last_id
     * @return ResidentsModel::appliance_tenID
     */
    public static function appliance_tenID($appliances,$last_id){
        return ResidentsModel::appliance_tenID($appliances,$last_id);
    }

    /**
     * Fetches all tenants
     * 
     * @method residents_table_data
     * @param none
     * @return ResidentsModel::residents_data
     */
    public static function residents_table_data(){
        return ResidentsModel::residents_data();
    }

    /**
     * Fetches all active tenants
     * 
     * @method residents_table_data_Active
     * @param none
     * @return ResidentsModel::residents_data_Active
     */
    public static function residents_table_data_Active(){
        return ResidentsModel::residents_data_Active();
    }

    /**
     * Fetches all inactive tenants
     * 
     * @method residents_table_data_Inactive
     * @param none
     * @return ResidentsModel::residents_data_Inactive
     */
    public static function residents_table_data_Inactive(){
        return ResidentsModel::residents_data_Inactive();
    }

    /**
     * Fetches all evicted tenants
     * 
     * @method residents_table_data_Evicted
     * @param none
     * @return ResidentsModel::residents_data_Evicted
     */
    public static function residents_table_data_Evicted(){
        return ResidentsModel::residents_data_Evicted();
    }

    /**
     * Deletes a tenant by ID
     * 
     * @method deleteTenantById
     * @param $tenantIdToDelete
     * @return ResidentsModel::deleteTenantById
     */
    public static function deleteTenantById($tenantIdToDelete){
        $checkResult1 = ResidentsModel::deleteTenantById($tenantIdToDelete);
        return $checkResult1;
    }

    /**
     * Edits a tenant
     * 
     * @method edit_tenant
     * @param $editTenantData, $editAppliances
     * @return ResidentsModel::edit_tenant
     */
    public static function edit_tenant($editTenantData, $editAppliances){
        foreach($editTenantData as $key => $value) {
            $editTenantData[$key] = $value === "" ? NULL : $value;
        }
        return ResidentsModel::edit_tenant($editTenantData, $editAppliances);
    }

    /**
     * Fetches all rooms
     * 
     * @method all_rooms
     * @param none
     * @return ResidentsModel::all_rooms
     */
    public static function all_rooms(){
        return ResidentsModel::all_rooms();
    }

    /**
     * Fetches all tenants in a room
     * 
     * @method room_tenants
     * @param $roomID
     * @return ResidentsModel::room_tenants
     */
    public static function room_tenants($roomID){
        return ResidentsModel::room_tenants($roomID);
    }

    /**
     * Fetches all rooms
     * 
     * @method get_rooms
     * @param none
     * @return ResidentsModel::get_rooms
     */
    public static function get_rooms(){
        return ResidentsModel::get_rooms();
    }

    /**
     * Edits an occupancy
     * 
     * @method editOccupancy
     * @param $editInfo
     * @return string success and error messages
     */
    public static function editOccupancy($editInfo){
        if($editInfo['occDateStart'] == NULL ||
            $editInfo['occDateEnd'] == NULL ||
            $editInfo['roomID'] == NULL ||
            $editInfo['occupancyID'] == NULL){
            return "Error - Empty Fields";
        }

        $checkRoom = ResidentsModel::query_room_info($editInfo['roomID']);

        $occType = (int)$editInfo['occTypeID'];
        $rentCount = (int)$checkRoom['rentCount'];
        $capacity = (int)$checkRoom['capacity'];
        $isAvailable = (int)$checkRoom['isAvailable'];

        echo '<script>console.log("'.$occType.'")</script>';

        if($occType != 1){
            return "Error - Already Renting a Room";
        } else if($rentCount < $capacity && $isAvailable == 0){
            return "Error - Shared Only";
        } else if ($rentCount >= $capacity && $isAvailable == 0) {
            return "Error - Room Full";
        } else {
            ResidentsModel::updateOccupancy($editInfo);
            return "Success - Edit";
        }
    }

    /**
     * Deletes an occupancy
     * 
     * @method delete_occupancy
     * @param $delOccInfo
     * @return ResidentsModel::delete_occupancy
     */
    public static function delete_occupancy($delOccInfo){
        return ResidentsModel::delete_occupancy($delOccInfo);
    }

    /**
     * Fetches all tenants by name
     * 
     * @method residents_data_Name
     * @param none
     * @return ResidentsModel::residents_data_Name
     */
    public static function residents_table_data_Name(){
        return ResidentsModel::residents_data_Name();
    }

    /**
     * Fetches all tenants by search
     * 
     * @method residents_data_Search
     * @param $search
     * @return ResidentsModel::residents_data_Search
     */
    public static function residents_table_data_Search($search){
        return ResidentsModel::residents_data_Search($search);
    }

    /**
     * Evicts a tenant
     * 
     * @method evictTenant
     * @param $evictInfo
     * @return ResidentsModel::evictTenant
     */
    public static function evictTenant($evictInfo) {
        return ResidentsModel::evictTenant($evictInfo);
    }

}

?>