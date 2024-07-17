<?php

/**
 * This class contains all the views that are used in the login page.
 * 
 * @method login_form
 * @class LoginView
 */
class LoginView {

    /**
     * This method is used to display the login form.
     * 
     * @method login_form
     * @return void
     */
    public static function login_form() {
        echo <<<HTML
            <div class="login-container">
                <form method="POST">
                    <div class="login-header">
                        <img src="/images/MBH_logo.png" alt="">
                        <span>Welcome back! Login to access...</span>
                    </div>
                    <input name="username" type="text" class="login-field" placeholder="Username">
                    <input name="password" type="password" class="login-field" placeholder="Password">
                    <span class="center-login">
                        <input name="login" type="submit" class="login-submit" value="Login">
                    </span>
                </form>
            </div>
        HTML;
    }
    
}

?>