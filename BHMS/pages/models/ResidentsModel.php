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

    public static function add_new_tenant($new_tenant) {
        try {
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
    
            if (!$query->execute()) {
                throw new Exception("Execute failed: " . $query->error);
            }
    
            $query->close();
            $conn->close();
    
            return true; // Return true if insertion was successful
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage(), 3, '/var/log/php_errors.log');
            return false; // Return false if an error occurred
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

    public static function appliance_data(){
        try {
            //connection 
            $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
            
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }
    
            // SQL query to select all appliance
            $query = "SELECT * FROM appliance";
    
            // Execute the query
            $result = $conn->query($query);
    
            if ($result === false) {
                throw new Exception("Query failed: " . $conn->error);
            }
    
            // Fetch all rows as an associative array
            $tenants = [];
            while ($row = $result->fetch_assoc()) {
                $appliance[] = $row;
            }
    
            
            $result->free();
    
            // Close the connection
            $conn->close();
    
            // Return the array of appliance
            return $appliance;
        } catch (Exception $e) {
            
            error_log("Error: " . $e->getMessage(), 3, '/var/log/php_errors.log');
    
            // Return an empty array to indicate failure
            return [];
        }
    }

    public static function edit_tenant($edit_tenant, $tenID) {
        try {
            // Create a connection to the database
            $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
    
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }
    
            // Prepare the SQL UPDATE query
            $query = "UPDATE tenant SET 
                tenFname = ?, 
                tenMI = ?, 
                tenLname = ?, 
                tenGender = ?, 
                tenBdate = ?, 
                tenHouseNum = ?, 
                tenSt = ?, 
                tenBrgy = ?, 
                tenCityMun = ?, 
                tenProvince = ?, 
                tenContact = ?, 
                emContactFname = ?, 
                emContactMI = ?, 
                emContactLname = ?, 
                emContactNum = ?
                WHERE tenID = ?";
    
            // Prepare the statement
            $stmt = $conn->prepare($query);
    
            // Check if the statement was prepared successfully
            if (!$stmt) {
                throw new Exception("Preparation failed: " . $conn->error);
            }
    
            // Bind the parameters from the $edit_tenant array
            $stmt->bind_param(
                'sssssssssssssssi', 
                $edit_tenant['Edit-tenFname'],
                $edit_tenant['Edit-tenMI'],
                $edit_tenant['Edit-tenLname'],
                $edit_tenant['Edit-tenGender'],
                $edit_tenant['Edit-tenBdate'],
                $edit_tenant['Edit-tenHouseNum'],
                $edit_tenant['Edit-tenSt'],
                $edit_tenant['Edit-tenBrgy'],
                $edit_tenant['Edit-tenCityMun'],
                $edit_tenant['Edit-tenProvince'],
                $edit_tenant['Edit-tenContact'],
                $edit_tenant['Edit-emContactFname'],
                $edit_tenant['Edit-emContactMI'],
                $edit_tenant['Edit-emContactLname'],
                $edit_tenant['Edit-emContactNum'],
                $tenID
            );
    
            // Execute the statement
            if (!$stmt->execute()) {
                throw new Exception("Execution failed: " . $stmt->error);
            }
    
            // Check if the update was successful
            if ($stmt->affected_rows === 0) {
                throw new Exception("No records updated. Please check if the tenant ID exists.");
            }

            return true;
            } catch (Exception $e) {
                // error_log("Error: " . $e->getMessage(), 3, '/var/log/php_errors.log');
        
                // Return false to indicate failure
                return false;
            }

        
    
            // Close the statement and connection
            $stmt->close();
            $conn->close();

            
    
            // Return true to indicate success
        //     return true;
        // } catch (Exception $e) {
        //     // error_log("Error: " . $e->getMessage(), 3, '/var/log/php_errors.log');
    
        //     // Return false to indicate failure
        //     return false;
        // }
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
}

?>