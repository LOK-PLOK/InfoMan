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
     * Adds a new maintenance to the database
     * 
     * @method get_room
     * @param none
     * @return array The array of rooms
     */
    public static function get_room(){
        return MaintenanceModel::query_rooms();
    }

    /**
     * Adds a new maintenance to the database
     * 
     * @method create_new_maintenance
     * @param array $create_maintenance The array of maintenance details
     * @return boolean The result of the query
     */
    public static function create_new_maintenance($create_maintenance){
        return MaintenanceModel::query_new_maintenance($create_maintenance);
    }

    /**
     * Gets all the ongoing maintenance from the database
     * 
     * @method get_On_going_data
     * @param none
     * @return array The array of ongoing maintenance
     */
    public static function get_On_going_data(){
        return MaintenanceModel::query_On_going_data();
    }

    /**
     * Gets all the completed maintenance from the database
     * 
     * @method get_completed_data
     * @param none
     * @return array The array of completed maintenance
     */
    public static function get_completed_data(){
        return MaintenanceModel::query_completed_data();
    }

    /**
     * Gets all the cancelled maintenance from the database
     * 
     * @method get_cancelled_data
     * @param none
     * @return array The array of cancelled maintenance
     */
    public static function get_cancelled_data(){
        return MaintenanceModel::query_cancelled_data();
    }

    /**
     * Deletes a maintenance from the database
     * 
     * @method deleteMaintenanceById
     * @param int $maintenanceID The maintenance ID
     * @return boolean The result of the query
     */
    public static function deleteMaintenanceById($maintenanceID){
        return MaintenanceModel::deleteMaintenanceById($maintenanceID);
    }

    /**
     * Edits a maintenance in the database
     * 
     * @method edit_maintenance
     * @param array $edit_maintenance The array of maintenance details
     * @return boolean The result of the query
     */
    public static function edit_maintenance($edit_maintenance){
        return MaintenanceModel::edit_maintenance($edit_maintenance);
    }

    /**
     * Gets the room code of all the ongoing maintenance from the database
     * 
     * @method get_On_going_data_RoomCode
     * @param none
     * @return array The array of room codes
     */
    public static function get_On_going_data_RoomCode(){
        return MaintenanceModel::query_On_going_data_RoomCode();
    }

    /**
     * Gets the cost of all the ongoing maintenance from the database
     * 
     * @method get_On_going_data_Cost
     * @param none
     * @return array The array of costs
     */
    public static function get_On_going_data_Cost(){
        return MaintenanceModel::query_On_going_data_Cost();
    }

    /**
     * Gets the date of all the ongoing maintenance from the database
     * 
     * @method get_On_going_data_Date
     * @param none
     * @return array The array of dates
     */
    public static function get_On_going_data_Date(){
        return MaintenanceModel::query_On_going_data_Date();
    }

    /**
     * Gets the room code of all the completed maintenance from the database
     * 
     * @method get_completed_data_RoomCode
     * @param none
     * @return array The array of room codes
     */
    public static function get_completed_data_RoomCode(){
        return MaintenanceModel::query_completed_data_RoomCode();
    }

    /**
     * Gets the cost of all the completed maintenance from the database
     * 
     * @method get_completed_data_Cost
     * @param none
     * @return array The array of costs
     */
    public static function get_completed_data_Cost(){
        return MaintenanceModel::query_completed_data_Cost();
    }
    
    /**
     * Gets the date of all the completed maintenance from the database
     * 
     * @method get_completed_data_Date
     * @param none
     * @return array The array of dates
     */
    public static function get_completed_data_Date(){
        return MaintenanceModel::query_completed_data_Date();
    }

    /**
     * Gets the room code of all the cancelled maintenance from the database
     * 
     * @method get_cancelled_data_RoomCode
     * @param none
     * @return array The array of room codes
     */
    public static function get_cancelled_data_RoomCode(){
        return MaintenanceModel::query_cancelled_data_RoomCode();
    }
    
    /**
     * Gets the cost of all the cancelled maintenance from the database
     * 
     * @method get_cancelled_data_Cost
     * @param none
     * @return array The array of costs
     */
    public static function get_cancelled_data_Cost(){
        return MaintenanceModel::query_cancelled_data_Cost();
    }

    /**
     * Gets the date of all the cancelled maintenance from the database
     * 
     * @method get_cancelled_data_Date
     * @param none
     * @return array The array of dates
     */
    public static function get_cancelled_data_Date(){
        return MaintenanceModel::query_cancelled_data_Date();
    }

    /**
     * Gets the ongoing maintenance from the database based on the search query
     * 
     * @method get_On_going_data_search
     * @param string $search The search query
     * @return array The array of ongoing maintenance
     */
    public static function get_On_going_data_search($search){
        return MaintenanceModel::query_On_going_data_search($search);
    }

    /**
     * Gets the completed maintenance from the database based on the search query
     * 
     * @method get_completed_data_search
     * @param string $search The search query
     * @return array The array of completed maintenance
     */
    public static function get_completed_data_search($search){
        return MaintenanceModel::query_completed_data_search($search); 
    }

    /**
     * Gets the cancelled maintenance from the database based on the search query
     * 
     * @method get_cancelled_data_search
     * @param string $search The search query
     * @return array The array of cancelled maintenance
     */
    public static function get_cancelled_data_search($search){
        return MaintenanceModel::query_cancelled_data_search($search);
    }
}

?>