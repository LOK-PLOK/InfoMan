 <?php
// Start output buffering at the beginning of your script
ob_start();
session_start();

require '../php/templates.php';
require '../views/MaintenanceViews.php';


html_start('maintenance.css');

// Sidebar
require '../php/navbar.php';
MaintenanceViews::burger_sidebar();

// Modals
MaintenanceViews::create_maintenance_modal();
MaintenanceViews::delete_maintenance_modal();
MaintenanceViews::edit_maintenance_modal();

// Headers
MaintenanceViews::maintenance_header();
MaintenanceViews::maintenance_content();

if(isset($_GET['createStatus'])) {
    if ($_GET['createStatus'] == 'success') {
        echo '<script>showSuccessAlert("Maintenance record created successfully!")</script>';
    } else if ($_GET['createStatus'] == 'error') {
        echo '<script>showFailAlert("Failed to create maintenance record!")</script>';
    }
}

if(isset($_GET['editStatus'])) {
    if ($_GET['editStatus'] == 'success') {
        echo '<script>showSuccessAlert("Maintenance record updated successfully!")</script>';
    } else if ($_GET['editStatus'] == 'error') {
        echo '<script>showFailAlert("Failed to update maintenance record!")</script>';
    }
}

if(isset($_GET['deleteStatus'])) {
    if ($_GET['deleteStatus'] == 'success') {
        echo '<script>showSuccessAlert("Maintenance record deleted successfully!")</script>';
    } else if ($_GET['deleteStatus'] == 'error') {
        echo '<script>showFailAlert("Failed to delete maintenance record!")</script>';
    }
}

// POST Requests handling
if ($_SERVER['REQUEST_METHOD'] == "POST") {


    // Handle the create new maintenance form submission
    if (isset($_POST['create-new-maintenance'])) {
        $create_maintenance = array(
            "roomID" => htmlspecialchars($_POST['maintenance-room-code']),
            "maintDate" => htmlspecialchars($_POST['maintDate']),
            "maintStatus" => htmlspecialchars($_POST['maintStatus']),
            "maintDesc" => htmlspecialchars($_POST['maintDesc']),
            "maintCost" => htmlspecialchars($_POST['maintCost'])
            
        );

        $result = MaintenanceController::create_new_maintenance($create_maintenance);

        if ($result) {
            header("Location: /pages/maintenance.php?createStatus=success");
            exit();
        } else {
            header("Location: /pages/maintenance.php?createStatus=error");
            exit();
        }
    }


    // Handle the edit maintenance form submission
    if (isset($_POST["edit-maintenance-submit"])) {
        $edit_maintenance = array(
            "Edit-maintID" => $_POST["Edit-maintID"],
            "Edit-roomID" => $_POST["Edit-roomID"],
            "Edit-maintDate" => $_POST["Edit-maintDate"],
            "Edit-maintStatus" => $_POST["Edit-maintStatus"],
            "Edit-maintDesc" => $_POST["Edit-maintDesc"],
            "Edit-maintCost" => $_POST["Edit-maintCost"],
        );
    
        $result = MaintenanceController::edit_maintenance($edit_maintenance);
        if ($result) {
            header("Location: /pages/maintenance.php?editStatus=success");
            exit();
        } else {
            header("Location: /pages/maintenance.php?editStatus=error");
            exit();
        }
    }


    // Handle the delete maintenance form submission
    if (isset($_POST['delete-maintenance-submit'])) {
        $maintenanceID = $_POST['deleteMaintID'] ?? '';
    
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
}

echo '<script src="../js/maintenance_edit&delete_modal.js"></script>';
echo'<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
';
html_end();
ob_end_flush(); // End output buffering and flush the buffer

?>