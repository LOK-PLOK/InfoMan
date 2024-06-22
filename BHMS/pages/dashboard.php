<?php

    $more_links = '
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.min.css" integrity="sha512-wCrId7bUEl7j1H60Jcn4imkkiIYRcoyq5Gcu3bpKAZYBJXHVMmkL4rhtyhelxSFuPMIoQjiVsanrHxcs2euu/w==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="/styles/residents.css">';

    require '../php/templates.php';
    html_start('dashboard.css', $more_links);
?>

<!-- Sidebar -->
<?php require '../php/navbar.php'; ?>

<!-- Burger Sidebar -->
<div class="hamburger-sidebar">
    <i class="fa-solid fa-bars"></i>
</div>

<!-- Dashboard Section -->
<div class="container-fluid">

    <!-- Notification Bell -->
    <div class="notification-group">
        <div class="notification" type="button" class="dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
            <div class="notification-num">10</div>
            <img src="/images/icons/Dashboard/notification_bell.png">
        </div>
        <ul class="notification-dd dropdown-menu dropdown-menu-end ">
            <li><h6 class="dropdown-header">Recent Notifications</h6></li>
            <li class="border-bottom border-1">
                <div class="dropdown-item text-wrap">
                    <span class="notification-item-head">Maintenance</span><br>
                    <div style="padding-left: 10px">
                        <span class="notification-item-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet at architecto</span>
                    </div>
                </div>
            </li>
            <li class="border-bottom border-1">
                <div class="dropdown-item text-wrap">
                    <span class="notification-item-head">Billings</span><br>
                    <div style="padding-left: 10px">
                        <span class="notification-item-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet at architecto</span>
                    </div>
                </div>
            </li>
            <li class="border-bottom border-1">
                <div class="dropdown-item text-wrap">
                    <span class="notification-item-head">Maintenance</span><br>
                    <div style="padding-left: 10px">
                        <span class="notification-item-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet at architecto</span>
                    </div>
                </div>
            </li>
            <li class="border-bottom border-1">
                <div class="dropdown-item text-wrap">
                    <span class="notification-item-head">Billings</span><br>
                    <div style="padding-left: 10px">
                        <span class="notification-item-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet at architecto</span>
                    </div>
                </div>
            </li>
            <li class="border-bottom border-1">
                <div class="dropdown-item text-wrap">
                    <span class="notification-item-head">Maintenance</span><br>
                    <div style="padding-left: 10px">
                        <span class="notification-item-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet at architecto</span>
                    </div>
                </div>
            </li>
            <li class="border-bottom border-1">
                <div class="dropdown-item text-wrap">
                    <span class="notification-item-head">Billings</span><br>
                    <div style="padding-left: 10px">
                        <span class="notification-item-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet at architecto</span>
                    </div>
                </div>
            </li>
            <li class="border-bottom border-1">
                <div class="dropdown-item text-wrap">
                    <span class="notification-item-head">Maintenance</span><br>
                    <div style="padding-left: 10px">
                        <span class="notification-item-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet at architecto</span>
                    </div>
                </div>
            </li>
        </ul>
    </div> 

    <!-- Header -->
    <div class="header-container">
        <div>
            <span class="page-header">Welcome Back, Juan!</span><br>
            <span class="page-sub-header">Here's what we have for you today!</span>
        </div>
    </div>
    
    <!-- Modal Buttons -->
    <div class="dashboard-button">
        <button class="btn-var-3 shadow" type="button" data-bs-toggle="modal" data-bs-target="#myModal"><img src="/images/icons/Dashboard/Buttons/add_user_light.png" alt="">Add Tenant</button>
        <button class="btn-var-3 shadow" type="button" data-bs-toggle="modal" data-bs-target="#addPaymentModal"><img src="/images/icons/Dashboard/Buttons/add_payment_light.png" alt="">Add Payment</button>
        <button class="btn-var-3 shadow" type="button" data-bs-toggle="modal" data-bs-target="#add-new-rent-modal"><img src="/images/icons/Dashboard/Buttons/add_new_rent_light.png" alt="">Add New Rent</button>
    </div>

    <!-- Overview -->
    <br><span style="font-size: larger;">Boarding House Capacity Overview</span><br>
    <div class="row dashboard-icons-cont">

        <div class="col-auto">
            <div class="dashboard-icons shadow" style="background-color: #344799; color: white;">
                <div>
                    <img src="/images/icons/Dashboard/Overview/user_light.png" alt="">
                    <div>30</div>
                </div>
                <p>Total Residents</p>
            </div>
        </div>

        <div class="col-auto">
            <div class="dashboard-icons shadow">
                <div>
                    <img src="/images/icons/Dashboard/Overview/occupied_beds_dark.png" alt="">
                    <div>30</div>
                </div>
                <p>Occupied Beds</p>
            </div>
        </div>

        <div class="col-auto">
            <div class="dashboard-icons shadow">
                <div>
                    <img src="/images/icons/Dashboard/Overview/available_beds_dark.png" alt="">
                    <div>30</div>
                </div>
                <p>Available Beds</p>
            </div>
        </div>

        <div class="col-auto">
            <div class="dashboard-icons shadow">
                <div>
                    <img src="/images/icons/Dashboard/Overview/available_rooms_dark.png" alt="">
                    <div>30</div>
                </div>
                <p>Available Rooms</p>
            </div>
        </div>
        
    </div>
</div>

<!-- Add Tenant Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-custom">
            <div class="modal-header bg-custom">
                <h5 class="modal-title" id="exampleModalLabel">Add New Tenant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-custom">
                <form action="/action_page.php">
                    <!-- Name,Gender,Date -->
                    <div class="label label-position">
                        <div style="width: 65.9%;">Name:</div>
                        <div style="width: 17%;">Gender:</div>
                        <div>Birth Date:</div>
                    </div>
                    <div class="positioning">
                        <div class="NameInput">
                            <input type="text" id="fname" name="firstname" placeholder="Maria" class="FNclass shadow" required>
                            <input type="text" id="mi" name="Middle Initial" placeholder="P" class="MIclass shadow" required>
                            <input type="text" id="lname" name="lastname" placeholder="Detablurs" class="LNclass shadow" required>
                        </div>
                        <select id="country" name="country" class="shadow">
                        <option value="">...</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        </select>
                        <input type="date" id="lname" name="lastname" class="Bday shadow">
                    </div>
                    <div class="label label-position label-under">
                        <div class="label-fn">First Name</div>
                        <div class="label-mi">Middle Inital</div>
                        <div class="label-ln">Last Name</div>
                    </div>
                    <!-- Address -->
                    <div class="label label-position">
                        <div>Address:</div>
                    </div>
                    <div>
                        <input type="text" id="houseno" name="houseno" placeholder="123" class="houseno shadow" required>
                        <input type="text" id="street" name="street" placeholder="Mabini Street" class="street shadow" required>
                        <input type="text" id="barangay" name="barangay" placeholder="" class="barangay shadow" required>
                        <input type="text" id="city" name="city" placeholder="Quezon City" class="city shadow" required>
                        <input type="text" id="province" name="province" placeholder="Quezon" class="province shadow" required>
                    </div>
                    <div class="label label-position label-under">
                        <div class="label-houseno">House No.</div>
                        <div class="label-street">Street</div>
                        <div class="label-barangay">Barangay</div>
                        <div class="label-city">City</div>
                        <div class="label-province">Province</div>
                    </div>
                    <!-- Contact Number -->
                    <div class="label label-position">
                        <div>Contact Number:</div>
                    </div>
                    <div>
                        <input type="text" id="countrycode" name="countrycode" placeholder="+63" class="countrycode shadow" required>
                        <input type="text" id="number" name="number" placeholder="123456789" class="number shadow" required>
                    </div>
                    <!-- Emergenct Contact -->
                    <div class="header label-position">
                        <div>Emergency Contact</div>
                    </div>
                    <div class="label label-position">
                        <div style="width: 60%;">Name:</div>
                        <div>Contact Number:</div>
                    </div>
                    <div style="display: flex; justify-content:left;">
                        <div class="NameInput">
                            <input type="text" id="ECfname" name="ECfirstname" placeholder="Maria" class="FNclass shadow" required>
                            <input type="text" id="ECmi" name="ECMiddle Initial" placeholder="P" class="MIclass shadow" required>
                            <input type="text" id="EClname" name="EClastname" placeholder="Detablurs" class="LNclass shadow" required>
                        </div>
                        <input type="text" id="ECcountrycode" name="ECcountrycode" placeholder="+63" class="countrycode shadow" style="margin-right: 4px;">
                        <input type="text" id="ECnumber" name="ECnumber" placeholder="123456789" class="number shadow" required>
                    </div>
                    <div class="label label-position label-under">
                        <div class="label-fn">First Name</div>
                        <div class="label-mi">Middle Inital</div>
                        <div class="label-ln">Last Name</div>
                    </div>
                    <!-- Appliances -->
                    <div class="header label-position">
                        <div>Appliances</div>
                    </div>
                    <div>
                        <input type="text" id="appliance" name="appliance" placeholder="Rice cooker" class="appliance shadow" required>
                        <input type="image" id="deleteappliance" src="/images/icons/Residents/delete.png" alt="Submit" class="deleteappliance">
                    </div>
                    <div>
                        <input type="button" name="Addmore" id="Addmore" class="btn-var-5 shadow" value="Add More">
                    </div>
                    <div class="displayflex">
                        <input type="submit" class="btn-var-4 shadow" value="Add">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="/js/general.js"></script>
<script src="/js/sliding-tab.js"></script>
<script src="/js/date.js"></script>
<script src="/js/checkbox.js"></script>
<script>
    $(function(){
        $("#tenantName").selectize();
    }); 
</script>

<?php html_end(); ?>

