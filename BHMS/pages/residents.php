<?php
// Start output buffering at the beginning of your script
ob_start();
session_start();

require '../php/templates.php';
require '../views/ResidentsViews.php';

echo '<script src="../js/residents_edit&delete_modal.js"></script>';

html_start('residents.css');

// Sidebar
require '../php/navbar.php';

// Hamburger Sidebar
ResidentsViews::burger_sidebar();

?>

<!-- Residents Contents -->
<div class="container-fluid">

<?php
ResidentsViews::residents_header();

/** For the Add tenant */
ResidentsViews::add_tenant_model_view();

if (isset($_POST['create-tenant-submit'])) {
    $new_tenant = array(
        "tenFname" => $_POST['tenFname'],
        "tenMI" => $_POST['tenMI'],
        "tenLname" => $_POST['tenLname'],
        "tenGender" => $_POST['tenGender'],
        "tenBdate" => $_POST['tenBdate'],
        "tenHouseNum" => $_POST['tenHouseNum'],
        "tenSt" => $_POST['tenSt'],
        "tenBrgy" => $_POST['tenBrgy'],
        "tenCityMun" => $_POST['tenCityMun'],
        "tenProvince" => $_POST['tenProvince'],
        "tenContact" => $_POST['tenContact'],
        "emContactFname" => $_POST['emContactFname'],
        "emContactMI" => $_POST['emContactMI'],
        "emContactLname" => $_POST['emContactLname'],
        "emContactNum" => $_POST['emContactNum']
    );

    $result = ResidentsController::create_new_tenant($new_tenant);
    if ($result) {
        echo '<script>console.log("Tenant added successfully")</script>';
    } else {
        echo '<script>console.log("Error")</script>';
    }

    // After handling the form submission, redirect to avoid form resubmission
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit(); // Make sure to exit after redirect
}
?>

<!-- For EDIT -->
<?php
if (isset($_POST['edit-tenant-submit'])) {
    $edit_tenant = array(
        "Edit-tenFname" => $_POST['Edit-tenFname'],
        "Edit-tenMI" => $_POST['Edit-tenMI'],
        "Edit-tenLname" => $_POST['Edit-tenLname'],
        "Edit-tenGender" => $_POST['Edit-tenGender'],
        "Edit-tenBdate" => $_POST['Edit-tenBdate'],
        "Edit-tenHouseNum" => $_POST['Edit-tenHouseNum'],
        "Edit-tenSt" => $_POST['Edit-tenSt'],
        "Edit-tenBrgy" => $_POST['Edit-tenBrgy'],
        "Edit-tenCityMun" => $_POST['Edit-tenCityMun'],
        "Edit-tenProvince" => $_POST['Edit-tenProvince'],
        "Edit-tenContact" => $_POST['Edit-tenContact'],
        "Edit-emContactFname" => $_POST['Edit-emContactFname'],
        "Edit-emContactMI" => $_POST['Edit-emContactMI'],
        "Edit-emContactLname" => $_POST['Edit-emContactLname'],
        "Edit-emContactNum" => $_POST['Edit-emContactNum']
    );

    $tenID = $_GET['tenID'];
    $result = ResidentsController::edit_tenant($edit_tenant, $tenID);

    if ($result) {
        echo '<script>console.log("Tenant edited successfully")</script>';
    } else {
        echo '<script>console.log("Error")</script>';
    }

    // Redirect to avoid form resubmission and duplicate entries
    header("Location: /pages/residents.php");
    exit();
}
?>

<!-- For DELETE-->
<?php
// Check if form was submitted for deleting a tenant
if (isset($_POST['delete-tenant-submit'])) {
    // Retrieve the tenant ID to delete
    $tenantIdToDelete = $_GET['tenID'];
    $result = ResidentsController::deleteTenantById($tenantIdToDelete);

    if ($result) {
        echo '<script>console.log("Deleted successfully")</script>';
    } else {
        echo '<script>console.log("Error")</script>';
    }

    // Redirect to avoid form resubmission and to refresh the page
    header("Location: /pages/residents.php");
    exit();
}
?>

<!-- Display Tenant Table and Other Content -->
<?php
$tenant_list = ResidentsController::residents_table_data();
ResidentsViews::residents_table_display($tenant_list);

// Test: Log tenant list to console
$json_tenant_list = json_encode($tenant_list);
echo '<script>console.log("Tenant List:", ' . $json_tenant_list . ')</script>';

if ($tenant_list) {
    echo '<script>console.log("Tenant list fetched successfully")</script>';
} else {
    echo '<script>console.log("Error fetching tenant list")</script>';
}

html_end();
?>

<?php
// End output buffering and flush the buffer
ob_end_flush();
?>
