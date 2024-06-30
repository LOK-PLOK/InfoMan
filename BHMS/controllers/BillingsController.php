<?php

require '../models/BillingsModel.php';
require 'GeneralController.php';

class BillingsController extends GeneralController{

    public static function get_paid_billings(){
        return BillingsModel::query_paid_billings();
    }

    public static function get_unpaid_billings(){
        return BillingsModel::query_unpaid_billings();
    }

    public static function get_tenants(){
        return BillingsModel::query_tenants();
    }

    public static function create_billings($new_billing){
        return BillingsModel::query_create_billings();
    }

    public static function delete_billings($billing_id) {
        return BillingsModel::query_delete_billings($billing_id);
    }

}

?>