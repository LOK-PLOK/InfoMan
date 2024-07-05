<?php
session_start();
ob_start();

require '../php/templates.php';
require '../views/DashboardViews.php';
require '../php/navbar.php'; // Sidebar

if (!isset($_SESSION['userID'])) {
	header('Location: /index.php');
}

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
        <button class="btn-var-3 shadow" type="button" data-bs-toggle="modal" data-bs-target="#myModal"><img src="/images/icons/Dashboard/Buttons/add_user_light.png" alt="">Add Tenant</button>
        <button class="btn-var-3 shadow" type="button" data-bs-toggle="modal" data-bs-target="#add-new-rent-modal"><img src="/images/icons/Dashboard/Buttons/add_new_rent_light.png" alt="">Add New Rent</button>
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

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
	
	$(document).ready(function() {
        $("#tenantName").selectize();
        $("#new-rent-tenant").selectize();
    });

	document.getElementById('new-rent-type').addEventListener('change', function () {
		const selectedValue = this.value;
    
		if (selectedValue) {
			const [occTypeID, occRate] = selectedValue.split('|');

			const inputOccTypeID = document.getElementById('new-rent-occ-typeID');
			inputOccTypeID.value = occTypeID;
			
			// Example: Update elements based on occTypeID and occRate
			const viewOccupancyRate = document.getElementById('new-rent-rate');
			const actualOccupancyRate = document.getElementById('actual-new-rent-rate');
			
			viewOccupancyRate.value = occRate;
			actualOccupancyRate.value = occRate;

			console.log(actualOccupancyRate.value, inputOccTypeID.value);
			
		}
	});


	// End Date Setter for Add New Rent
	document.getElementById('new-rent-start').addEventListener('change', function() {
		const startDate = new Date(this.value);

		if(!isNaN(startDate.getTime())) {
			const endDate = new Date(startDate);
			endDate.setDate(endDate.getDate() + 30);

			const endDateString = endDate.toISOString().split('T')[0];
			document.getElementById('new-rent-end').value = endDateString;
		} else {
			alert("Invalid start date");
		}
	});


</script>

<?php 

// Form Submission Handlers
if($_SERVER['REQUEST_METHOD'] == "POST") {

	// Add New Tenant Handler
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
	
		$result = DashboardController::create_new_tenant($new_tenant);
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
			"roomID" => htmlspecialchars($_POST['new-rent-room']),
			"occTypeID" => htmlspecialchars($_POST['new-rent-occTypeID']),
			"occDateStart" => htmlspecialchars($_POST['new-rent-start']),
			"occDateEnd" => htmlspecialchars($_POST['new-rent-end']),
			"occupancyRate" => htmlspecialchars($_POST['new-rent-rate'])
		);

		$result = DashboardController::create_new_rent($create_rent);
        if ($result === true) {
            // Redirect to avoid form resubmission
            header('Location: dashboard.php?addRentStatus=success');
            exit();
        } else {
            // Redirect with an error message
            header('Location: dashboard.php?addRentStatus='.$result);
            exit();
        }
	}

}

ob_end_flush();
html_end(); 

?>

