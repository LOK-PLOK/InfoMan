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

    public static function get_payment_billing_info($billRefNo){
        return BillingsModel::query_get_payment_billing_info($billRefNo);
    }

    public static function create_billings($new_billing){
        return BillingsModel::query_create_billings($new_billing);
    }

    public static function delete_billings($billing_id) {
        return BillingsModel::query_delete_billings($billing_id);
    }

    public static function update_billing($updated_billing){
        return BillingsModel::query_update_billing($updated_billing);
    }

    public static function update_billing_payment($updated_billing_payment){
        return BillingsModel::query_update_billing_payment($updated_billing_payment);
    }

}

?>