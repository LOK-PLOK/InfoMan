<?php

// $filePath = __FILE__;
// echo "The file path is: $filePath";

session_start();

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

// Header
DashboardViews::dashboard_header();

?>
    
    <!-- Modal Buttons -->
    <div class="dashboard-button">
        <button class="btn-var-3 shadow" type="button" data-bs-toggle="modal" data-bs-target="#myModal"><img src="/images/icons/Dashboard/Buttons/add_user_light.png" alt="">Add Tenant</button>
        <button class="btn-var-3 shadow" type="button" data-bs-toggle="modal" data-bs-target="#addPaymentModal"><img src="/images/icons/Dashboard/Buttons/add_payment_light.png" alt="">Add Payment</button>
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

<!-- Add Tenant Modal -->
<?php 

DashboardViews::add_tenant_model_view();

if($_SERVER['REQUEST_METHOD'] == "POST") {
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
			echo '<script>console.log("Tenant added successfully")</script>';
		} else {
			echo '<script>console.log("Error")</script>';
		}
	}
}

?>

<!--------------- ADD PAYMENT MODAL --------------->
<div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addNewPaymentLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content bg-custom">
			<div class="modal-header bg-custom">
				<h5 class="modal-title" id="addNewPaymentLabel">Add New Payment</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body bg-custom">
				<form action="/action_page.php">
					<label class="billings-modal-labels" for="tenantName">Tenant Information</label>
					<select name="tenantName" id="tenantName">
						<option value="">Select Tenant</option>
						<option value="Maria P. Detablurs">Maria P. Detablurs</option>
						<option value="Nash Marie Abangan">Nash Marie Abangan</option>
					</select>
					<p class="small-text">Name</p>
					<label class="billings-modal-labels" for="paymentAmount">Payment Details</label>
					<input type="text" id="paymentAmount" name="paymentAmount">
					<p class="small-text">Amount</p>

					<label class="billings-modal-labels" for="paymentAmount">Month Allocated</label>
					<div class="month-allocated-cont">
						<div>
							<input type="date" id="start-date" name="start-date">
							<p class="small-text">Start Date</p>
						</div>
						<div>
							<input type="date" id="end-date" name="end-date" disabled>
							<p class="small-text">End Date</p>
						</div>
						
					</div>

					<input type="checkbox" id="non-tenant-check" name="non-tenant-check">
					<span class="custom-checkbox">Transaction made by a non-tenant payer</span>
					
					<div class="payer-details">
					<label class="billings-modal-labels" for="paymentAmount">Payer Information</label>
					<div class="payer-info">
					<div>
						<input type="text" id="payer-fname" name="payer-fname">
						<p class="small-text">First Name</p>
					</div>
					
					<div>
						<input type="text" id="payer-MI" name="payer-MI">
						<p class="small-text">M.I</p>
					</div>
					
					<div>
						<input type="text" id="payer-lname" name="payer-lname">
						<p class="small-text">Last Name</p>
					</div>
					
					</div>

					</div>

					<div class="add-cont">
						<button class="btn-var-3 add-button">Add</button>
					</div>
					
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Add New Rent Modal -->
<?php
DashboardViews::create_new_rent_modal();

if ($_SERVER['REQUEST_METHOD'] == "POST") {

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
            echo '<script>console.log("New Rent added successfully")</script>';
        } else {
            echo '<script>console.log("Error")</script>';
        }

        // Output the contents of $create_rent for debugging
        echo '<script>console.log(' . json_encode($create_rent) . ');</script>';
    }

}
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
			
			// Example: Update elements based on occTypeID and occRate
			const viewOccupancyRate = document.getElementById('new-rent-rate');
			const actualOccupancyRate = document.getElementById('actual-new-rent-rate');
			
			viewOccupancyRate.value = occRate;
			actualOccupancyRate.value = occRate;
			
			console.log("Selected occTypeID:", occTypeID);
			console.log("Selected occRate:", occRate);
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

<?php html_end(); ?>

