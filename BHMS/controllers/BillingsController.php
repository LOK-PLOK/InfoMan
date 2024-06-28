<?php

require '../models/BillingsModel.php';

class BillingsController {

    public static function get_paid_billings(){
        return BillingsModel::query_paid_billings();
    }

    public static function get_unpaid_billings(){
        return BillingsModel::query_unpaid_billings();
    }

    public static function get_tenants(){
        return BillingsModel::query_tenants();
    }

}

?>