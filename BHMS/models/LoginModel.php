<?php

require 'dbcreds.php';

class LoginModel extends dbcreds {

    public static function verify_credentials($user_input) {

        // Use self to access static variables within the static method
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);

        // Check for connection errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the SQL statement
        $query = $conn->prepare("SELECT * FROM user WHERE username = ? AND isDeleted = 0");

        // Check if the statement was prepared successfully
        if ($query === false) {
            die("Prepare failed: " . $conn->error);
        }

        // Bind the parameter
        $query->bind_param('s', $user_input);

        // Execute the statement
        $query->execute();

        // Fetch the result
        $result = $query->get_result()->fetch_assoc();

        // Close the statement and connection
        $query->close();
        $conn->close();

        return $result;
    }
}

?>