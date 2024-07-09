<?php

require 'dbcreds.php';

class StatisticsModel extends dbcreds {

    public static function fetch_all_data() {
        $conn = self::get_connection();

        $sql = "SELECT
            c.month,
            c.year,
            CONCAT(c.month, ' ', c.year) AS month_year,
            COALESCE(COUNT(DISTINCT o.tenID), 0) AS CountTenants,
            (SELECT COUNT(*) FROM room r 
            WHERE r.roomID NOT IN (SELECT DISTINCT roomID FROM occupancy o 
                                    WHERE YEAR(o.occDateStart) = c.year 
                                    AND MONTH(o.occDateStart) = c.monthNum)) AS CountEmptyRooms,
            COALESCE(SUM(p.payAmnt), 0) AS TotalPaymentAmount
            FROM
                calendar c
            LEFT JOIN
                occupancy o ON YEAR(o.occDateStart) = c.year AND MONTH(o.occDateStart) = c.monthNum
            LEFT JOIN
                payment p ON YEAR(p.payDate) = c.year AND MONTH(p.payDate) = c.monthNum
            GROUP BY
                c.month, c.year, c.monthNum
            ORDER BY
                c.year, c.monthNum;";

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