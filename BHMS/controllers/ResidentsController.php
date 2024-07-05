<?php

require '../models/ResidentsModel.php';
require 'GeneralController.php';

class ResidentsController extends GeneralController{

    public static function total_current_residents(){
        return ResidentsModel::residents_counter();
    }

    public static function create_new_tenant($new_tenant, $appliances) {
        return ResidentsModel::add_new_tenant($new_tenant, $appliances);
    }

    public static function get_appliances($tenantID){
        return ResidentsModel::get_appliances($tenantID);
    }

    public static function get_occupancy($tenantID){
        return ResidentsModel::get_occupancy($tenantID);
    }

    public static function get_last_inserted_tenant_id(){
        return ResidentsModel::get_last_inserted_tenant_id();
    }

    public static function appliance_tenID($appliances,$last_id){
        return ResidentsModel::appliance_tenID($appliances,$last_id);
    }

    public static function residents_table_data(){
        return ResidentsModel::residents_data();
    }

    public static function deleteTenantById($tenantIdToDelete){
        return ResidentsModel::deleteTenantById($tenantIdToDelete);
    }

    public static function edit_tenant($editTenantData, $editAppliances){
        return ResidentsModel::edit_tenant($editTenantData, $editAppliances);
    }

    public static function all_rooms(){
        return ResidentsModel::all_rooms();
    }

    public static function room_tenants($roomID){
        return ResidentsModel::room_tenants($roomID);
    }

    public static function get_rooms(){
        return ResidentsModel::get_rooms();
    }

    public static function editOccupancy($editInfo){
        return ResidentsModel::editOccupancy($editInfo);
    }

    public static function delete_occupancy($delOccInfo){
        return ResidentsModel::delete_occupancy($delOccInfo);
    }

}

?>