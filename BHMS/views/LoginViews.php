<?php

class LoginView {

    public static function login_form() {

        echo ('
            <div class="login-container">
                <form method="POST">
                    <div class="login-header">
                        <img src="/images/MBH_logo.png" alt="">
                        <span>Welcome back! Login to access...</span>
                    </div>
                    <input name="username" type="text" placeholder="Username">
                    <input name="password" type="password" placeholder="Password">
                    <span class="center-login">
                        <input name="login" type="submit" value="Login">
                    </span>
                </form>
            </div>
        ');
 
    }
    
}

?>