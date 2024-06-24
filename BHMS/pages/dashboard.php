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

// Notification Bell
DashboardViews::notification();

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
<div class="modal fade" id="add-new-rent-modal" tabindex="-1" aria-labelledby="add-new-rent-modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="add-new-rent-modal">Add New Rent</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div>
            <div>
                <label for="new-rent-tenant" class="input-label">Tenant Assigned:</label>
                <select name="new-rent-tenant" id="new-rent-tenant" class="w-100 shadow">
                    <option value="" disabled selected>Select a tenant...</option>
                    <option value="Maria P. Detablurs">Maria P. Detablurs</option>
                    <option value="Nash Marie Abangan">Nash Marie Abangan</option>
                </select>
                <div class="d-flex justify-content-center input-sub-label">Name</div>
            </div>
            <div class="row-fluid">
                <div class="col-12">
                    <label for="new-rent-room" class="input-label">Room Details:</label>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="col-sm-5">
                        <select name="new-rent-room" id="new-rent-room" class="w-100 shadow">
                            <option value="" disabled selected>Select a Room...</option>
                            <option value="Maria P. Detablurs">B10101</option>
                            <option value="Nash Marie Abangan">B10102</option>
                        </select>
                        <div class="d-flex justify-content-center input-sub-label">Room Code</div>
                    </div>
                    <div class="col-sm-5">
                        <select name="new-rent-type" id="new-rent-type"" class="w-100 shadow">
                                <option value="" disabled selected>Select a Type...</option>
                                <option value="Maria P. Detablurs">Bed-Spacer</option>
                                <option value="Nash Marie Abangan">Room</option>
                        </select>
                        <div class="d-flex justify-content-center input-sub-label">Occupancy Type</div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="col-12">
                    <label for="new-rent-start" class="input-label">Additional Information:</label>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="col-sm-5">
                        <input type="date" name="new-rent-start" id="new-rent-start" class="w-100 shadow">
                        <div class="d-flex justify-content-center input-sub-label">Starting Date</div>
                    </div>
                    <div class="col-sm-5">
                        <input type="number" name="new-rent-rate" id="new-rent-rate" class="w-100 shadow" disabled>
                        <div class="d-flex justify-content-center input-sub-label">Monthly Payment</div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer border-0 justify-content-center">
        <button class="btn-var-3 add-button">Add</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(function(){
        $("#tenantName").selectize();
    }); 
</script>

<?php html_end(); ?>

