<?php

require 'dbcreds.php';


/**
 * This class contains all the models that are used in the statistics page.
 * 
 * @method fetchDataMonthly *
 * @method fetchDataQuarterly *
 * @method fetchDataYearly *
 * @method residents_counter *
 * @class StatisticsModel
 * @extends dbcreds
 */
class StatisticsModel extends dbcreds {


    /**
     * 
     */
    public static function fetchDataMonthly() {
        $conn = self::get_connection();
        $sql = "SELECT * FROM monthly_data";
        $result = $conn->query($sql);
        $data = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        $conn->close();
        return $data;
    }


    /**
     * 
     */
    public static function fetchDataQuarterly() {
        $conn = self::get_connection();
        $sql = "SELECT * FROM quarterly_data";
        $result = $conn->query($sql);
        $data = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        $conn->close();
        return $data;
    }


    /**
     * 
     */
    public static function fetchDataYearly() {
        $conn = self::get_connection();
        $sql = "SELECT * FROM yearly_data";
        $result = $conn->query($sql);
        $data = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        $conn->close();
        return $data;
    }


    /**
     * 
     */
    public static function residents_counter() {

        $conn = self::get_connection();
        $query = "SELECT COUNT(*) AS count FROM tenant t WHERE isRenting = 1 AND t.isDeleted = 0";
        $stmt = $conn->query($query);
    
        if ($stmt === false) {
            die("Error executing query: " . $conn->error);
        }
    
        // Fetch the result
        $row = $stmt->fetch_assoc();
        $result = $row['count'];
    
        // Close the statement and connection
        $stmt->close();
        $conn->close();
    
        // Return the result
        return $result; 
    }

}

?>