<?php

require '../models/DashboardModel.php';
require 'GeneralController.php';

class DashboardController extends GeneralController{

    public static function total_current_residents(){
        return DashboardModel::residents_counter();
    }

    public static function total_occupied_beds_and_available_beds(){
        return DashboardModel::occupied_bed_and_available_bed();
    }

    public static function available_rooms() {
        return DashboardModel::total_available_rooms();
    }

    public static function create_new_tenant($new_tenant,$appliances) {
        return DashboardModel::add_new_tenant($new_tenant,$appliances);
    }

    public static function create_new_rent($create_rent) {
        return DashboardModel::query_add_new_rent($create_rent);
    }

    public static function get_tenants() {
        return DashboardModel::query_tenants();
    }

    public static function get_rooms() {
        return DashboardModel::query_rooms();
    }

    public static function get_types() {
        return DashboardModel::query_types();
    }

}

?>