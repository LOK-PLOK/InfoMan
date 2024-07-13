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
     * Get data for total number of residents
     * 
     * @method total_current_residents
     * @param none
     * @return int The number of tenants who are currently renting.
     */
    public static function total_current_residents(){
        return ResidentsModel::residents_counter();
    }

    
    /**
     * Creates a new tenant with the given data and associated appliances.
     * @method create_new_tenant
     * @param array $new_tenant An array containing the data of the new tenant.
     * @param array $appliances An array containing the appliances associated with the new tenant.
     * @return bool The result of adding the new tenant to the database. Returns the 1 if successful, false otherwise.
     */
    public static function create_new_tenant($new_tenant, $appliances) {
        foreach($new_tenant as $key => $value) {
            $new_tenant[$key] = $value === "" ? NULL : $value;
        }
        return ResidentsModel::add_new_tenant($new_tenant, $appliances);
    }

    
    /**
     * Retrieves the appliances for a specific tenant.
     * @method get_appliances
     * @param int $tenantID The ID of the tenant.
     * @return array An array of appliances associated with the tenant.
     */
    public static function get_appliances($tenantID){
        return ResidentsModel::get_appliances($tenantID);
    }

    /**
     * Retrieves the occupancy details for a specific tenant.
     * @method get_occupancy
     * @param int $tenantID The ID of the tenant.
     * @return array An array of occupancy details associated with the tenant.
     */
    public static function get_occupancy($tenantID){
        return ResidentsModel::get_occupancy($tenantID);
    }

    
    /**
     * Retrieves the ID of the last inserted tenant.
     * @method get_last_inserted_tenant_id
     * @param none
     * @return int The ID of the last inserted tenant.
     */
    public static function get_last_inserted_tenant_id(){
        return ResidentsModel::get_last_inserted_tenant_id();
    }

    /**
     * Retrieves the ID of the last inserted appliance.
     * @method appliance_tenID
     * @param array $appliances An array of appliances.
     * @param int $last_id The ID of the last inserted tenant.
     * @return int The ID of the last inserted appliance.
     */
    public static function appliance_tenID($appliances,$last_id){
        return ResidentsModel::appliance_tenID($appliances,$last_id);
    }

    /**
     * Retrieves the data for the residents table.
     * @method residents_table_data
     * @param none
     * @return array An array of data for the residents table.
     */
    public static function residents_table_data(){
        return ResidentsModel::residents_data();
    }

    /**
     * Retrieves the data for the active residents table.
     * @method residents_table_data_Active
     * @param none
     * @return array An array of data for the active residents table.
     */
    public static function residents_table_data_Active(){
        return ResidentsModel::residents_data_Active();
    }

    /**
     * Retrieves the data for the inactive residents table.
     * @method residents_table_data_Inactive
     * @param none
     * @return array An array of data for the inactive residents table.
     */
    public static function residents_table_data_Inactive(){
        return ResidentsModel::residents_data_Inactive();
    }

    /**
     * Retrieves the data for the evicted residents table.
     * @method residents_table_data_Evicted
     * @param none
     * @return array An array of data for the evicted residents table.
     */
    public static function residents_table_data_Evicted(){
        return ResidentsModel::residents_data_Evicted();
    }

    /**
     * Deletes a tenant by their ID.
     * @method deleteTenantById
     * @param int $tenantIdToDelete The ID of the tenant to delete.
     * @return bool The result of deleting the tenant. Returns 1 if successful, false otherwise.
     */
    public static function deleteTenantById($tenantIdToDelete){
        return ResidentsModel::deleteTenantById($tenantIdToDelete);
    }

    /**
     * Edits a tenant with the given data and associated appliances.
     * @method edit_tenant
     * @param array $editTenantData An array containing the data of the tenant to edit.
     * @param array $editAppliances An array containing the appliances associated with the tenant.
     * @return bool The result of editing the tenant in the database. Returns 1 if successful, false otherwise.
     */
    public static function edit_tenant($editTenantData, $editAppliances){
        foreach($editTenantData as $key => $value) {
            $editTenantData[$key] = $value === "" ? NULL : $value;
        }
        return ResidentsModel::edit_tenant($editTenantData, $editAppliances);
    }

    /**
     * Retrieves all rooms.
     * @method all_rooms
     * @param none
     * @return array An array of all rooms.
     */
    public static function all_rooms(){
        return ResidentsModel::all_rooms();
    }

    /**
     * Retrieves the tenants of a specific room.
     * @method room_tenants
     * @param int $roomID The ID of the room.
     * @return array An array of tenants in the room.
     */
    public static function room_tenants($roomID){
        return ResidentsModel::room_tenants($roomID);
    }

    /**
     * Retrieves all rooms.
     * @method get_rooms
     * @param none
     * @return array An array of all rooms.
     */
    public static function get_rooms(){
        return ResidentsModel::get_rooms();
    }

    /**
     * Edits the occupancy of a tenant.
     * @method editOccupancy
     * @param array $editInfo An array containing the data of the occupancy to edit.
     * @return bool The result of editing the occupancy in the database. Returns 1 if successful, false otherwise.
     */
    public static function editOccupancy($editInfo){
        return ResidentsModel::editOccupancy($editInfo);
    }

    /**
     * Deletes an occupancy by its ID.
     * @method delete_occupancy
     * @param int $delOccInfo The ID of the occupancy to delete.
     * @return bool The result of deleting the occupancy. Returns 1 if successful, false otherwise.
     */
    public static function delete_occupancy($delOccInfo){
        return ResidentsModel::delete_occupancy($delOccInfo);
    }

    /**
     * Retrieves the data for the residents table.
     * @method residents_table_data_Name
     * @param none
     * @return array An array of data for the residents table.
     */
    public static function residents_table_data_Name(){
        return ResidentsModel::residents_data_Name();
    }

    /**
     * Retrieves the data for the residents table.
     * @method residents_table_data_Search
     * @param string $search The search query.
     * @return array An array of data for the residents table.
     */
    public static function residents_table_data_Search($search){
        return ResidentsModel::residents_data_Search($search);
    }

    /**
     * Evicts a tenant.
     * @method evictTenant
     * @param int $evictInfo The ID of the tenant to evict.
     * @return bool The result of evicting the tenant. Returns 1 if successful, false otherwise.
     */
    public static function evictTenant($evictInfo) {
        return ResidentsModel::evictTenant($evictInfo);
    }

}

?>