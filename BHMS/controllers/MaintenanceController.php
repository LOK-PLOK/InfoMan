<?php

require '../models/MaintenanceModel.php';
require 'GeneralController.php';

class MaintenanceController extends GeneralController{
    public static function get_room(){
        return MaintenanceModel::query_rooms();
    }

    public static function create_new_maintenance($create_maintenance){
        return MaintenanceModel::query_new_maintenance($create_maintenance);
    }

    public static function get_On_going_data(){
        return MaintenanceModel::query_On_going_data();
    }

    public static function get_completed_data(){
        return MaintenanceModel::query_completed_data();
    }
    public static function get_canceled_data(){
        return MaintenanceModel::get_canceled_data();
    }

    public static function deleteMaintenanceById($maintenanceID){
        return MaintenanceModel::deleteMaintenanceById($maintenanceID);
    }

    public static function edit_maintenance($edit_maintenance){
        return MaintenanceModel::edit_maintenance($edit_maintenance);
    }
}

?>