<?php
// Define the current page
$current_page = basename($_SERVER['PHP_SELF'], ".php");

// Set the active class for each menu item based on the current page
function setActiveClass($page_name, $current_page) {
    return $page_name === $current_page ? 'class-align-tabs-active' : '';
}

// Set the active icon for each menu item based on the current page
function setActiveIcon($page_name, $current_page) {
    return $page_name === $current_page ? 'light' : 'dark';
}

if (isset($_GET['logout'])) {
    session_start();
    session_destroy();
    header('Location: /index.php');
}

if (!isset($_SESSION['userID'])) {
    header('Location: /index.php');
}

?>

<nav class="off-screen-menu">
    <!-- Logo -->
    <div class="bh-logo">
        <img src="/images/MBH_logo.png" width="150px">
    </div>
    <!-- Navigation Tabs -->
    <div class="navigation-tabs">
        <a href="dashboard.php">
            <div class="class-align-tabs <?php echo setActiveClass('dashboard', $current_page); ?>">
                <img src="/images/icons/Dashboard/Navigation Bar/dashboard_<?php echo setActiveIcon('dashboard', $current_page); ?>.png">
                <h3 class="paddingleft">Dashboard</h3>
            </div>
        </a>
        <a href="statistics.php">
            <div class="class-align-tabs <?php echo setActiveClass('statistics', $current_page); ?>">
                <img src="/images/icons/Dashboard/Navigation Bar/statistics_<?php echo setActiveIcon('statistics', $current_page); ?>.png">
                <h3 class="paddingleft">Statistics</h3>
            </div>
        </a>
        <a href="residents.php">
            <div class="class-align-tabs <?php echo setActiveClass('residents', $current_page); ?>">
                <img src="/images/icons/Dashboard/Navigation Bar/residents_<?php echo setActiveIcon('residents', $current_page); ?>.png">
                <h3 class="paddingleft">Residents</h3>
            </div>
        </a>
        <a href="room_logs.php">
            <div class="class-align-tabs <?php echo setActiveClass('room_logs', $current_page); ?>">
                <img src="/images/icons/Dashboard/Navigation Bar/room_logs_<?php echo setActiveIcon('room_logs', $current_page); ?>.png">
                <h3 class="paddingleft">Room Logs</h3>
            </div>
        </a>
        <a href="billings.php">
            <div class="class-align-tabs <?php echo setActiveClass('billings', $current_page); ?>">
                <img src="/images/icons/Dashboard/Navigation Bar/billing_<?php echo setActiveIcon('billings', $current_page); ?>.png">
                <h3 class="paddingleft">Billings</h3>
            </div>
        </a>
        <a href="maintenance.php">
            <div class="class-align-tabs <?php echo setActiveClass('maintenance', $current_page); ?>">
                <img src="/images/icons/Dashboard/Navigation Bar/maintenance_<?php echo setActiveIcon('maintenance', $current_page); ?>.png">
                <h3 class="paddingleft">Maintenance</h3>
            </div>
        </a>
        <a href="settings.php">
            <div class="class-align-tabs <?php echo setActiveClass('settings', $current_page); ?>">
                <img src="/images/icons/Dashboard/Navigation Bar/setting_<?php echo setActiveIcon('settings', $current_page); ?>.png">
                <h3 class="paddingleft">Settings</h3>
            </div>
        </a>
    </div>
    <!-- Sign-out Button -->
    <div class="sign-out">
        <a href="?logout=1">
            <div class="class-align-tabs">
                <img src="/images/icons/Dashboard/Navigation Bar/logout.png">
                <h3 class="paddingleft" style="color: white">Sign out</h3>
            </div>
        </a>
    </div>
</nav>
