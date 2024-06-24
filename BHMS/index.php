<?php
    session_start();

    if(isset($_SESSION['userID'])){
        header('Location: pages/dashboard.php');
        exit();
    }

    require_once 'php/templates.php';
    require_once 'views/LoginViews.php';
    require_once 'controllers/LoginController.php';

    // Render HTML Head
    html_start('login.css');

    // Displays the Login Form
    LoginView::login_form();

    // Form Submission Handler
    if (isset($_POST['login'])) {
 
        $username = $_POST['username'];
        $password = $_POST['password'];

        LoginController::login_validation($username, $password);

    }

    // Render HTML End
    html_end();
?>

