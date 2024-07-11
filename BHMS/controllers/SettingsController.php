<?php

require '../models/SettingsModel.php'; 
require 'GeneralController.php';

class SettingsController extends GeneralController{

    // Method to handle rates and pricing
    public static function getRates() {
        return SettingsModel::fetchRates();
    }

    // Method to create a new user
    public static function create_new_user($new_user) {
        return SettingsModel::create_user($new_user);
    }

    // Method to edit an existing user
    public static function edit_user($edit_user) {
        return SettingsModel::edit_user($edit_user);
    }

    // Method to delete a user by ID
    public static function delete_user_by_id($userIdToDelete) {
        return SettingsModel::delete_user($userIdToDelete);
    }

    // Method to handle user information
    public static function users_table_data(){
        return SettingsModel::users_data();
    }

    // Method to fetch appliance rate (Rates and pricing)
    public static function getApplianceRate() {
        return SettingsModel::fetchApplianceRate();
    }

    public static function edit_rates_and_pricing($appRate, $occRates) {
        $result1 = SettingsModel::updateApplianceRate($appRate);
        $result2 = SettingsModel::updateOccupancyRates($occRates);
        if($result1 && $result2) {
            return true;
        } else {
            return false;
        }
    }

    public static function changeUserPassword($newData) {
        $result = SettingsModel::verify_credentials($newData['edit-pass-userID']);

        if($result !== NULL && password_verify($newData['oldPassword'], $result['password'])) {
            $changePassResult = SettingsModel::changePassword($newData);
            if($changePassResult) {
                return true;
            } else {
                return "Error - 1";
            }
        } else {
            return "Error - 2";
        }
    }

}
?>