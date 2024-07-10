<?php

require 'dbcreds.php';

class StatisticsModel extends dbcreds {

    public static function fetch_all_data() {
        $conn = self::get_connection();

        $sql = "SELECT * FROM daily_data;";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $conn->close();

        return $data;
    }

}

?>