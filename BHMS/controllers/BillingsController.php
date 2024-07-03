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

    public static function get_occupancy_types() {
        return BillingsModel::query_get_occupancy_types();
    }

    public static function create_payment($new_payment){
    
        $payerName = [];

        if(empty($new_payment['payerFname']) || empty($new_payment['payerLname']) || empty($new_payment['payerMI'])){
            $payerName = self::get_specific_tenant($new_payment['tenID']);
            $new_payment['payerFname'] = $payerName['tenFname'];
            $new_payment['payerLname'] = $payerName['tenLname'];
            $new_payment['payerMI'] = $payerName['tenMI'];
        } 

        return BillingsModel::query_create_payment($new_payment);
    }

    public static function get_billing_data($billRefNo){
        return BillingsModel::query_billing_data($billRefNo);
    }

    public static function get_specific_tenant($tenID){
        return BillingsModel::query_get_specific_tenant($tenID);
    }

    public static function update_billing_status($new_payment){
        return BillingsModel::query_update_billing_status($new_payment);
    }
}

?>