<?php

require_once '../models/RoomlogsModel.php';
require_once 'GeneralController.php';

class RoomlogsController extends GeneralController{

    public static function all_rooms() {
        return RoomlogsModel::query_rooms();
    }

    public static function room_tenants($room_code) {
        return RoomlogsModel::query_room_tenants($room_code);
    } 

    public static function room_tenant_info($room_tenant_id){
        return RoomlogsModel::query_room_tenant_info($room_tenant_id);
    }

    public static function delete_occupancy($occupancyID) {
        return RoomlogsModel::delete_occupancy($occupancyID);
    }

    public static function get_occupancy($occupancyID) {
        return RoomlogsModel::get_occupancy($occupancyID);
    }

    public static function get_occ_type($occTypeID) {
        return RoomlogsModel::get_occ_type($occTypeID);
    }

}

?>