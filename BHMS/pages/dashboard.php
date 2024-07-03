<?php

session_start();
ob_start();

require '../php/templates.php';
require '../views/DashboardViews.php';

$more_links = '
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.min.css" 
integrity="sha512-wCrId7bUEl7j1H60Jcn4imkkiIYRcoyq5Gcu3bpKAZYBJXHVMmkL4rhtyhelxSFuPMIoQjiVsanrHxcs2euu/w==" crossorigin="anonymous" referrerpolicy="no-referrer"/>';

html_start('dashboard.css', $more_links);

// Sidebar
require '../php/navbar.php';

// Hamburger Sidebar
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
</div>

<?php 

// Add New Tenant Modal
DashboardViews::add_tenant_model_view();

// Add New Payment Modal
DashboardViews::create_new_payment_modal();

// Add New Rent Modal
DashboardViews::create_new_rent_modal();

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

	// Add New Payment Handler
	if(isset($_POST['create-new-payment'])){

		// $create_payment = array(

		// );

		$result = '';
		if ($result) {
			// Redirect to avoid form resubmission
			header('Location: dashboard.php?addPaymentStatus=success');
			exit();
		} else {
			// Redirect with an error message
			header('Location: dashboard.php?addPaymentStatus=error');
			exit();
		}

	}

	// Add New Rent Handler
	if (isset($_POST['create-new-rent'])) {
		$create_rent = array(
			"tenID" => htmlspecialchars($_POST['new-rent-tenant']),
			"roomID" => htmlspecialchars($_POST['new-rent-room']),
			"occTypeID" => htmlspecialchars($_POST['new-rent-type']),
			"occDateStart" => htmlspecialchars($_POST['new-rent-start']),
			"occDateEnd" => htmlspecialchars($_POST['new-rent-end']),
			"occupancyRate" => htmlspecialchars($_POST['new-rent-rate'])
		);

		$result = DashboardController::create_new_rent($create_rent);
        if ($result) {
            // Redirect to avoid form resubmission
            header('Location: dashboard.php?addRentStatus=success');
            exit();
        } else {
            // Redirect with an error message
            header('Location: dashboard.php?addRentStatus=error');
            exit();
        }
	}

}
?>




<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="/js/checkbox.js"></script>
<script>
	$(document).ready(function() {
        $("#tenantName").selectize();
        $("#new-rent-tenant").selectize();
    });

	document.getElementById('new-rent-type').addEventListener('change', function () {
		const selectedValue = this.value;
    
		if (selectedValue) {
			const [occTypeID, occRate] = selectedValue.split('|');
			
			// Example: Update elements based on occTypeID and occRate
			const viewOccupancyRate = document.getElementById('new-rent-rate');
			const actualOccupancyRate = document.getElementById('actual-new-rent-rate');
			
			viewOccupancyRate.value = occRate;
			actualOccupancyRate.value = occRate;
			
			console.log("Selected occTypeID:", occTypeID);
			console.log("Selected occRate:", occRate);
		}
	});


	// End date and Due Date Setter for Add New Payment
	document.getElementById('payment-start-date').addEventListener('change', function() {
		const startDate = new Date(this.value);

		if(!isNaN(startDate.getTime())) {
			const endDate = new Date(startDate);
			const dueDate = new Date(startDate);
			endDate.setDate(endDate.getDate() + 30);
			dueDate.setDate(dueDate.getDate() + 37);

			const endDateString = endDate.toISOString().split('T')[0];
			const dueDateString = dueDate.toISOString().split('T')[0];
			document.getElementById('payment-end-date').value = endDateString;
			document.getElementById('payment-due-date').value = dueDateString;
		} else {
			console.log('Invalid start date');
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
			console.log('Invalid start date');
		}
	});


</script>

<?php 

ob_end_flush();
html_end(); 

?>

