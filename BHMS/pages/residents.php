<?php
  
// $filePath = __FILE__;
// echo "The file path is: $filePath";

session_start();

require '../php/templates.php';
require '../views/ResidentsViews.php';
echo '<script src="../js/residents_edit_modal.js"></script>';


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
    
}
?>

    <?php
    $tenant_list = ResidentsController::residents_table_data();
    ResidentsViews::residents_table_display($tenant_list);
    

    //Test
    $json_tenant_list = json_encode($tenant_list);

    // Log the data to the console using JavaScript
    echo '<script>console.log("Tenant List:", ' . $json_tenant_list . ')</script>';

    if ($tenant_list) {
        echo '<script>console.log("Tenant added successfully")</script>';
    } else {
        echo '<script>console.log("Error")</script>';
    }
    ?>
    
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
    
        $result = ResidentsController::edit_tenant($edit_tenant,$tenID);
        if ($result) {
            echo '<script>console.log("Tenant added successfully")</script>';
        } else {
            echo '<script>console.log("Error")</script>';
        }
        //  // After processing, redirect to the same page or another page
        //  header('Location: ' . $_SERVER['REQUEST_URI']); // Redirect to the current page
        //  exit();
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
    
        $result = ResidentsController::edit_tenant($edit_tenant,$tenID);
        if ($result) {
            echo '<script>console.log("Edited added successfully")</script>';
        } else {
            echo '<script>console.log("Error")</script>';
        }
        //  // After processing, redirect to the same page or another page
        //  header('Location: ' . $_SERVER['REQUEST_URI']); // Redirect to the current page
        //  exit();
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
}
?>
    

<!-- Add Tenant Modal Revision-------------- -->
<!-- Na remove na and nasa ResidentsViews -->

<!-- Tenant Information Modal-------------- -->
<!-- Na remove na and nasa ResidentsViews -->

<!-- Edit Tenant Modal Revision-------------- -->
<!-- Na remove na and nasa ResidentsViews -->

<!-- Delete Modal Revision-------------- -->


<?php html_end(); ?>