<?php

require 'dbcreds.php';

/**
 * Class for all controllers for Billings page
 * 
 * @method fetchApplianceRate
 * @method query_get_appliances
 * @method query_specific_occupancy_type
 * @method query_overdue_billings
 * @method query_update_billing_status
 * @method query_get_specific_tenant
 * @method query_create_payment
 * @method query_billing_data
 * @method query_get_occupancy_types
 * @method query_update_billing_payment
 * @method query_get_payment_billing_info
 * @method query_create_billings
 * @method query_update_billing
 * @method query_delete_billings
 * @method query_paid_billings
 * @method query_unpaid_billings
 * @method query_all_occupancy
 * @method query_billing_notice_checker
 * 
 * @class BillingsModel
 * @extends dbcreds
 */

class BillingsModel extends dbcreds {
    /**
     * Fetches appliance rate
     * 
     * @method fetchApplianceRate
     * @param none
     * @return decimal
     */
    public static function fetchApplianceRate(){
        try {
            $conn = self::get_connection();
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }
            $stmt = $conn->prepare("
                SELECT COLUMN_DEFAULT 
                FROM INFORMATION_SCHEMA.COLUMNS 
                WHERE TABLE_NAME = 'appliance' 
                AND COLUMN_NAME = 'appRate'
            ");

            $stmt->execute();

            $result = $stmt->get_result();

            $row = $result->fetch_assoc();
            $default_value = $row['COLUMN_DEFAULT'];

            $result->free();
            $stmt->close();
            $conn->close();
            return $default_value;
        } catch (Exception $e) {
            error_log("Error getting appliance rate default value: " . $e->getMessage(), 3, '/var/log/php_errors.log');
            return null;
        }
    }
    
    /**
     * Fetches number of appliances of a certain tenant
     * 
     * @method query_get_appliances
     * @param none
     * @return int
     */
    public static function query_get_appliances($tenID){
        $conn = self::get_connection();
        $query = "SELECT COUNT(*) AS count
            FROM appliance
            WHERE tenID = ?;";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
    
        $stmt->bind_param("i", $tenID); 
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result === false) {
            die("Error executing query: " . $stmt->error);
        }
        
        $results = $result->fetch_assoc();
        
        $stmt->close();
        $conn->close();
        
        return $results;
    }

    /**
     * Fetches the occupancy details of a specific tenant (unused)
     */
    public static function query_specific_occupancy_type($tenID){
        $conn = self::get_connection();
        $query = "SELECT occTypeName, occRate
                FROM occupancy 
                INNER JOIN occupancy_type ON occupancy.occTypeID=occupancy_type.occTypeID
                WHERE occupancy.tenID = ?;";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
    
        $stmt->bind_param("i", $tenID); 
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result === false) {
            die("Error executing query: " . $stmt->error);
        }
        
        $results = $result->fetch_assoc();
        
        $stmt->close();
        $conn->close();
        
        return $results;
    }

    /**
     * Fetches all overdue billings 
     * 
     * @method query_overdue_billings
     * @param none
     * @return array
     */
    public static function query_overdue_billings(){
        $conn = self::get_connection();
    
        $query = "SELECT b.*, t.tenFname AS tenant_first_name, t.tenLname AS tenant_last_name, tenMI
                  FROM billing b
                  INNER JOIN tenant t ON b.tenID = t.tenID
                  WHERE b.billDueDate < CURRENT_DATE AND b.isPaid = 0 AND b.isDeleted = 0
                  ORDER BY b.billDueDate DESC";
        
        $stmt = $conn->query($query);
    
        if ($stmt === false) {
            die("Error executing query: " . $conn->error);
        }
    
        $results = [];
        while ($row = $stmt->fetch_assoc()) {
            $results[] = $row;
        }
    
        $stmt->close();
        $conn->close();
    
        return $results;
    }

    /**
     * Update billing status to paid: activates on payment 
     * 
     * @method query_update_billing_status
     * @param new_payment
     * @return boolean
     */
    public static function query_update_billing_status($new_payment){
        $conn = self::get_connection();
        $billRefNo = $new_payment['billRefNo'];
        
        $query = "UPDATE billing SET isPaid = '1' WHERE billing.billRefNo = ?;";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
    
        $stmt->bind_param("i", $billRefNo);
    
        if ($stmt->execute() === false) {
            die("Error executing statement: " . $stmt->error);
        }
    
        $stmt->close();
        $conn->close();
    
        return true;
    }

    // unused
    public static function query_get_specific_tenant($tenID){
        $conn = self::get_connection();
        $query = "SELECT * FROM tenant WHERE tenID = ?";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
    
        $stmt->bind_param("i", $tenID); 
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result === false) {
            die("Error executing query: " . $stmt->error);
        }
        
        $results = $result->fetch_assoc();
        
        $stmt->close();
        $conn->close();
        
        return $results;
    }

    /**
     * Creates new payment instance
     * 
     * @method query_create_payment
     * @param new_payment
     * @return boolean
     */
    public static function query_create_payment($new_payment) {
        $conn = self::get_connection();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $query = "INSERT INTO payment (billRefNo, payAmnt, payDate, payMethod, payerFname, payerLname, payerMI) 
                  VALUES (?, ?, CURRENT_DATE(), ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
    
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
    
        $stmt->bind_param(
            "idssss", 
            $new_payment['billRefNo'], $new_payment['payAmount'], $new_payment['payMethod'],
            $new_payment['payerFname'], $new_payment['payerLname'], $new_payment['payerMI']);

    
        if ($stmt->execute() === false) {
            die("Error executing statement: " . $stmt->error);
        }
    
    
        $stmt->close();
        $conn->close();
    
        return true;
    }

    /**
     * Fetches full tenant name and associated billings
     * 
     * @method query_billing_data
     * @param billRefNo
     * @return array
     */
    public static function query_billing_data($billRefNo){
        $conn = self::get_connection();
    
        $query = "SELECT CONCAT(tenant.tenFname, ' ', COALESCE(tenant.tenMI, ''), IF(tenant.tenMI IS NOT NULL, '. ', ''), tenant.tenLname) AS full_name, billing.* 
              FROM billing 
              LEFT JOIN tenant ON billing.tenID = tenant.tenID 
              WHERE billing.billRefNo = ?;";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
    
        $stmt->bind_param("i", $billRefNo); 
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result === false) {
            die("Error executing query: " . $stmt->error);
        }
        
        $results = $result->fetch_assoc();
        
        $stmt->close();
        $conn->close();
        
        return $results;
    }

    /**
     * Fetches all occupancy types
     * 
     * @method query_billing_data
     * @param none
     * @return array
     */
    public static function query_get_occupancy_types(){
        $conn = self::get_connection();
        $query = "SELECT * FROM occupancy_type";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
    
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result === false) {
            die("Error executing query: " . $stmt->error);
        }
        
        $results = [];
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
        
        $stmt->close();
        $conn->close();
        
        return $results;

    }

    /**
     * Update paid billing total and payer details
     * 
     * @method query_update_billing_payment
     * @param none
     * @return boolean
     */
    public static function query_update_billing_payment($updated_billing_payment) {
        $conn = self::get_connection();
        $billRefNo = $updated_billing_payment['billRefNo'];
        $billTotal = $updated_billing_payment['billTotal'];

        $payMethod = $updated_billing_payment['payMethod'];
        $payerFname = $updated_billing_payment['payerFname'];
        $payerLname = $updated_billing_payment['payerLname'];
        $payerMI = $updated_billing_payment['payerMI'];
        
        $query_billing = "UPDATE billing 
                          SET billTotal = ?
                          WHERE billRefNo = ?";
    
        $stmt_billing = $conn->prepare($query_billing);
        if ($stmt_billing === false) {
            die("Error preparing billing statement: " . $conn->error);
        }
        $stmt_billing->bind_param("di", $billTotal, $billRefNo);
        if ($stmt_billing->execute() === false) {
            die("Error executing billing statement: " . $stmt_billing->error);
        }
        $stmt_billing->close();
        $query_payment = "UPDATE payment 
                          SET payMethod = ?, 
                              payerFname = ?,
                              payerMI = ?,
                              payerLname = ?,
                              payAmnt = ?
                          WHERE billRefNo = ?";
    
        $stmt_payment = $conn->prepare($query_payment);
        if ($stmt_payment === false) {
            die("Error preparing payment statement: " . $conn->error);
        }
    
        $stmt_payment->bind_param("ssssdi", $payMethod, $payerFname, $payerMI, $payerLname, $billTotal, $billRefNo);
    
        if ($stmt_payment->execute() === false) {
            die("Error executing payment statement: " . $stmt_payment->error);
        }
    
        $stmt_payment->close();
        $conn->close();
    
        return true;
    }

    /**
     * Update paid billing total and payer details
     * 
     * @method query_update_billing_payment
     * @param none
     * @return boolean
     */
    public static function query_get_payment_billing_info($billRefNo){
        $conn = self::get_connection();
    
        $query = "SELECT * FROM payment WHERE billRefNo = ?";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
    
        $stmt->bind_param("i", $billRefNo); 
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result === false) {
            die("Error executing query: " . $stmt->error);
        }
        
        $results = [];
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
        
        $stmt->close();
        $conn->close();
        
        return $results;
    }

    /**
     * Creates new billing instance
     * 
     * @method query_create_billings
     * @param new_billing
     * @return boolean
     */
    public static function query_create_billings($new_billing){
        $conn = self::get_connection();
        
        // Sanitize the inputs
        $tenID = $new_billing['tenID'];
        $billTotal = $new_billing['billTotal'];
        $billDateIssued = date('Y-m-d');

        $endDate = $_POST['create-billing-end-date'];
        $billDueDate = date('Y-m-d', strtotime($endDate . ' +7 days'));

    
        $query = "INSERT INTO `billing` (`billRefNo`, `tenID`, `billTotal`, `billDateIssued`, `billDueDate`, `isPaid`) 
                  VALUES (NULL, '$tenID', '$billTotal', '$billDateIssued', '$billDueDate', 0);";
        if ($conn->query($query) === FALSE) {
            die("Error executing query: " . $conn->error . " Query: " . $query);
        }

        $conn->close();
    
        return true;
    }
    
    /**
     * Updates billing instance
     * 
     * @method query_update_billings
     * @param updated_billing
     * @return boolean
     */
    public static function query_update_billing($updated_billing) {
        $conn = self::get_connection();
    
        $billRefNo = $updated_billing['billRefNo'];
        $billTotal = $updated_billing['billTotal'];
        $billDateIssued = $updated_billing['billDateIssued'];
    
        // Use prepared statements to prevent SQL injection and ensure correct syntax
        $query = "UPDATE billing 
                  SET billTotal = ?, 
                  billDateIssued = ?
                  WHERE billRefNo = ?";
    
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
    
        // Bind parameters
        $stmt->bind_param("dsi", $billTotal, $billDateIssued, $billRefNo);
    
        // Execute statement
        if ($stmt->execute() === false) {
            die("Error executing statement: " . $stmt->error);
        }
    
        $stmt->close();
        $conn->close();
    
        return true;
    }
    

    /**
     * Deletes billing instance
     * 
     * @method query_delete_billings
     * @param billing_id
     * @return boolean
     */
    public static function query_delete_billings($billing_id) {
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $billInfoData = self::query_billing_data($billing_id);

        if($billInfoData['isPaid'] == 1){
            $queryPayment = $conn->prepare("UPDATE payment SET isDeleted = '1' WHERE payment.billRefNo = ?;");
            $queryPayment->bind_param("i", $billing_id);
            $queryPayment->execute();
            $queryPayment->close();
        }

        $stmt = $conn->prepare("UPDATE billing SET isDeleted = '1' WHERE billing.billRefNo = ?;");
        $stmt->bind_param("i", $billing_id);
        
        return $stmt->execute();
    }
    

    public static function query_tenants(){
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT * FROM tenant";
        $stmt = $conn->query($query);

        if ($stmt === false) {
            die("Error executing query: " . $conn->error);
        }
    
        $results = [];
        while ($row = $stmt->fetch_assoc()) {
            $results[] = $row;
        }
    
        $stmt->close();
        $conn->close();
    
        return $results;
    }

    /**
     * Fetches all billings with paid status
     * 
     * @method query_paid_billings
     * @param none
     * @return array
     */
    public static function query_paid_billings() {
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $query = "SELECT b.*, t.tenFname AS tenant_first_name, t.tenLname AS tenant_last_name, tenMI
                  FROM billing b
                  LEFT JOIN tenant t ON b.tenID = t.tenID
                  WHERE b.isPaid = 1 AND b.isDeleted = 0
                  ORDER BY b.billDueDate DESC";
        
        $stmt = $conn->query($query);
    
        if ($stmt === false) {
            die("Error executing query: " . $conn->error);
        }
    
        $results = [];
        while ($row = $stmt->fetch_assoc()) {
            $results[] = $row;
        }
    
        $stmt->close();
        $conn->close();
    
        return $results;
    }

    /**
     * Fetches all billings with unpaid status
     * 
     * @method query_unpaid_billings
     * @param none
     * @return array
     */
    public static function query_unpaid_billings() {
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $query = "SELECT b.*, t.tenFname AS tenant_first_name, t.tenLname AS tenant_last_name, tenMI
                  FROM billing b
                  INNER JOIN tenant t ON b.tenID = t.tenID
                  WHERE b.isPaid = 0 AND b.billDueDate >= CURRENT_DATE AND b.isDeleted = 0
                  ORDER BY b.billDueDate DESC";
        
        $stmt = $conn->query($query);
    
        if ($stmt === false) {
            die("Error executing query: " . $conn->error);
        }
    
        $results = [];
        while ($row = $stmt->fetch_assoc()) {
            $results[] = $row;
        }
    
        $stmt->close();
        $conn->close();
    
        return $results;
    } 

    /**
     * Fetches all occupancy instances
     * 
     * @method query_paid_billings
     * @param none
     * @return array
     */
    public static function query_all_occupancy() {
        $conn = self::get_connection();
    
        $query = "SELECT * FROM occupancy";
        
        $stmt = $conn->query($query);
    
        if ($stmt === false) {
            die("Error executing query: " . $conn->error);
        }
    
        $results = [];
        while ($row = $stmt->fetch_assoc()) {
            $results[] = $row;
        }
    
        $stmt->close();
        $conn->close();
    
        return $results;
    }
}

?>