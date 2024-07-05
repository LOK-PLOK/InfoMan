<?php

require 'dbcreds.php';

class BillingsModel extends dbcreds {

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
    

    public static function query_billing_data($billRefNo){
        $conn = self::get_connection();
    
        $query = "SELECT CONCAT(tenant.tenFname, ' ', tenant.tenMI, '. ', tenant.tenLname) AS 
        full_name, billing.* FROM billing LEFT JOIN tenant ON billing.tenID = tenant.tenID WHERE billing.billRefNo = ?;";
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

    public static function query_update_billing_payment($updated_billing_payment) {
        $conn = self::get_connection();
        $billRefNo = $updated_billing_payment['billRefNo'];
        $billDueDate = $updated_billing_payment['billDueDate'];
        $billTotal = $updated_billing_payment['billTotal'];
        $payMethod = $updated_billing_payment['payMethod'];
        $payDate = $updated_billing_payment['payDate'];
        $payerFname = $updated_billing_payment['payerFname'];
        $payerLname = $updated_billing_payment['payerLname'];
        $payerMI = $updated_billing_payment['payerMI'];
        
        
        // Use prepared statements to prevent SQL injection and ensure correct syntax
        $query_billing = "UPDATE billing 
                          SET billDueDate = ?, 
                              billTotal = ?
                          WHERE billRefNo = ?";
    
        $stmt_billing = $conn->prepare($query_billing);
        if ($stmt_billing === false) {
            die("Error preparing billing statement: " . $conn->error);
        }
    
        // Bind parameters for billing update
        $stmt_billing->bind_param("sdi", $billDueDate, $billTotal, $billRefNo);
    
        // Execute billing statement
        if ($stmt_billing->execute() === false) {
            die("Error executing billing statement: " . $stmt_billing->error);
        }
    
        $stmt_billing->close();
    
        // Update payment table
        $query_payment = "UPDATE payment 
                          SET payMethod = ?, 
                              payDate = ?,
                              payerFname = ?,
                              payerMI = ?,
                              payerLname = ?
                          WHERE billRefNo = ?";
    
        $stmt_payment = $conn->prepare($query_payment);
        if ($stmt_payment === false) {
            die("Error preparing payment statement: " . $conn->error);
        }
    
        // Bind parameters for payment update
        $stmt_payment->bind_param("sssssi", $payMethod, $payDate, $payerFname, $payerMI, $payerLname, $billRefNo);
    
        // Execute payment statement
        if ($stmt_payment->execute() === false) {
            die("Error executing payment statement: " . $stmt_payment->error);
        }
    
        $stmt_payment->close();
        $conn->close();
    
        return true;
    }
    

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
     

    public static function query_create_billings($new_billing){
        $conn = self::get_connection();
        
        // Check if all required fields are set
        if (!isset($new_billing['tenID'], $new_billing['billTotal'], $new_billing['billDateIssued'], $new_billing['isPaid'])) {
            die("Error: Missing required billing data.");
        }
    
        // Sanitize the inputs
        $tenID = $new_billing['tenID'];
        $billTotal = $new_billing['billTotal'];
        $billDateIssued = date('Y-m-d');
        $isPaid = $new_billing['isPaid'];

        $endDate = $_POST['create-billing-end-date'];
        $billDueDate = date('Y-m-d', strtotime($endDate . ' +7 days'));

    
        $query = "INSERT INTO `billing` (`billRefNo`, `tenID`, `billTotal`, `billDateIssued`, `billDueDate`, `isPaid`) 
                  VALUES (NULL, '$tenID', '$billTotal', '$billDateIssued', '$billDueDate', '$isPaid');";
        if ($conn->query($query) === FALSE) {
            die("Error executing query: " . $conn->error . " Query: " . $query);
        }

        $conn->close();
    
        return true;
    }
    
    public static function query_update_billing($updated_billing) {
        $conn = self::get_connection();
    
        $billRefNo = $updated_billing['billRefNo'];
        $billDateIssued = $updated_billing['billDateIssued'];
        $billDueDate = $updated_billing['billDueDate'];
        $billTotal = $updated_billing['billTotal'];
        $isPaid = $updated_billing['isPaid'];
    
        // Use prepared statements to prevent SQL injection and ensure correct syntax
        $query = "UPDATE billing 
                  SET billDateIssued = ?, 
                      billDueDate = ?, 
                      billTotal = ?, 
                      isPaid = ? 
                  WHERE billRefNo = ?";
    
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
    
        // Bind parameters
        $stmt->bind_param("ssdii", $billDateIssued, $billDueDate, $billTotal, $isPaid, $billRefNo);
    
        // Execute statement
        if ($stmt->execute() === false) {
            die("Error executing statement: " . $stmt->error);
        }
    
        $stmt->close();
        $conn->close();
    
        return true;
    }
    

    public static function query_delete_billings($billing_id) {
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("DELETE FROM billing WHERE billRefNo = ?");
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

    public static function query_paid_billings() {
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $query = "SELECT b.*, t.tenFname AS tenant_first_name, t.tenLname AS tenant_last_name, tenMI
                  FROM billing b
                  INNER JOIN tenant t ON b.tenID = t.tenID
                  WHERE b.isPaid = 1";
        
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

    public static function query_unpaid_billings() {
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $query = "SELECT b.*, t.tenFname AS tenant_first_name, t.tenLname AS tenant_last_name, tenMI
                  FROM billing b
                  INNER JOIN tenant t ON b.tenID = t.tenID
                  WHERE b.isPaid = 0";
        
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