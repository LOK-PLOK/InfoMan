<?php

require './models/LoginModel.php';

class LoginController {

    public static function login_validation($username, $password) {

        $result = LoginModel::verify_credentials($username);

        if($result !== NULL && $result['password'] === $password) {
            $_SESSION['userID'] = $result['userID'];
            header('Location: pages/dashboard.php');
            exit();
        } else {
            echo '<script>alert("Invalid User Credentials!")</script>';
        }
    }
}

?>  