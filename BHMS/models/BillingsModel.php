<?php

require 'dbcreds.php';

class BillingsModel extends dbcreds {


    /**
     * Fetch the default value of the appRate column in the appliance table
     */
    public static function fetchApplianceRate(){
        try {
            // Create a connection to the database
            $conn = self::get_connection();

            // Prepare the SQL query to get the default value of the appRate column
            $stmt = $conn->prepare("
                SELECT * FROM appliance_rate_defaults
            ");

            // Execute the statement
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();

            // Fetch the row as an associative array
            $row = $result->fetch_assoc();
            $default_value = $row['COLUMN_DEFAULT'];

            // Free the result
            $result->free();

            // Close the statement
            $stmt->close();

            // Close the connection
            $conn->close();

            // Return the default value
            return $default_value;
        } catch (Exception $e) {
            // Log the error to a file or handle it as needed
            error_log("Error getting appliance rate default value: " . $e->getMessage(), 3, '/var/log/php_errors.log');

            // Return null to indicate failure
            return null;
        }
    }


    /**
     * 
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
     *
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
     *
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
     *
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


    /*
    * 
    */
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
     * 
     */
    public static function query_create_payment($new_payment) {
        $conn = self::get_connection();
    
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
     * 
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
     * 
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
     * 
     */
    public static function query_update_billing_payment($updated_billing_payment) {
        $conn = self::get_connection();

        $billRefNo = $updated_billing_payment['billRefNo'];
        $billTotal = $updated_billing_payment['billTotal'];

        $payMethod = $updated_billing_payment['payMethod'];
        $payerFname = $updated_billing_payment['payerFname'];
        $payerLname = $updated_billing_payment['payerLname'];
        $payerMI = $updated_billing_payment['payerMI'];
        
        
        // Use prepared statements to prevent SQL injection and ensure correct syntax
        $query_billing = "UPDATE billing 
                          SET billTotal = ?
                          WHERE billRefNo = ?";
    
        $stmt_billing = $conn->prepare($query_billing);
        if ($stmt_billing === false) {
            die("Error preparing billing statement: " . $conn->error);
        }
    
        // Bind parameters for billing update
        $stmt_billing->bind_param("di", $billTotal, $billRefNo);
    
        // Execute billing statement
        if ($stmt_billing->execute() === false) {
            die("Error executing billing statement: " . $stmt_billing->error);
        }
    
        $stmt_billing->close();
    
        // Update payment table
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
    
        // Bind parameters for payment update
        $stmt_payment->bind_param("ssssdi", $payMethod, $payerFname, $payerMI, $payerLname, $billTotal, $billRefNo);
    
        // Execute payment statement
        if ($stmt_payment->execute() === false) {
            die("Error executing payment statement: " . $stmt_payment->error);
        }
    
        $stmt_payment->close();
        $conn->close();
    
        return true;
    }


    /**
     * 
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
     * 
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
     * 
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
     * 
     */
    public static function query_delete_billings($billing_id) {
        $conn = self::get_connection();

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
    


    /**
     * 
     */
    public static function query_tenants(){
        $conn = self::get_connection();

        $query = "SELECT * FROM tenant WHERE isDeleted = 0";
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
     * 
     */
    public static function query_paid_billings() {
        $conn = self::get_connection();

        // have another
    
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
     * 
     */
    public static function query_unpaid_billings() {
        $conn = self::get_connection();
    
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
     * 
     */
    public static function query_all_occupancy() {
        $conn = self::get_connection();
    
        $query = "SELECT * FROM occupancy WHERE isDeleted = 0";
        
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