<?php

require '../models/SettingsModel.php'; 


class SettingsController {

    // Method to handle rates and pricing
    public static function getRates() {
        return SettingsModel::fetchRates();
    }
    
    // Methos to update rates and pricing
    public function updateRates($new_rates) {
        return SettingsModel::updateRates($new_rates);
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
    

    public static function updateApplianceRate($new_rate) {
        return SettingsModel::updateApplianceRate($new_rate);
    }

    public static function updateOccupancyRates($new_rates) {
        return SettingsModel::updateOccupancyRates($new_rates);
    }

    public static function edit_rates_and_pricing($appRate, $occRates) {
        $result1 = self::updateApplianceRate($appRate);
        $result2 = self::updateOccupancyRates($occRates);
        if($result1 && $result2) {
            return true;
        } else {
            return false;
        }
    }

}
?>