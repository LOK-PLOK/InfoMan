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
    public static function get_cancelled_data(){
        return MaintenanceModel::query_cancelled_data();
    }

    public static function deleteMaintenanceById($maintenanceID){
        return MaintenanceModel::deleteMaintenanceById($maintenanceID);
    }

    public static function edit_maintenance($edit_maintenance){
        return MaintenanceModel::edit_maintenance($edit_maintenance);
    }

    public static function get_On_going_data_RoomCode(){
        return MaintenanceModel::query_On_going_data_RoomCode();
    }

    public static function get_On_going_data_Cost(){
        return MaintenanceModel::query_On_going_data_Cost();
    }

    public static function get_On_going_data_Date(){
        return MaintenanceModel::query_On_going_data_Date();
    }
    public static function get_completed_data_RoomCode(){
        return MaintenanceModel::query_completed_data_RoomCode();
    }

    public static function get_completed_data_Cost(){
        return MaintenanceModel::query_completed_data_Cost();
    }

    public static function get_completed_data_Date(){
        return MaintenanceModel::query_completed_data_Date();
    }

    public static function get_cancelled_data_RoomCode(){
        return MaintenanceModel::query_cancelled_data_RoomCode();
    }

    public static function get_cancelled_data_Cost(){
        return MaintenanceModel::query_cancelled_data_Cost();
    }

    public static function get_cancelled_data_Date(){
        return MaintenanceModel::query_cancelled_data_Date();
    }

    public static function get_On_going_data_search($search){
        return MaintenanceModel::query_On_going_data_search($search);
    }

    public static function get_completed_data_search($search){
        return MaintenanceModel::query_completed_data_search($search); 
    }

    public static function get_cancelled_data_search($search){
        return MaintenanceModel::query_cancelled_data_search($search);
    }
}

?>