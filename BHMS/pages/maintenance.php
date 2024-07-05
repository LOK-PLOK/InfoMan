<?php
// Start output buffering at the beginning of your script
ob_start();
session_start();

require '../php/templates.php';
require '../views/MaintenanceViews.php';

echo '<script src="../js/maintenance_edit&delete_modal.js"></script>';
echo'<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
';
html_start('maintenance.css');

// Sidebar
require '../php/navbar.php';
MaintenanceViews::burger_sidebar();
MaintenanceViews::create_maintenance_modal();
MaintenanceViews::delete_maintenance_modal();
MaintenanceViews::edit_maintenance_modal();

if (isset($_GET["edit-maintenance-submit"])) {
    $edit_maintenance = array(
        "Edit-maintID" => $_GET["Edit-maintID"],
        "Edit-roomID" => $_GET["Edit-roomID"],
        "Edit-maintDate" => $_GET["Edit-maintDate"],
        "Edit-maintStatus" => $_GET["Edit-maintStatus"],
        "Edit-maintDesc" => $_GET["Edit-maintDesc"],
        "Edit-maintCost" => $_GET["Edit-maintCost"],
    );

    // JSON encode the array and log it to the console
    // echo '<script>console.log("Editing maintenance:", ' . json_encode($edit_maintenance) . ');</script>';
    $result = MaintenanceController::edit_maintenance($edit_maintenance);

    header("Location: /pages/maintenance.php");
    exit();
}
?>

<!-- Header -->
<?php
MaintenanceViews::maintenance_header();
MaintenanceViews::maintenance_content();
?>
    
<?php
html_end();
ob_end_flush(); // End output buffering and flush the buffer

if (isset($_GET['delete-maintenance-submit'])) {
    $maintenanceID = $_GET['deleteMaintID'] ?? '';

    // Handle your deletion logic here using MaintenanceController::deleteMaintenanceById($maintenanceID);
    $result = MaintenanceController::deleteMaintenanceById($maintenanceID);

    // Example response based on your controller logic
    if ($result) {
        header("Location: /pages/maintenance.php?deleteStatus=success");
        exit();
    } else {
        header("Location: /pages/maintenance.php?deleteStatus=error");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['create-new-maintenance'])) {
        $create_maintenance = array(
            "roomID" => htmlspecialchars($_POST['maintenance-room-code']),
            "maintDate" => htmlspecialchars($_POST['maintDate']),
            "maintStatus" => htmlspecialchars($_POST['maintStatus']),
            "maintDesc" => htmlspecialchars($_POST['maintDesc']),
            "maintCost" => htmlspecialchars($_POST['maintCost'])
            
        );
        echo '<script>console.log(' . json_encode($create_maintenance) . ');</script>';
        $result = MaintenanceController::create_new_maintenance($create_maintenance);
        if ($result) {
            echo '<script>console.log("New maintenance added successfully")</script>';
        } else {
            echo '<script>console.log("Error")</script>';
        }

        // Output the contents of $create_rent for debugging
        echo '<script>console.log(' . json_encode($create_maintenance) . ');</script>';
    }
    
    // After handling the form submission, redirect to avoid form resubmission
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit(); // Make sure to exit after redirect

}

?>