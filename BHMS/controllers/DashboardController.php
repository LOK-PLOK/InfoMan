<?php

require '../models/DashboardModel.php';

class DashboardController {

    public static function total_current_residents(){
        return DashboardModel::residents_counter();
    }

    public static function total_occupied_beds_and_available_beds(){
        return DashboardModel::occupied_bed_and_available_bed();
    }

    public static function available_rooms() {
        return DashboardModel::total_available_rooms();
    }

    public static function create_new_tenant($new_tenant) {
        return DashboardModel::add_new_tenant($new_tenant);
    }

}

?>