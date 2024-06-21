<?php
    require '../php/templates.php';
    html_start('settings.css');
?>

<!-- Sidebar -->
<?php require '../php/navbar.php'; ?>

<!-- Burger Sidebar -->
<div class="hamburger-sidebar">
    <i class="fa-solid fa-bars"></i>
</div>

<!-- Room Logs Section -->
<div class="container-fluid">

    <!-- Header -->
    <div class="settings-header" >
        <span class="page-header">Settings</span><br>
        <span style="color:#5f5f5f;">View and manage settings to the business</span>
    </div>
    
    <div class="user-profile shadow">
        <span class="user-name">Juan Jihyo De los Santos</span><br>
        <span class="user-type">Admin</span>
    </div>

    <div class="rate-price-cont shadow">
        <div>
            <img src="/images/icons/Settings/rates_and_pricing.png" alt="">
            <span>Rates and Pricing</span>
        </div>
        <i class="fa-solid fa-angle-right" style="color: #344799;"></i>
    </div>
    
    <!-- Login Settings Actual -->
    <div class="login-sett-cont">
        <div class="settings-sub-header" >
            <div>
                <span class="page-header" style="font-size: 30px;">Login Settings</span><br>
                <span style="color:#5f5f5f;">Change your username and password for enhanced security measures.</span>
            </div>
        </div>
        <div class="edit-acc-cont">
            <button class="save-btn btn-var-1 shadow">Save Changes</button>
            <label for="ch-username">Username</label><br>
            <div class="input-cont">
                <input type="text" id="ch-username" placeholder="AdminThingz1">
                <a href="">edit</a>
            </div>
            <hr>
            <label for="ch-password">Password</label><br>
            <div class="input-cont">
                <input type="password" id="ch-password" placeholder="***********"><br>
                <a href="">edit</a>
            </div>
            <button class="sign-out-btn btn-var-2 shadow">Sign-out</button>
        </div>
    </div>
</div>

<script src="/js/general.js"></script>
    
<?php html_end(); ?>