<?php

require 'dbcreds.php'; 

class SettingsModel extends dbcreds{

    //user info display
    public static function verify_user(){
        $conn = self::get_connection();

        $query = $conn->prepare("SELECT * FROM user WHERE userID = ?");

        if ($query === false) {
            die("Prepare failed: " . $conn->error);
        }

        $query->bind_param('s', $user_input);

        $query->execute();

        $result = $query->get_result()->fetch_assoc();

        $query->close();
        $conn->close();

        return $result;
    }

    //fetching rates (rates and pricing modal)
    public static function fetchRates() {
        $conn = self::get_connection();

        $query = "SELECT * FROM occupancy_type";
        $result = $conn->query($query);

        if ($result === false) {
            throw new Exception("Query failed: " . $conn->error);
        }

        $occupancyRates = [];
        while ($row = $result->fetch_assoc()) {
            $occupancyRates[] = $row;
        }

        return $occupancyRates;
    }

    //create user modal
    public static function create_user($new_user) {
        try {
            $conn = self::get_connection();

            $query = $conn->prepare("INSERT INTO user (
                username, 
                password, 
                userFname, 
                userLname, 
                userMI, 
                userType, 
                isActive
            ) VALUES (?, ?, ?, ?, ?, ?, ?);");

            if ($query === false) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            // Hash Password
            $hashed_password = password_hash($new_user['password'], PASSWORD_DEFAULT);

            // Bind the parameters
            $query->bind_param(
                'ssssssi', // 'i' for integer (isActive)
                $new_user['username'], 
                $hashed_password, 
                $new_user['userFname'], 
                $new_user['userLname'], 
                $new_user['userMI'], 
                $new_user['userType'], 
                $new_user['isActive']
            );

            if (!$query->execute()) {
                throw new Exception("Execute failed: " . $query->error);
            }

            $query->close();
            $conn->close();

            return true;
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage(), 3, '/var/log/php_errors.log');
            return false;
        }
    }

    //edit user (user information modal)
    public static function edit_user($edit_user) {
        try {
            $conn = self::get_connection();
    
            $query = "UPDATE user SET 
                username = ?, 
                userFname = ?, 
                userLname = ?, 
                userMI = ?, 
                userType = ?, 
                isActive = ?
                WHERE userID = ?";
    
            $stmt = $conn->prepare($query);
    
            if (!$stmt) {
                throw new Exception("Preparation failed: " . $conn->error);
            }
    
            $stmt->bind_param(
                'sssssii', 
                $edit_user['username'],
                $edit_user['userFname'],
                $edit_user['userLname'],
                $edit_user['userMI'],
                $edit_user['userType'],
                $edit_user['isActive'],
                $edit_user['userID'],
            );
    
            if (!$stmt->execute()) {
                throw new Exception("Execution failed: " . $stmt->error);
            }
    
            if ($stmt->affected_rows === 0) {
                throw new Exception("No records updated. Please check if the user ID exists.");
            }

            $stmt->close();
            $conn->close();

            return true;
        } catch (Exception $e) {
            // error_log("Error: " . $e->getMessage(), 3, '/var/log/php_errors.log');
            return false;
        }
    }

    //delete user (user information modal)
    public static function delete_user($userIdToDelete) {
        try {
            
            $conn = self::get_connection();

            $stmt = $conn->prepare("DELETE FROM user WHERE userID = ?");

            if ($stmt === false) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("i", $userIdToDelete);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            error_log("Error deleting user: " . $e->getMessage(), 3, '/var/log/php_errors.log');
            return false;
        }
    }

    public static function users_data(){
        try {
            //connection 
            $conn = self::get_connection();
    
            // SQL query to select all tenants
            $query = "SELECT * FROM user";
    
            // Execute the query
            $result = $conn->query($query);
    
            if ($result === false) {
                throw new Exception("Query failed: " . $conn->error);
            }
    
            // Fetch all rows as an associative array
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
    
            $result->free();
    
            // Close the connection
            $conn->close();
    
            // Return the array of tenants
            return $users;
        } catch (Exception $e) {
            
            error_log("Error: " . $e->getMessage(), 3, '/var/log/php_errors.log');
    
            // Return an empty array to indicate failure
            return [];
        }
    }

    

    // Fetching appliance rate (rates and pricing modal)
    public static function fetchApplianceRate() {
        try {
            // Create a connection to the database
            $conn = self::get_connection();

            // Prepare the SQL query to get the default value of the appRate column
            $stmt = $conn->prepare("
               SELECT * FROM appliance_rate_defaults;
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

    // Updating appliance rate (rates and pricing modal)
    public static function updateApplianceRate($new_rate){
        try {
            // Create a connection to the database
            $conn = self::get_connection();

            // Prepare the SQL query to alter the appliance rate column
            $alter_query = "ALTER TABLE appliance CHANGE appRate appRate DECIMAL(7,2) NOT NULL DEFAULT ?";
            $stmt = $conn->prepare($alter_query);

            // Bind the parameter and execute the statement
            $stmt->bind_param('d', $new_rate);
            $stmt->execute();

            // Close the statement
            $stmt->close();

            // Prepare the SQL query to update the appliance rate
            $update_all_rates = "UPDATE appliance SET appRate = ?";
            $stmt = $conn->prepare($update_all_rates);

            // Bind the parameter and execute the statement
            $stmt->bind_param('d', $new_rate);
            $stmt->execute();

            // Close the statement
            $stmt->close();

            // Close the connection
            $conn->close();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }


    //updating occupancy rate (rates and pricing modal)
    public static function updateOccupancyRates($new_rates) {
        try {
            // Create a connection to the database
            $conn = self::get_connection();

            // Prepare the SQL query to update the occupancy rates
            $stmt = $conn->prepare("UPDATE occupancy_type SET occRate = ? WHERE occTypeID = ?");

            // Loop through the new rates
            foreach ($new_rates as $rate) {
                // Bind the parameters
                $stmt->bind_param('di', $rate['occRate'], $rate['occTypeID']);

                // Execute the statement
                $stmt->execute();
            }

            // Close the statement
            $stmt->close();

            // Close the connection
            $conn->close();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function verify_credentials($userID) {

        $conn = self::get_connection();

        // Prepare the SQL statement
        $query = $conn->prepare("SELECT * FROM user WHERE userID = ?");

        // Check if the statement was prepared successfully
        if ($query === false) {
            die("Prepare failed: " . $conn->error);
        }

        // Bind the parameter
        $query->bind_param('i', $userID);

        // Execute the statement
        $query->execute();

        // Fetch the result
        $result = $query->get_result()->fetch_assoc();

        // Close the statement and connection
        $query->close();
        $conn->close();

        return $result;
    }

    public static function changePassword($newData) {
        try {
            $conn = self::get_connection();

            // Prepare the SQL statement
            $stmt = $conn->prepare("UPDATE user SET password = ? WHERE userID = ?");

            // Check if the statement was prepared successfully
            if ($stmt === false) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            // Hash the new password
            $hashed_password = password_hash($newData['newPassword'], PASSWORD_DEFAULT);

            // Bind the parameters
            $stmt->bind_param('si', $hashed_password, $newData['edit-pass-userID']);

            // Execute the statement
            $stmt->execute();

            // Check if the statement was executed successfully
            if ($stmt->affected_rows === 0) {
                throw new Exception("No records updated. Please check if the user ID exists.");
            }

            // Close the statement and connection
            $stmt->close();
            $conn->close();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}
?>