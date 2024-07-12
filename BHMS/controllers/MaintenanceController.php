<?php

require '../models/MaintenanceModel.php';
require 'GeneralController.php';

/**
 * This class contains all the controllers/methods that are used in the maintenance page and MaintenanceViews File.
 * 
 * @method get_room
 * @method create_new_maintenance
 * @method get_On_going_data
 * @method get_completed_data
 * @method get_cancelled_data
 * @method deleteMaintenanceById
 * @method edit_maintenance
 * @method get_On_going_data_RoomCode
 * @method get_On_going_data_Cost
 * @method get_On_going_data_Date
 * @method get_completed_data_RoomCode
 * @method get_completed_data_Cost
 * @method get_completed_data_Date
 * @method get_cancelled_data_RoomCode
 * @method get_cancelled_data_Cost
 * @method get_cancelled_data_Date
 * @method get_On_going_data_search
 * @method get_completed_data_search
 * @method get_cancelled_data_search
 * @class MaintenanceController
 * @extends GeneralController
 */

class MaintenanceController extends GeneralController{

    /**
     * Gets the room data
     * 
     * @method get_room
     * @param none
     * @return MaintenanceModel::query_rooms
     */
    public static function get_room(){
        return MaintenanceModel::query_rooms();
    }

    /**
     * Adds a new maintenance to the database
     * 
     * @method create_new_maintenance
     * @param $create_maintenance
     * @return MaintenanceModel::query_new_maintenance
     */
    public static function create_new_maintenance($create_maintenance){
        return MaintenanceModel::query_new_maintenance($create_maintenance);
    }

    /**
     * Gets the ongoing maintenance data
     * 
     * @method get_On_going_data
     * @param none
     * @return MaintenanceModel::query_On_going_data
     */
    public static function get_On_going_data(){
        return MaintenanceModel::query_On_going_data();
    }

    /**
     * Gets the completed maintenance data
     * 
     * @method get_completed_data
     * @param none
     * @return MaintenanceModel::query_completed_data
     */
    public static function get_completed_data(){
        return MaintenanceModel::query_completed_data();
    }

    /**
     * Gets the cancelled maintenance data
     * 
     * @method get_cancelled_data
     * @param none
     * @return MaintenanceModel::query_cancelled_data
     */
    public static function get_cancelled_data(){
        return MaintenanceModel::query_cancelled_data();
    }

    /**
     * Deletes a maintenance by its ID
     * 
     * @method deleteMaintenanceById
     * @param $maintenanceID
     * @return MaintenanceModel::deleteMaintenanceById
     */
    public static function deleteMaintenanceById($maintenanceID){
        return MaintenanceModel::deleteMaintenanceById($maintenanceID);
    }

    /**
     * Edits a maintenance
     * 
     * @method edit_maintenance
     * @param $edit_maintenance
     * @return MaintenanceModel::edit_maintenance
     */
    public static function edit_maintenance($edit_maintenance){
        return MaintenanceModel::edit_maintenance($edit_maintenance);
    }

    /**
     * Gets the ongoing maintenance data
     * 
     * @method get_On_going_data
     * @param none
     * @return MaintenanceModel::query_On_going_data
     */
    public static function get_On_going_data_RoomCode(){
        return MaintenanceModel::query_On_going_data_RoomCode();
    }

    /**
     * Gets the ongoing maintenance data
     * 
     * @method get_On_going_data_Cost
     * @param none
     * @return MaintenanceModel::query_On_going_data_Cost
     */
    public static function get_On_going_data_Cost(){
        return MaintenanceModel::query_On_going_data_Cost();
    }

    /**
     * Gets the ongoing maintenance data
     * 
     * @method get_On_going_data_Date
     * @param none
     * @return MaintenanceModel::query_On_going_data_Date
     */
    public static function get_On_going_data_Date(){
        return MaintenanceModel::query_On_going_data_Date();
    }

    /**
     * Gets the ongoing maintenance data
     * 
     * @method get_On_going_data_Date
     * @param none
     * @return MaintenanceModel::query_completed_data_RoomCode
     */
    public static function get_completed_data_RoomCode(){
        return MaintenanceModel::query_completed_data_RoomCode();
    }

    /**
     * Gets the ongoing maintenance data
     * 
     * @method get_completed_data_Cost
     * @param none
     * @return MaintenanceModel::query_completed_data_Cost
     */
    public static function get_completed_data_Cost(){
        return MaintenanceModel::query_completed_data_Cost();
    }
    
    /**
     * Gets the ongoing maintenance data
     * 
     * @method get_completed_data_Date
     * @param none
     * @return MaintenanceModel::query_completed_data_Date
     */
    public static function get_completed_data_Date(){
        return MaintenanceModel::query_completed_data_Date();
    }
    
    /**
     * Gets the ongoing maintenance data
     * 
     * @method get_cancelled_data_RoomCode
     * @param none
     * @return MaintenanceModel::query_cancelled_data_RoomCode
     */
    public static function get_cancelled_data_RoomCode(){
        return MaintenanceModel::query_cancelled_data_RoomCode();
    }

    /**
     * Gets the ongoing maintenance data
     * 
     * @method get_cancelled_data_Cost
     * @param none
     * @return MaintenanceModel::query_cancelled_data_Cost
     */
    public static function get_cancelled_data_Cost(){
        return MaintenanceModel::query_cancelled_data_Cost();
    }

    /**
     * Gets the ongoing maintenance data
     * 
     * @method get_cancelled_data_Date
     * @param none
     * @return MaintenanceModel::query_cancelled_data_Date
     */
    public static function get_cancelled_data_Date(){
        return MaintenanceModel::query_cancelled_data_Date();
    }

    /**
     * Gets the ongoing maintenance data
     * 
     * @method get_On_going_data_search
     * @param $search
     * @return MaintenanceModel::query_On_going_data_search
     */
    public static function get_On_going_data_search($search){
        return MaintenanceModel::query_On_going_data_search($search);
    }

    /**
     * Gets the ongoing maintenance data
     * 
     * @method get_completed_data_search
     * @param $search
     * @return MaintenanceModel::query_completed_data_search
     */
    public static function get_completed_data_search($search){
        return MaintenanceModel::query_completed_data_search($search); 
    }

    /**
     * Gets the ongoing maintenance data
     * 
     * @method get_cancelled_data_search
     * @param $search
     * @return MaintenanceModel::query_cancelled_data_search
     */
    public static function get_cancelled_data_search($search){
        return MaintenanceModel::query_cancelled_data_search($search);
    }
}

?>