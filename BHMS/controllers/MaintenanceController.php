<?php

require '../models/MaintenanceModel.php';

class MaintenanceController {
    public static function get_room(){
        return MaintenanceModel::query_rooms();
    }

    public static function create_new_maintenance($create_maintenance){
        return MaintenanceModel::query_new_maintenance($create_maintenance);
    }

    public static function get_On_going_data(){
        return MaintenanceModel::query_On_going_data();
        
    }
}

?>