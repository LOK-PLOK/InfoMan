<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
ob_start();

require '../php/templates.php';
require '../views/DashboardViews.php';
require '../php/navbar.php'; // Sidebar

$more_links = '
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.min.css" 
integrity="sha512-wCrId7bUEl7j1H60Jcn4imkkiIYRcoyq5Gcu3bpKAZYBJXHVMmkL4rhtyhelxSFuPMIoQjiVsanrHxcs2euu/w==" crossorigin="anonymous" referrerpolicy="no-referrer"/>';

html_start('dashboard.css', $more_links);
DashboardViews::burger_sidebar();
?>

<!-- Dashboard Content Section -->
<div class="container-fluid">

	<?php
	// Dashboard Header
	DashboardViews::dashboard_header();
	?>
    
    <!-- Modal Buttons -->
    <div class="dashboard-button">
        <button class="btn-var-3 shadow" type="button" data-bs-toggle="modal" data-bs-target="#myModal" onmouseover="document.getElementById('dashboard-add-user').src='/images/icons/Dashboard/Buttons/add_user_dark.png'" onmouseout="document.getElementById('dashboard-add-user').src='/images/icons/Dashboard/Buttons/add_user_light.png'">
			<img id="dashboard-add-user" src="/images/icons/Dashboard/Buttons/add_user_light.png" alt="">Add Tenant</button>
        <button class="btn-var-3 shadow" type="button" data-bs-toggle="modal" data-bs-target="#add-new-rent-modal" onmouseover="document.getElementById('dashboard-add-new-rent').src='/images/icons/Dashboard/Buttons/add_new_rent_dark.png'" onmouseout="document.getElementById('dashboard-add-new-rent').src='/images/icons/Dashboard/Buttons/add_new_rent_light.png'">
			<img id="dashboard-add-new-rent" src="/images/icons/Dashboard/Buttons/add_new_rent_light.png" alt="">Add New Rent</button>
    </div>

    <!-- Overview -->
    <span style="font-size: larger;">Boarding House Capacity Overview</span><br>
    <div class="row dashboard-icons-cont">

	<?php 
	
	// Total Residents
	DashboardViews::ov_total_residents(); 
	
	// Total Occupied Beds and Available Beds
	DashboardViews::ov_bedsOcc_bedsAvail();

	// Total Available Rooms
	DashboardViews::ov_available_rooms();
	
	?>
</div>

<?php 

// Add New Tenant Modal
DashboardViews::add_tenant_model_view();

// Add New Rent Modal
DashboardViews::create_new_rent_modal();

?>
<script src="../js/dashboard.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
	$(document).ready(function() {
		$("#tenantName").selectize();
		$("#new-rent-tenant").selectize();
		$("#share-new-rent-tenant").selectize();
	});
</script>


<?php 

if(isset($_GET['addTenantStatus'])){
	if($_GET['addTenantStatus'] === 'success'){
		echo '<script>showSuccessAlert("Tenant Added Successfully!");</script>';
	} else if($_GET['addTenantStatus'] === 'error'){
		echo '<script>showFailAlert("An unexpected error has happened!");</script>';
	}
}

if(isset($_GET['addRentStatus'])){
	if($_GET['addRentStatus'] === 'Success - Shared'){
		echo '<script>showSuccessAlert("Shared Room Rent Added Successfully!");</script>';
	} else if($_GET['addRentStatus'] === 'Error - Shared'){
		echo '<script>showFailAlert("Shared Room Rent Error!");</script>';
	} else if($_GET['addRentStatus'] === 'Error - Bed Spacer only'){
		echo '<script>showFailAlert("Bed Spacer only!");</script>';
	} else if($_GET['addRentStatus'] === 'Error - Room Full'){
		echo '<script>showFailAlert("Room is in Full Capacity!");</script>';
	} else if($_GET['addRentStatus'] === 'Success - Rent'){
		echo '<script>showSuccessAlert("Rent Added Successfully!");</script>';
	} else if($_GET['addRentStatus'] === 'Error - Tenant Rent Error'){
		echo '<script>showFailAlert("Tenant is already occupied on the selected date!");</script>';
	}
}

if(isset($_GET['AccessError'])){
	if($_GET['AccessError'] === 'unauthorizedPageAttempt'){
		echo '<script>showFailAlert("Accessing Unauthorized Page!");</script>';
	} 
}

// Form Submission Handlers
if($_SERVER['REQUEST_METHOD'] == "POST") {

	// Add New Tenant Handler
	if (isset($_POST['create-tenant-submit'])) {
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
		}
	
		$result = DashboardController::create_new_tenant($newTenant,$appliances);
        if ($result) {
            // Redirect to the same page or to a confirmation page after successful form submission
            header('Location: dashboard.php?addTenantStatus=success');
            exit();
        } else {
            // Handle the error case, potentially redirecting with an error flag or displaying an error message
            header('Location: dashboard.php?addTenantStatus=error');
            exit();
        }
	}

	// Add New Rent Handler
	if (isset($_POST['create-new-rent'])) {
		$create_rent = array(
			"tenID" => htmlspecialchars($_POST['new-rent-tenant']),
			"shareTenID" => htmlspecialchars($_POST['share-new-rent-tenant']) ?? '',
			"roomID" => htmlspecialchars($_POST['new-rent-room']),
			"occTypeID" => htmlspecialchars($_POST['new-rent-occTypeID']),
			"occDateStart" => htmlspecialchars($_POST['new-rent-start']),
			"occDateEnd" => htmlspecialchars($_POST['new-rent-end']),
			"occupancyRate" => htmlspecialchars($_POST['new-rent-rate'])
		);

		$new_billing = array(
			"tenID" => $_POST['new-rent-tenant'],
			"billTotal" => $_POST['new-rent-rate'],
			"endDate" => $_POST['new-rent-end']
		);

		$result = DashboardController::create_new_rent($create_rent, $new_billing);
        header('Location: dashboard.php?addRentStatus='.$result);
        exit();
	}
}

ob_end_flush();
html_end(); 

?>

