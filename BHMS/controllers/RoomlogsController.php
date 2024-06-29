<?php

require '../models/RoomlogsModel.php';

class RoomlogsController {

    public static function all_rooms() {
        return RoomlogsModel::query_rooms();
    }

    public static function room_tenants($room_code) {
        return RoomlogsModel::query_room_tenants($room_code);
    }

    public static function room_tenant_info($room_tenant_id){
        return RoomlogsModel::query_room_tenant_info($room_tenant_id);
    }

}

?>