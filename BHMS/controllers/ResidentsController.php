<?php

require '../models/ResidentsModel.php';
require 'GeneralController.php';

class ResidentsController extends GeneralController{

    public static function total_current_residents(){
        return ResidentsModel::residents_counter();
    }

    public static function create_new_tenant($new_tenant) {
        // Insert new tenant
        return ResidentsModel::add_new_tenant($new_tenant);
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

    public static function appliance_data(){
        return ResidentsModel::appliance_data();
    }

    public static function edit_tenant($edit_tenant,$tenID){
        return ResidentsModel::edit_tenant($edit_tenant,$tenID);
    }

    public static function deleteTenantById($tenantIdToDelete){
        return ResidentsModel::deleteTenantById($tenantIdToDelete);
    }
}

?>