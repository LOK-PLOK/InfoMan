<?php

require '../models/StatisticsModel.php';
require 'GeneralController.php';


/**
 * This class contains all the controllers/methods that are used in the statistics page.
 * 
 * @method fetchDataMonthly *
 * @method fetchDataQuarterly *
 * @method fetchDataYearly *
 * @method total_current_residents *
 * @class StatisticsController
 * @extends GeneralController
 */
class StatisticsController extends GeneralController {


    /**
     * 
     */
    public static function fetchDataMonthly() {
        return StatisticsModel::fetchDataMonthly();
    }


    /**
     * 
     */
    public static function fetchDataQuarterly() {
        return StatisticsModel::fetchDataQuarterly();
    }


    /**
     * 
     */
    public static function fetchDataYearly() {
        return StatisticsModel::fetchDataYearly();
    }


    /**
     * Gets the total number of current residents
     * 
     * @method total_current_residents
     * @param none
     * @return int The total number of current residents
     */
    public static function total_current_residents(){
        return StatisticsModel::residents_counter();
    }

}

?>