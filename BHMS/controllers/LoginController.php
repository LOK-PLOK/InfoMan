<?php

require './models/LoginModel.php';

class LoginController {

    public static function login_validation($username, $password) {
        $result = LoginModel::verify_credentials($username);

        if($result !== NULL && password_verify($password, $result['password'])) {
            
            if($result['isDeleted'] == 1) {
                echo '<script>alert("User account is already deleted!")</script>';
                return;
            } else if ($result['isActive'] == 0) {
                echo '<script>alert("User account is inactive!")</script>';
                return;
            } else {
                $_SESSION['userID'] = $result['userID'];
                $_SESSION['sessionType'] = $result['userType'];
                header('Location: pages/dashboard.php');
                exit();
            }

        } else {
            echo '<script>alert("Invalid User Credentials!")</script>';
        }
    }
}

?>  