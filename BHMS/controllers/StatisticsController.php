<?php

require '../models/StatisticsModel.php';
require 'GeneralController.php';

class StatisticsController extends GeneralController {

    public static function fetchDataMonthly() {
        return StatisticsModel::fetchDataMonthly();
    }

    public static function fetchDataQuarterly() {
        return StatisticsModel::fetchDataQuarterly();
    }

    public static function fetchDataYearly() {
        return StatisticsModel::fetchDataYearly();
    }

    public static function total_current_residents(){
        return StatisticsModel::residents_counter();
    }

}

?>