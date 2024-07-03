<?php

require 'dbcreds.php';

class ResidentsModel extends dbcreds{

    public static function residents_counter() {
        // Use self to access static variables within the static method
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
        // Check for connection errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        // Prepare the SQL statement with a parameter placeholder
        $query = "SELECT COUNT(*) AS count FROM tenant WHERE isRenting = 1";
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

        echo '<script>console.log('.json_encode("test").')</script>';
        
    }

    public static function add_new_tenant($new_tenant, $appliances) {
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
    
        $query = $conn->prepare("INSERT INTO tenant (
            tenFname, 
            tenLname, 
            tenMI, 
            tenHouseNum, 
            tenSt, 
            tenBrgy, 
            tenCityMun, 
            tenProvince, 
            tenContact, 
            tenBdate, 
            tenGender, 
            emContactFname, 
            emContactLname, 
            emContactMI, 
            emContactNum, 
            isRenting
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0);");
    
        if ($query === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
    
        $query->bind_param(
            'sssssssssssssss',
            $new_tenant['tenFname'], $new_tenant['tenLname'], $new_tenant['tenMI'],
            $new_tenant['tenHouseNum'], $new_tenant['tenSt'], $new_tenant['tenBrgy'],
            $new_tenant['tenCityMun'], $new_tenant['tenProvince'], $new_tenant['tenContact'],
            $new_tenant['tenBdate'], $new_tenant['tenGender'], $new_tenant['emContactFname'],
            $new_tenant['emContactLname'], $new_tenant['emContactMI'], $new_tenant['emContactNum']
        );
    
        if ($query->execute()) {
            $tenantID = $conn->insert_id;
            $query->close();
    
            foreach($appliances as $appliance) {
                $appInfo = $appliance['appInfo'];
                $appQuery = $conn->prepare("INSERT INTO appliance (tenID, appInfo, appRate) VALUES (?, ?, ?)");
                
                if ($appQuery === false) {
                    throw new Exception("Prepare failed for appliance: " . $conn->error);
                }
    
                $appRate = 100.00; // assuming a fixed rate, adjust if needed
                $appQuery->bind_param('isd', $tenantID, $appInfo, $appRate);
    
                if (!$appQuery->execute()) {
                    $appQuery->close();
                    $conn->close();
                    throw new Exception("Execution failed for appliance: " . $appQuery->error);
                }
    
                $appQuery->close();
            }
    
            $conn->close();
            return true;
        } else {
            $query->close();
            $conn->close();
            throw new Exception("Execution failed: " . $query->error);
        }
    }
    
    public static function get_last_inserted_tenant_id() {
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        try {
            // Prepare the SQL query to get the maximum tenID
            $sql = "SELECT MAX(tenID) AS last_id FROM tenant";
            $stmt = $conn->prepare($sql);
    
            // Check if preparation was successful
            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . $conn->error);
            }
    
            // Execute the query
            $stmt->execute();
    
            // Bind the result to a variable
            $stmt->bind_result($last_id);
    
            // Fetch the result
            $stmt->fetch();
    
            // Close the statement
            $stmt->close();
    
            // Close the connection
            $conn->close();
    
            // Return the last inserted tenant ID
            return $last_id;
        } catch (Exception $e) {
            // Handle any errors
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public static function appliance_tenID($appliances, $last_id) {
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        try {
            // Prepare the SQL insert statement with placeholders
            $sql = "INSERT INTO appliance (tenID, appInfo, appRate) VALUES (?, ?, ?)";
    
            // Prepare the statement
            $stmt = $conn->prepare($sql);
            
            // Check if preparation was successful
            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . $conn->error);
            }
    
            // Default value for appRate
            $defaultAppRate = 100.00;
    
            // Loop through each appliance and insert it into the appliance table
            foreach ($appliances as $applianceInfo) {
                // Bind parameters: "i" for integer (tenID), "s" for string (appInfo), "d" for double (appRate)
                $stmt->bind_param("isd", $last_id, $applianceInfo, $defaultAppRate);
    
                // Execute the statement
                if (!$stmt->execute()) {
                    throw new Exception("Execution failed: " . $stmt->error);
                }
            }
    
            // Close the statement
            $stmt->close();
    
            // Close the connection
            $conn->close();
    
            return true; // Return true if insertion is successful
    
        } catch (Exception $e) {
            // Handle any errors
            echo "Error: " . $e->getMessage();
            return false; // Return false if an error occurs
        }
    }

    public static function residents_data(){
        try {
            //connection 
            $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
            
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }
    
            // SQL query to select all tenants
            $query = "SELECT * FROM tenant";
    
            // Execute the query
            $result = $conn->query($query);
    
            if ($result === false) {
                throw new Exception("Query failed: " . $conn->error);
            }
    
            // Fetch all rows as an associative array
            $tenants = [];
            while ($row = $result->fetch_assoc()) {
                $tenants[] = $row;
            }
    
            
            $result->free();
    
            // Close the connection
            $conn->close();
    
            // Return the array of tenants
            return $tenants;
        } catch (Exception $e) {
            
            error_log("Error: " . $e->getMessage(), 3, '/var/log/php_errors.log');
    
            // Return an empty array to indicate failure
            return [];
        }
    }

    public static function edit_tenant($editTenantData, $editAppliances) {
        // Extract tenant ID from the tenant data
        $tenantID = $editTenantData['Edit-tenID'];

        // Establish database connection
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);

        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        // Prepare the UPDATE query for tenant
        $query = $conn->prepare("UPDATE tenant SET 
            tenFname = ?, 
            tenLname = ?, 
            tenMI = ?, 
            tenHouseNum = ?, 
            tenSt = ?, 
            tenBrgy = ?, 
            tenCityMun = ?, 
            tenProvince = ?, 
            tenContact = ?, 
            tenBdate = ?, 
            tenGender = ?, 
            emContactFname = ?, 
            emContactLname = ?, 
            emContactMI = ?, 
            emContactNum = ? 
        WHERE tenID = ?");

        if ($query === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        // Bind parameters to the prepared statement
        $query->bind_param(
            'sssssssssssssssi',
            $editTenantData['Edit-tenFname'], $editTenantData['Edit-tenLname'], $editTenantData['Edit-tenMI'],
            $editTenantData['Edit-tenHouseNum'], $editTenantData['Edit-tenSt'], $editTenantData['Edit-tenBrgy'],
            $editTenantData['Edit-tenCityMun'], $editTenantData['Edit-tenProvince'], $editTenantData['Edit-tenContact'],
            $editTenantData['Edit-tenBdate'], $editTenantData['Edit-tenGender'], $editTenantData['Edit-emContactFname'],
            $editTenantData['Edit-emContactLname'], $editTenantData['Edit-emContactMI'], $editTenantData['Edit-emContactNum'],
            $tenantID
        );

        // Execute the update query
        if (!$query->execute()) {
            throw new Exception("Execution failed: " . $query->error);
        }

        $query->close();

        // Use prepared statement for DELETE operation to prevent SQL injection
        $deleteQuery = $conn->prepare("DELETE FROM appliance WHERE tenID = ?");
        if ($deleteQuery === false) {
            throw new Exception("Prepare failed for DELETE: " . $conn->error);
        }

        $deleteQuery->bind_param('i', $tenantID);
        if (!$deleteQuery->execute()) {
            throw new Exception("Execution failed for DELETE: " . $conn->error);
        }

        $deleteQuery->close();

        // Insert appliances
        foreach ($editAppliances as $appliance) {
            $appInfo = $appliance['appInfo'];
            $appQuery = $conn->prepare("INSERT INTO appliance (tenID, appInfo, appRate) VALUES (?, ?, ?)");

            if ($appQuery === false) {
                throw new Exception("Prepare failed for appliance: " . $conn->error);
            }

            $appRate = 100.00; // assuming a fixed rate, adjust if needed
            $appQuery->bind_param('isd', $tenantID, $appInfo, $appRate);

            if (!$appQuery->execute()) {
                throw new Exception("Execution failed for appliance: " . $appQuery->error);
            }

            $appQuery->close();
        }

        $conn->close();
        return true;
    }

    public static function deleteTenantById($tenantIdToDelete) {
        try {
            // Create a connection to the database
            $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
            // Check for connection errors
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }
    
            // Prepare the DELETE statement with a parameterized query to prevent SQL injection
            $stmt = $conn->prepare("DELETE FROM tenant WHERE tenID = ?");
    
            // Bind the parameter to the statement
            $stmt->bind_param("s", $tenantIdToDelete);
    
            // Execute the statement
            if ($stmt->execute()) {
                // Return true if deletion was successful
                return true;
            } else {
                // Return false or handle the failure as needed
                return false;
            }
    
            // Close the statement
            $stmt->close();
    
            // Close the connection
            $conn->close();
    
        } catch (Exception $e) {
            // Log the error to a file or handle it as needed
            error_log("Error deleting tenant: " . $e->getMessage(), 3, '/var/log/php_errors.log');
    
            // Return false to indicate failure
            return false;
        }
    }

    public static function get_appliances($tenantID){
        try {
            // Create a connection to the database
            $conn = self::get_connection();
    
            // Prepare the SQL query to get all appliances for a specific tenant
            $stmt = $conn->prepare("SELECT * FROM appliance WHERE tenID = ?");
    
            // Bind the tenant ID to the statement
            $stmt->bind_param("i", $tenantID);
    
            // Execute the statement
            $stmt->execute();
    
            // Get the result
            $result = $stmt->get_result();
    
            // Fetch all rows as an associative array
            $appliances = [];
            while ($row = $result->fetch_assoc()) {
                $appliances[] = $row;
            }
    
            // Free the result
            $result->free();
    
            // Close the statement
            $stmt->close();
    
            // Close the connection
            $conn->close();
    
            // Return the array of appliances
            return $appliances;
        } catch (Exception $e) {
            // Log the error to a file or handle it as needed
            error_log("Error getting appliances: " . $e->getMessage(), 3, '/var/log/php_errors.log');
    
            // Return an empty array to indicate failure
            return [];
        }
    }

    public static function get_occupancy($tenantID){
        try {
            // Create a connection to the database
            $conn = self::get_connection();
    
            // Prepare the SQL query to get all appliances for a specific tenant
            $stmt = $conn->prepare("SELECT occTypeName ,roomID,occDateStart,occDateEnd FROM tenant,occupancy,occupancy_type WHERE tenant.tenID = occupancy.tenID AND tenant.tenID = ? AND occupancy.occTypeID = occupancy_type.occTypeID ORDER BY occupancy.occDateStart DESC ");
    
            // Bind the tenant ID to the statement
            $stmt->bind_param("i", $tenantID);
    
            // Execute the statement
            $stmt->execute();
    
            // Get the result
            $result = $stmt->get_result();
    
            // Fetch all rows as an associative array
            $occupancy = [];
            while ($row = $result->fetch_assoc()) {
                $occupancy[] = $row;
            }
    
            // Free the result
            $result->free();
    
            // Close the statement
            $stmt->close();
    
            // Close the connection
            $conn->close();
    
            // Return the array of appliances
            return $occupancy;
        } catch (Exception $e) {
            // Log the error to a file or handle it as needed
            error_log("Error getting appliances: " . $e->getMessage(), 3, '/var/log/php_errors.log');
    
            // Return an empty array to indicate failure
            return [];
        }
    }
}

?>