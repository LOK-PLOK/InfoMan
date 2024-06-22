<?php
    $more_links = '
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.min.css" integrity="sha512-wCrId7bUEl7j1H60Jcn4imkkiIYRcoyq5Gcu3bpKAZYBJXHVMmkL4rhtyhelxSFuPMIoQjiVsanrHxcs2euu/w==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="/styles/residents.css">';

    require '../php/templates.php';
    html_start('billings.css', $more_links);
?>

  <!-- Sidebar -->
  <?php require '../php/navbar.php'; ?>

  <!-- Burger Sidebar -->
  <div class="hamburger-sidebar">
      <i class="fa-solid fa-bars"></i>
  </div>
  
<!-- Billings Portion -->
<div class="container-fluid">

    <!-- Header -->
    <div class="billings-header" >
        <div>
            <span class="page-header">Billings</span><br>
            <span class="page-sub-header">See recent transactions and tenant's billing status.</span>
        </div>
        <button class="btn-var-3" type="button" data-bs-toggle="modal" data-bs-target="#addPaymentModal"><img src="/images/icons/Dashboard/Buttons/add_payment_light.png" alt="">Add Payment</button>
    </div>
    
    <!-- Overview -->
    <div class="billings-content">
        <div class="direction-column">
            <div class="tab-container" >
                <div class="tab-box">
                    <button class="tab-btn active">Paid</button>
                    <button class="tab-btn">Unpaid</button>
                    <button class="tab-btn">Overdue</button>
                    <div class="line"></div>
                </div>
                <div class="content-box">
                    <div class="table-section">
                        <header class="upper">
                            <!-- Leftside Area header -->
                            <div class="leftside-content">
                                <span class="text-color">Sort by:</span>
                                <div class="btn-group " style="box-shadow: 0px 4px 4px 0px rgba(0,0,0,0.25);">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                      <span class="pe-5 fs-6">Category...</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                      I Love you wehhhh
                                    </ul>
                                  </div>
                            </div>
            
                            <!-- Rightside Area header -->
                            <div class="rigthside-content">
                                <form>
                                    <div class="search-container" style="box-shadow: 0px 4px 4px 0px rgba(0,0,0,0.25);">
                                        <input type="text" id="search" name="search" placeholder="Search">
                                        <span class="search-icon"><i class="fas fa-search"></i></span>
                                    </div>
                                </form>
                            </div>
                        </header>
            
                        <!-- PAID TABLE -->
                        <div class="content active">
                            <table>
								<thead>
									<tr>
										<th>Date</th>
										<th>Tenant Name</th>
										<th>Rent Amount</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
                                      <td>May 5, 2024</td>
                                      <td>Paid Table Here</td>
                                      <td>Php 2,000.00</td>
                                      <td class="action-buttons" >
                                        <button id="openEditBillingsModalBtn" style="margin-right: 10px;">
                                            <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#editBillingsModal">
                                        </button>
                                        <button id="openDeleteBillingsModalBtn" style="margin-right: 10px;">
                                            <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#deleteBillingsModal">
                                        </button>
                                      </td>
                                    </tr>

									<tr>
                                      <td>May 5, 2024</td>
                                      <td>Paid Table Here</td>
                                      <td>Php 2,000.00</td>
                                      <td class="action-buttons" >
                                        <button id="openEditBillingsModalBtn" style="margin-right: 10px;">
                                            <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#editBillingsModal">
                                        </button>
                                        <button id="openDeleteBillingsModalBtn" style="margin-right: 10px;">
                                            <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#deleteBillingsModal">
                                        </button>
                                      </td>
                                    </tr>

									<tr>
                                      <td>May 5, 2024</td>
                                      <td>Paid Table Here</td>
                                      <td>Php 2,000.00</td>
                                      <td class="action-buttons" >
                                        <button id="openEditBillingsModalBtn" style="margin-right: 10px;">
                                            <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#editBillingsModal">
                                        </button>
                                        <button id="openDeleteBillingsModalBtn" style="margin-right: 10px;">
                                            <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#deleteBillingsModal">
                                        </button>
                                      </td>
                                    </tr>
								</tbody>
                            </table>
                        </div>

						<!-- UNPAID TABLE -->
                        <div class="content">
                            <table>
								<thead>
									<tr class="orange-th" >
										<th>Date</th>
										<th>Tenant Name</th>
										<th>Rent Amount</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
                                      	<td>May 5, 2024</td>
                                      	<td>Unpaid Table Here</td>
                                      	<td>Php 2,000.00</td>
                                      	<td class="action-buttons" >
                                        <button id="openEditBillingsModalBtn" style="margin-right: 10px;">
                                            <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#editBillingsModal">
                                        </button>
                                        <button id="openDeleteBillingsModalBtn" style="margin-right: 10px;">
                                            <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#deleteBillingsModal">
                                        </button>
                                      </td>
                                    </tr>

									<tr>
                                      	<td>May 5, 2024</td>
                                      	<td>Unpaid Table Here</td>
                                      	<td>Php 2,000.00</td>
                                      	<td class="action-buttons" >
                                        <button id="openEditBillingsModalBtn" style="margin-right: 10px;">
                                            <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#editBillingsModal">
                                        </button>
                                        <button id="openDeleteBillingsModalBtn" style="margin-right: 10px;">
                                            <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#deleteBillingsModal">
                                        </button>
                                      </td>
                                    </tr>

									<tr>
                                      	<td>May 5, 2024</td>
                                      	<td>Unpaid Table Here</td>
                                      	<td>Php 2,000.00</td>
                                      	<td class="action-buttons" >
                                        <button id="openEditBillingsModalBtn" style="margin-right: 10px;">
                                            <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#editBillingsModal">
                                        </button>
                                        <button id="openDeleteBillingsModalBtn" style="margin-right: 10px;">
                                            <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#deleteBillingsModal">
                                        </button>
                                      </td>
                                    </tr>
								</tbody>
                            </table>
                        </div>

						<!-- OVERDUE TABLE -->
                        <div class="content">
                        	<table>
								<thead>
									<tr class="red-th" >
										<th>Date</th>
										<th>Tenant Name</th>
										<th>Rent Amount</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
                                      	<td>May 5, 2024</td>
                                      	<td>Overdue Table Here</td>
                                      	<td>Php 2,000.00</td>
                                      	<td class="action-buttons" >
                                        <button id="openEditBillingsModalBtn" style="margin-right: 10px;">
                                            <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#editBillingsModal">
                                        </button>
                                        <button id="openDeleteBillingsModalBtn" style="margin-right: 10px;">
                                            <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#deleteBillingsModal">
                                        </button>
                                      	</td>
                                    </tr>

									<tr>
                                      <td>May 5, 2024</td>
                                      <td>Overdue Table Here</td>
                                      <td>Php 2,000.00</td>
                                      <td class="action-buttons" >
                                        <button id="openEditBillingsModalBtn" style="margin-right: 10px;">
                                            <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#editBillingsModal">
                                        </button>
                                        <button id="openDeleteBillingsModalBtn" style="margin-right: 10px;">
                                            <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#deleteBillingsModal">
                                        </button>
                                      </td>
                                    </tr>

									<tr>
                                      <td>May 5, 2024</td>
                                      <td>Overdue Table Here</td>
                                      <td>Php 2,000.00</td>
                                      <td class="action-buttons" >
                                        <button id="openEditBillingsModalBtn" style="margin-right: 10px;">
                                            <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#editBillingsModal">
                                        </button>
                                        <button id="openDeleteBillingsModalBtn" style="margin-right: 10px;">
                                            <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#deleteBillingsModal">
                                        </button>
                                      </td>
                                    </tr>
								</tbody>
                            </table>
                        </div>
    
                        <span class="table-section-footer" >
                            Showing 1 page to 3 of 3 entries
                            <div>
                                <ul class="pagination">
                                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                </ul>
                            </div>
                        </span>
                    </div>
                    
                </div>
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

<!-- EDIT PAYMENT MODAL -->
<div class="modal fade" id="editBillingsModal" tabindex="-1" aria-labelledby="editBillingsLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content bg-custom">
			<div class="modal-header bg-custom">
				<h5 class="modal-title" id="editBillingsLabel">Billing Information</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body bg-custom">
				<form action="/action_page.php">
					<div class="edit-billings-cont">
						<div class="edit-billings-row">
							<p class="light-blue-text" >Tenant Name</p>
							<select class="uniform-aligned-inputs" name="editTenantName" id="editTenantName">
								<option value="">Select Tenant</option>
								<option value="Maria P. Detablurs">Maria P. Detablurs</option>
								<option value="Nash Marie Abangan">Nash Marie Abangan</option>
							</select>
						</div>
						<div class="edit-billings-row">
							<p class="light-blue-text" >Date</p>
                            <select class="uniform-aligned-inputs" name="editDatePayment" id="editDatePayment">
								<option value="">Select Date</option>
								<option value="January">January</option>
								<option value="February">February</option>
							</select>
						</div>
						<div class="edit-billings-row">
							<p class="light-blue-text" >Amount</p>
							<input class="rounded-inputs uniform-aligned-inputs" type="text" id="paymentAmount" name="paymentAmount">
						</div>
						<div class="edit-billings-row">
							<p class="light-blue-text">Status</p>
							<select class="uniform-aligned-inputs" name="editStatusPayment" id="editStatusPayment">
								<option value="">Select Status</option>
								<option value="Paid">Paid</option>
								<option value="Unpaid">Unpaid</option>
                                <option value="Overdue">Overdue</option>
							</select>
						</div>
						
                        <div style="margin:20px 0px 10px 0px" class="d-flex justify-content-center">
						<button class="btn-var-2">Save</button>
					</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- DELETE PAYMENT MODAL -->
<div class="modal fade" id="deleteBillingsModal" tabindex="-1" aria-labelledby="deleteBillingsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-custom">
            <div class="modal-header bg-custom">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="displayflex header bg-custom">
                <span style="font-size: 25px;">Are you sure you want to delete this billing?</span>
            </div>
            <div class="modal-body bg-custom">
                <form action="/action_page.php">
                    <div class="displayflex">
                        <input type="button" name="Yes" id="Yesdelete" class="btn-var-2 ms-4 me-4" value="Yes">
                        <input type="button" name="No" id="Nodelete" class="btn-var-2 ms-4 me-4" value="No">
                    </div>
                </form>
            </div>
            <div class="displayflex bg-custom label" style="border-radius: 10px;">
                <span>Note: Once you have clicked 'Yes', this cannot be undone</span>
            </div>
        </div>
    </div>
</div>

<!-- Additional JavaScript -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="/js/general.js"></script>
<script src="/js/sliding-tab.js"></script>
<script src="/js/date.js"></script>
<script src="/js/checkbox.js"></script>
<script>
    $(function(){
        $("#tenantName").selectize();
        $("#editTenantName").selectize();
        $("#editDatePayment").selectize();
        $("#editStatusPayment").selectize();
    }); 
</script>


<?php html_end(); ?>