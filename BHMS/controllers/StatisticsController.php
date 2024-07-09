<?php

require '../models/StatisticsModel.php';
require 'GeneralController.php';

class StatisticsController extends GeneralController {

    public static function fetch_all_data() {
        $data = json_encode(StatisticsModel::fetch_all_data());
        return $data;
    }

}

?>