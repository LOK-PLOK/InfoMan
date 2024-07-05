<?php   
  ob_start();
  session_start();

  require '../php/templates.php';
  require '../views/SettingsViews.php';

  html_start('settings.css');

  // Sidebar
  require '../php/navbar.php';

  //Burger Sidebar
  SettingsViews::burger_sidebar();
?>

<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Prepare data for insertion into database
    if(isset($_POST['create-user-submit'])){
        $new_user = [
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'userFname' => $_POST['userFname'],
            'userLname' => $_POST['userLname'],
            'userMname' => $_POST['userMname'],
            'userType' => $_POST['userType'],
            'isActive' => $_POST['isActive']
        ];

        // Call create_user method from settingsmodel.php
        $result = SettingsController::create_new_user($new_user);
        if ($result) {
            // Return success response (if using AJAX)
            header('Location: /pages/settings.php?addUser=success');
            exit();
        } else {
            // Return error response (if using AJAX)
            header('Location: /pages/settings.php?addUser=error');
            exit();
        }

    }

    // Check if form was submitted for deleting a user
    if (isset($_POST['deleteUserInfoSubmit'])) {
        
        // Retrieve the tenant ID to delete
        $tenantIdToDelete = $_POST['deleteUserID'];

        $result = SettingsController::delete_user_by_id($tenantIdToDelete);

        if ($result) {
            header("Location: /pages/settings.php?deleteUser=success");
            exit();
        } else {
            header("Location: /pages/settings.php?deleteUser=error");
            exit();
        }
    }

    // Check if form was submitted for editing a user
    if(isset($_POST['edit-confirm'])){
        $edit_user = [
            'userID' => $_POST['Edit-userID'],
            'username' => $_POST['Edit-userName'],
            'password' => $_POST['Edit-password'],
            'userFname' => $_POST['Edit-userFname'],
            'userLname' => $_POST['Edit-userLname'],
            'userMname' => $_POST['Edit-userMname'],
            'userType' => $_POST['Edit-userType'],
            'isActive' => $_POST['Edit-isActive']
        ];
        

        // Call create_user method from settingsmodel.php
        $result = SettingsController::edit_user($edit_user);
        if ($result) {
            // Return success response (if using AJAX)
            header('Location: /pages/settings.php?editUser=success');
            exit(); 
        } else {
            // Return error response (if using AJAX)
            header('Location: /pages/settings.php?editUser=error');
            exit();
        }
    }

    // Check if form was submitted for editing rates and pricing
    if(isset($_POST['edit-rate-pricing'])){
        
        $appRate = $_POST['ApplianceRate'];

        $occRates =[
            ['occTypeID' => $_POST['bedRateID'], 'occRate' => $_POST['bedRate']],
            ['occTypeID' => $_POST['roomRate1ID'], 'occRate' => $_POST['roomOne']],
            ['occTypeID' => $_POST['roomRate2ID'], 'occRate' => $_POST['roomTwo']], 
            ['occTypeID' => $_POST['roomRate3ID'], 'occRate' => $_POST['roomThree']],
            ['occTypeID' => $_POST['roomRate4ID'], 'occRate' => $_POST['roomFour']]
        ];

        $result = SettingsController::edit_rates_and_pricing($appRate, $occRates);
        if ($result) {
            header('Location: /pages/settings.php?editRate=success');
            exit();
        } else {
            header('Location: /pages/settings.php?editRate=error');
            exit();
        }
    }
    
}
?> 

<div class="container-fluid">

<?php
    SettingsViews::settings_header();
    SettingsViews::user_info_section();
?>

    <!--sections-->
    <div class="section">
        <button class="rate-price-cont shadow" data-bs-toggle="modal" data-bs-target="#ratesAndPricingModal">
            <img src="/images/icons/Settings/rates_and_pricing.png" alt="rates and pricing icon">
            <span>Rates and Pricing</span>
            <i class="fa-solid fa-angle-right"></i>
        </button>

        <button class="rate-price-cont shadow" data-bs-toggle="modal" data-bs-target="#userInfoModal">
            <img src="/images/icons/Settings/user_info_dark.png" alt="user information icon">
            <span>User Information</span>
            <i class="fa-solid fa-angle-right"></i>
        </button>

        <button class="rate-price-cont shadow" data-bs-toggle="modal" data-bs-target="#createUserModal">
            <img src="/images/icons/Settings/add_user_dark.png" alt="add user icon">
            <span>Create User</span>
            <i class="fa-solid fa-angle-right"></i>
        </button>
    </div>

    <div class="login-sett-cont">
        <div class="settings-sub-header">
            <button class="sign-out-btn btn-var-2 shadow">Sign-out</button>
        </div>
    </div>

<?php
    //rates and pricing modal
    SettingsViews::rates_and_pricing_model_view();

    //user information modal
    $user_list = SettingsController::users_table_data();
    SettingsViews::user_information_model_view($user_list);

    // Test: Log user list to console
    $json_user_list = json_encode($user_list);

    if ($user_list) {
      echo '<script>console.log("User list fetched successfully")</script>';
    } else {
      echo '<script>console.log("Error fetching user list")</script>';
    }

    //create user info modal
    SettingsViews::create_user_info_model_view();

    //edit user info
    SettingsViews::edit_user_info();

    //delete user info
    SettingsViews::delete_user_info();
?>
   
</div>

<script src="/js/general.js"></script>
<script src="../js/settings.js"></script>


<?php 
ob_end_flush();
html_end(); 
?>