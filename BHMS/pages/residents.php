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
ResidentsViews::add_tenant_modal_view();
// For the Edit Tenant
ResidentsViews::edit_tenant_modal_view();

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

if ($tenant_list) {
    echo '<script>console.log("Tenant list fetched successfully")</script>';
} else {
    echo '<script>console.log("Error fetching tenant list")</script>';
}

?>

<?php 

if (isset($_POST['create-tenant-submit'])) {
    $newTenant = [
        'tenFname' => $_POST['tenFname'],
        'tenMI' => $_POST['tenMI'],
        'tenLname' => $_POST['tenLname'],
        'tenHouseNum' => $_POST['tenHouseNum'],
        'tenSt' => $_POST['tenSt'],
        'tenBrgy' => $_POST['tenBrgy'],
        'tenCityMun' => $_POST['tenCityMun'],
        'tenProvince' => $_POST['tenProvince'],
        'tenContact' => $_POST['tenContact'],
        'tenBdate' => $_POST['tenBdate'],
        'tenGender' => $_POST['tenGender'],
        'emContactFname' => $_POST['emContactFname'],
        'emContactLname' => $_POST['emContactLname'],
        'emContactMI' => $_POST['emContactMI'],
        'emContactNum' => $_POST['emContactNum']
    ];

    $appliances = [];
    foreach($_POST['appliances'] as $appliance){
        $appliances[] = ['appInfo' => $appliance];
    }
    
    $result1 = ResidentsController::create_new_tenant($new_tenant);
    $last_id = ResidentsController::get_last_inserted_tenant_id() + 1;
    $result2 = ResidentsController:: appliance_tenID($appliances,$last_id);
    
    if ($result) {
        echo '<script>console.log("Tenant added successfully")</script>';
    } else {
        echo '<script>console.log("Error")</script>';
    }


    $result = ResidentsController::create_new_tenant($newTenant, $appliances);
    if($result){
        echo '<script>console.log("Tenant added successfully")</script>';
    } else {
        echo '<script>console.log("Error adding tenant")</script>';
    }
    header("Location: /pages/residents.php");
    exit();
}
if (isset($_POST['edit-tenant-submit'])) {
    $edit_tenant = array(
        "Edit-tenID" => $_POST['Edit-tenID'],
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

    $editAppliances = [];
    foreach($_POST['edit-appliances'] as $appliance){
        $editAppliances[] =['appInfo' => $appliance];
    }
    
    $result = ResidentsController::edit_tenant($edit_tenant,$editAppliances);

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

<script>

    function showTenantData(appliance_array, tenantData){

        console.log('Appliance Array:', appliance_array);
        console.log('Tenant Data:', tenantData);

        const editAppliances = document.getElementById('Edit-applianceContainer');
        editAppliances.innerHTML = '';

        // Display the tenant data
        document.getElementById('Edit-tenID').value = tenantData.tenID;
        document.getElementById('Edit-tenFname').value = tenantData.tenFname;
        document.getElementById('Edit-tenMI').value = tenantData.tenMI;
        document.getElementById('Edit-tenLname').value = tenantData.tenLname;
        document.getElementById('Edit-tenGender').value = tenantData.tenGender;
        document.getElementById('Edit-tenBdate').value = tenantData.tenBdate;
        document.getElementById('Edit-tenHouseNum').value = tenantData.tenHouseNum;
        document.getElementById('Edit-tenSt').value = tenantData.tenSt;
        document.getElementById('Edit-tenBrgy').value = tenantData.tenBrgy;
        document.getElementById('Edit-tenCityMun').value = tenantData.tenCityMun;
        document.getElementById('Edit-tenProvince').value = tenantData.tenProvince;
        document.getElementById('Edit-tenContact').value = tenantData.tenContact;
        document.getElementById('Edit-emContactFname').value = tenantData.emContactFname;
        document.getElementById('Edit-emContactMI').value = tenantData.emContactMI;
        document.getElementById('Edit-emContactLname').value = tenantData.emContactLname;
        document.getElementById('Edit-emContactNum').value = tenantData.emContactNum;
        
    
        appliance_array.forEach((appliance, index) => {
            const applianceDiv = document.createElement('div');
            applianceDiv.style = "margin-bottom: 5px;";
            applianceDiv.innerHTML = `
                <input type="text" class="appliance shadow" name="edit-appliances[]" value="${appliance.appInfo}" required>
                <button type="button" class="deleteButton" onclick="edit_deleteAppliance(this)" style ="background: none; border: medium; margin-left: 10px;">
                <img class="deleteapplinace" src="/images/icons/Residents/delete.png" alt="Delete" style="width: 30px !important;  height: 30px !important;"></button>
            `;
            editApplianceCount++;
            editAppliances.appendChild(applianceDiv);
            console.log('Appliance', index + 1, ':', appliance);
        });
    
    }

    
    const addApplianceBtn = document.getElementById('addMoreAppliance');
    const editApplianceBtn = document.getElementById('editMoreAppliance');
    let addApplianceCount = 0;
    let editApplianceCount = 0;

    addApplianceBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (addApplianceCount < 5) {
            const applianceContainer = document.getElementById('applianceContainer');
            const appliance = document.createElement('div');
            appliance.style = "margin-bottom: 5px;";
            appliance.innerHTML = `
                <input type="text" class="appliance shadow" name="appliances[]" placeholder="Appliance ${addApplianceCount + 1}" required>
                <button type="button" class="deleteButton" onclick="deleteAppliance(this)" style ="background: none; border: medium; margin-left: 10px;">
                <img class="deleteapplinace" src="/images/icons/Residents/delete.png" alt="Delete" style="width: 30px !important;  height: 30px !important;"></button>
            `;
            applianceContainer.appendChild(appliance);
            addApplianceCount++;
        }   
    });

   
    editApplianceBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (editApplianceCount < 5) {
            const applianceContainer = document.getElementById('Edit-applianceContainer');
            const appliance = document.createElement('div');
            appliance.style = "margin-bottom: 5px;";
            appliance.innerHTML = `
                <input type="text" class="appliance shadow" name="edit-appliances[]" placeholder="Appliance ${editApplianceCount + 1}" required>
                <button type="button" class="deleteButton" onclick="edit_deleteAppliance(this)" style ="background: none; border: medium; margin-left: 10px;">
                <img class="deleteapplinace" src="/images/icons/Residents/delete.png" alt="Delete" style="width: 30px !important;  height: 30px !important;"></button>
            `;  
            applianceContainer.appendChild(appliance);
            editApplianceCount++;
        }   
    });

    function deleteAppliance(button) {
        const appliance = button.parentNode;
        appliance.remove();
        addApplianceCount--;
    }


    function edit_deleteAppliance(button) {
        const appliance = button.parentNode;
        appliance.remove();
        editApplianceCount--;
    }
</script>

<?php
// End output buffering and flush the buffer
ob_end_flush();
html_end();
?>
