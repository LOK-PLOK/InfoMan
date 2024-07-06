<?php

require 'GeneralViews.php';
require '../controllers/BillingsController.php';

class BillingsViews extends GeneralViews{

    public static function billings_header() {
    
        echo <<<HTML
            <div class="billings-header">
                <div>
                    <span class="page-header">Billings</span><br>
                    <span class="page-sub-header">See recent transactions and tenant's billing status.</span>
                </div>

                <div style="gap:25px" class="d-flex flex-row" >
                    <button class="btn-var-3" type="button" data-bs-toggle="modal" data-bs-target="#createBillingModal"><img src="/images/icons/Dashboard/Buttons/add_payment_light.png" alt="">Create Billing</button>
                </div>
            </div>
        HTML;
    }

    public static function create_billing_modal(){
        $tenants = BillingsController::get_tenants();
        $occupancy_types = BillingsController::get_occupancy_types();
        echo <<<HTML
            <div class="modal fade" id="createBillingModal" tabindex="-1" aria-labelledby="addNewPaymentLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-custom">
                        <div class="modal-header bg-custom">
                            <h5 class="modal-title" id="createBillingLabel">Create Billing</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body bg-custom">
                            <form method="POST">
                                <label class="billings-modal-labels" for="create-billing-tenant">Tenant Information</label>
                                <select name="create-billing-tenant" id="create-billing-tenant">
                                    <option value="">Select Tenant</option>
            HTML;
            foreach ($tenants as $tenant){
                $id = $tenant['tenID'];
                $fName = $tenant['tenFname'];
                $MI = $tenant['tenMI'];
                $lName = $tenant['tenLname'];
                $fullName = $fName.' '.$MI.'. '.$lName;
                echo<<<HTML
                    <option value="$id">$fullName</option>
                HTML;
            }                         
            echo <<<HTML
                                </select>
                                <p class="small-text">Name</p>
                                <label class="billings-modal-labels" for="paymentAmount">Bill Total</label>
                                <div class="d-flex w-100 flex-row justify-content-between">
                                    <!-- occupancy type -->
                                    <select onchange="amountCalculator()" id="payment-occupancyType" class=" shadow" style="width: 75%">
                                        <option value="0" disabled selected>Select Occupancy Type...</option>
            HTML;
            foreach ($occupancy_types as $occupancy_type){
                $rate = $occupancy_type['occRate'];
                $occTypeName = $occupancy_type['occTypeName'];
                echo<<<HTML
                    <option value="$rate">$occTypeName</option>
                HTML;
            }
            echo <<<HTML
                                    </select>
                                    <!-- no. of appliances -->
                                    <input type="number" onchange="amountCalculator()" class="shadow" id="noOfAppliances" name="noOfAppliances" style="width: 23%" value="0" min="0" max="5">

                                    <!-- appliance rate -->
                                    <!-- <input type="hidden" id="applianceRate" name="applianceRate" value="$rate_per_appliance" disabled> -->
                                </div>

                                <div class="d-flex flex-row w-100">
                                    <div class="small-text w-75">Occupancy Type</div>
                                    <div class="small-text w-25">No. of Appliances</div>
                                </div>

                                <input style="padding: 7px;" class="rounded-inputs" type="number" id="dummy-create-billing-billTotal" name="dummy-create-billing-billTotal" disabled>
                                <p class="small-text">Amount</p>

                                <input style="padding: 7px;" class="rounded-inputs" type="number" id="create-billing-billTotal" name="create-billing-billTotal" hidden>
                            
                                
                                <label class="billings-modal-labels" for="paymentAmount">Month Allocated</label>
                                <div class="month-allocated-cont">
                                    <div>
                                        <input type="date" id="create-billing-start-date" name="create-billing-start-date">
                                        
                                        <input type="date" id="create-billing-billDateIssued" name="create-billing-billDateIssued" style="display:none">

                                        <p class="small-text">Start Date</p>
                                    </div>
                                    <div>
                                        <!-- Display Purposes -->
                                        <input type="date" id="create-billing-dummy-end-date" disabled>

                                        <!-- Actual POST data gets taken here -->
                                        <input type="date" id="create-billing-end-date" name="create-billing-end-date" style="display:none;" >

                                        <input type="date" id="create-billing-billDueDate" name="create-billing-billDueDate" style="display:none">

                                        <p class="small-text">End Date</p>
                                    </div>
                                    
                                </div>

                                <div class="add-cont">
                                    <button type="submit" name="create-billing-submit" class="btn-var-3 add-button">Add</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        HTML;
    }

    public static function delete_billing_modal(){
        echo <<<HTML
            <div class="modal fade" id="deleteBillingsModal" tabindex="-1" aria-labelledby="deleteBillingsLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-custom">
                <form method="POST">
                    <div class="modal-header bg-custom">
                        <div class="displayflex header bg-custom">
                            <span style="font-size: 25px;">Are you sure you want to delete this billing?</span></span>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-custom">
                            <div class="displayflex">
                                <!-- <input type="hidden" name="billingID" id="billingID" value=""> -->
                                <input type="hidden" name="billing_id" id="billing_id">
                                <input type="submit" name="delete-billing-submit" class="btn-var-2 ms-4 me-4" value="Yes">
                                <input type="button" name="No" id="Nodelete" class="btn-var-2 ms-4 me-4" data-bs-dismiss="modal" value="No">
                            </div>
                    </div>
                    <div class="displayflex bg-custom label" style="border-radius: 10px;">
                        <span>Note: Once you have clicked 'Yes', this cannot be undone</span>
                    </div>
                    <div class="modal-footer"></div>
                </form>
                </div>
            </div>
        </div>
        HTML;
    }    

    public static function add_payment_modal(){
        $tenants = BillingsController::get_tenants();

        echo <<<HTML
            <div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addNewPaymentLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content bg-custom">
                        <div class="modal-header bg-custom">
                            <h5 class="modal-title" id="addNewPaymentLabel">Add New Payment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body bg-custom">
                            <form method="POST">
                                <!-- BillRefNo -->
                                <input type="hidden" id="billRefNo" name="billRefNo">

                                <label class="billings-modal-labels" for="tenantName">Billing Information</label>
                                <!-- tenantID -->
                                <input type="hidden" id="paymentTenantID" name="paymentTenantID">

                                <input type="text" name="tenantName" id="paymentTenantName" disabled>
                                <p class="small-text">Name</p>
                                <!-- due date -->
                                <input type="date" class="w-100 shadow" id="paymentBillDueDate" name="paymentBillDueDate" value="" disabled>
                                <p class="small-text">Due Date</p>
                                <label class="billings-modal-labels" for="paymentAmount">Payment Details</label><br>
                                
                                <!-- payment amount -->
                                <input class="rounded-inputs" type="number" id="paymentAmount" name="paymentAmount" placeholder="0.00" disabled>

                                <input type="hidden" id="actualPaymentAmount" name="actualPaymentAmount" placeholder="0.00" >
                                <p class="small-text">Amount</p>

                                <!-- payMethod -->
                                <span class="billings-modal-labels">Mode of Transaction</span><br>
                                <select style="padding:1px;" class="rounded-inputs" name="paymentMethod" id="add-payMethod">
                                    <option value="Cash">Cash on Hand</option>
                                    <option value="Gcash">GCash</option>
                                </select>
                                
                                <input type="checkbox" id="non-tenant-check" name="non-tenant-check">
                                <span class="custom-checkbox">Transaction made by a non-tenant payer</span>
                                
                                <div class="payer-details">
                                <label class="billings-modal-labels" for="paymentAmount">Payer Information</label>
                                <div class="payer-info">
                                <div>
                                    <!-- payerFname -->
                                    <input type="text" id="payer-fname" name="payer-fname">
                                    <p class="small-text">First Name</p>
                                </div>
                                
                                <div>
                                    <!-- payerMI -->
                                    <input type="text" id="payer-MI" name="payer-MI">
                                    <p class="small-text">M.I</p>
                                </div>
                                
                                <div>
                                    <!-- payerLname -->
                                    <input type="text" id="payer-lname" name="payer-lname">
                                    <p class="small-text">Last Name</p>
                                </div>
                                
                                </div>

                                </div>

                                <div class="add-cont">
                                    <button type="submit" name="add-payment-submit" class="btn-var-3 add-button">Add</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        HTML;
    }

    public static function edit_billing_modal() {
        $occupancy_types = BillingsController::get_occupancy_types();
        echo <<<HTML
            <div class="modal fade" id="editBillingsModal" tabindex="-1" aria-labelledby="editBillingsLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-custom">
                        <div class="modal-header bg-custom">
                            <h5 class="modal-title" id="editBillingsLabel">Billing Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body bg-custom">
                            <form method="POST">
                                <div class="edit-billings-cont">
                                    <input type="hidden" id="editBillingId" name="editBillingId">
                                    
                                    <div class="edit-billings-row">
                                        <p class="light-blue-text">Tenant Name</p>
                                        <input type="text" class="uniform-aligned-inputs rounded-inputs" name="editTenantName" id="editTenantName" disabled>
                                    </div>
    
                                    <div class="edit-billings-row">
                                        <p class="light-blue-text">Date Issued</p>

                                        <input class="rounded-inputs uniform-aligned-inputs" type="date" id="editBillDateIssuedDummy" disabled>

                                        <input class="rounded-inputs uniform-aligned-inputs" type="date" id="editBillDateIssued" name="editBillDateIssued" hidden>
                                    </div>
                                
                                    <div class="edit-billings-row">
                                        <p class="light-blue-text">Date Due</p>
                                        <input class="rounded-inputs uniform-aligned-inputs" type="date" id="editBillDueDateDummy" disabled>

                                        <input class="rounded-inputs uniform-aligned-inputs" type="date" id="editBillDueDate" name="editBillDueDate"hidden>
                                    </div>

                                    <p style="margin-top: 15px" class="light-blue-text">Bill Total</p>


                                <input style="padding: 7px;" class="rounded-inputs" type="number" id="edit-create-billing-billTotal" name="editBillTotal">
                                
                                    <div style="margin:15px 0px 5px 0px" class="d-flex justify-content-center">
                                        <button type="submit" name="edit-billing-submit" class="btn-var-2 mx-3">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        HTML;
    }

    public static function edit_paid_billing_modal(){
        echo <<<HTML
            <div class="modal fade" id="editPaidBillingsModal" tabindex="-1" aria-labelledby="editBillingsLabel" aria-hidden="true">
            <form method="POST">    
            <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-custom">
                        <div class="modal-header bg-custom">
                            <h5 class="modal-title" id="editBillingsLabel">Paid Billing Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body bg-custom">
                            
                                <div class="edit-billings-cont">
                                    <!-- editBillingId -->
                                    <input type="hidden" id="editPaidBillingId" name="editPaidBillingId">
                                    
                                    <div class="edit-billings-row">
                                        <p class="light-blue-text">Tenant Name</p>
                                        <input type="text" class="uniform-aligned-inputs rounded-inputs" name="editPaidTenantName" id="editPaidTenantName" disabled>
                                    </div>
    
                                    <div class="edit-billings-row">
                                        <p class="light-blue-text">Date Due</p>
                                        <!-- editPaidBillDueDate -->
                                        <input class="rounded-inputs uniform-aligned-inputs" type="date" id="editPaidBillDueDate" name="editPaidBillDueDate" disabled>
                                    </div>

                                    <div class="edit-billings-row">
                                        <p class="light-blue-text">Date Paid</p>
                                        <!-- edit-datePaid -->
                                        <input class="rounded-inputs uniform-aligned-inputs" type="date" id="edit-datePaid" name="edit-datePaid" disabled>
                                         <!-- Get data from payment table -->
                                    </div>
                                
                                    <div class="edit-billings-row">
                                        <p class="light-blue-text">Amount</p>
                                        <input class="rounded-inputs uniform-aligned-inputs" type="text" id="editPaidBillTotal" name="editPaidBillTotal">
                                    </div>
                                
                                    <div class="edit-billings-row">
                                        <p class="light-blue-text">Status</p>
                                        <select style="padding:1px;" class="rounded-inputs uniform-aligned-inputs" name="editStatusPayment" id="editStatusPayment" disabled>
                                            <option value="1">Paid</option>
                                            <option value="0">Unpaid</option>
                                        </select>
                                    </div>

                                    <div class="edit-billings-row">
                                        <p class="light-blue-text">Mode of Transaction</p>
                                        <select style="padding:1px;" class="rounded-inputs uniform-aligned-inputs" name="edit-payMethod" id="edit-payMethod">
                                            <option value="Cash">Cash on Hand</option>
                                            <option value="Gcash">GCash</option>
                                        </select>
                                    </div>

                                    <div style="display:block" class="payer-details">
                                    <label class="billings-modal-labels" for="paymentAmount">Payer Information</label>
                                        <div class="payer-info">
                                            <div>
                                                <input class="rounded-inputs" type="text" id="edit-payer-fname" name="edit-payer-fname">
                                                <p class="small-text">First Name</p>
                                            </div>
                                            
                                            <div>
                                                <input class="rounded-inputs" type="text" id="edit-payer-MI" name="edit-payer-MI">
                                                <p class="small-text">M.I</p>
                                            </div>
                                            
                                            <div>
                                                <input class="rounded-inputs" type="text" id="edit-payer-lname" name="edit-payer-lname">
                                                <p class="small-text">Last Name</p>
                                            </div>  
                                        </div>
                                    </div>
    
                                    <div style="margin:20px 0px 10px 0px" class="d-flex justify-content-center">
                                        <button type="submit" name="edit-paid-billing-submit" class="btn-var-2">Save</button>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        HTML;
    }

    public static function generate_billing_table($billingType) {
        $billings = [];
        switch ($billingType) {
            case 'paid':
                $billings = BillingsController::get_paid_billings();
                $tableHeader = '<tr><th>Date Issued</th><th>Due Date</th><th>Tenant Name</th><th>Rent Amount</th><th>Action</th></tr>';
                $editModalType = '#editPaidBillingsModal';
                $prepBool = 0;
                break;
            case 'unpaid':
                $billings = BillingsController::get_unpaid_billings();
                $tableHeader = '<tr class="orange-th"><th>Date Issued</th><th>Due Date</th><th>Tenant Name</th><th>Rent Amount</th><th>Action</th></tr>';
                $editModalType = '#editBillingsModal';
                $prepBool = 1;
                break;
            case 'overdue':
                $billings = BillingsController::get_overdue_billings();
                $tableHeader = '<tr class="red-th"><th>Date Issued</th><th>Due Date</th><th>Tenant Name</th><th>Rent Amount</th><th>Action</th></tr>';
                $editModalType = '#editBillingsModal';
                $prepBool = 1;
                break;
            default:
                break;
        }
    
        echo <<<HTML
            <table>
                <thead>
                    $tableHeader
                </thead>
                <tbody>
        HTML;
        
        if (empty($billings)) {
            echo <<<HTML
                <tr>
                    <td colspan="5" style="text-align: center;color: rgb(118, 118, 118);">No data available</td>
                </tr>
            HTML;
        } else {
            foreach ($billings as $billing) {
                $tenID = $billing['tenID'];
                $billingId = $billing['billRefNo'];
                $billDateIssued = $billing['billDateIssued'];
                $billDueDate = $billing['billDueDate'];
                $tenantFullName = $billing['tenant_first_name'] . ' ' . $billing['tenMI'] . '. ' . $billing['tenant_last_name'];
                $billTotal = $billing['billTotal'];
                $isPaid = $billing['isPaid'];

                $billingData = BillingsController::get_billing_data($billingId);
                $billingDataJson = htmlspecialchars(json_encode($billingData));

                $occType = BillingsController::get_specific_occupancy_type($tenID);
                $occTypeJson = htmlspecialchars(json_encode($occType));

                $appliancesCount = BillingsController::get_appliances($tenID);
                $APCount = htmlspecialchars(json_encode($appliancesCount));
                $payment_billing_info_json = $APCount;
                if($isPaid){
                    $payment_billing_info = BillingsController::get_payment_billing_info($billingId);
                    $payment_billing_info_json = htmlspecialchars(json_encode($payment_billing_info));
                }

                // Converts the date to a more readable format
                $billDateIssuedReadable = date('F j, Y', strtotime($billDateIssued));
                $billDueDateReadable = date('F j, Y', strtotime($billDueDate));

                echo <<<HTML
                    <tr>
                        <td>$billDateIssuedReadable</td>
                        <td>$billDueDateReadable</td>
                        <td>$tenantFullName</td>
                        <td>$billTotal</td>
                        <td class="action-buttons">
                            <input type="hidden" name="billRefNo" value="$billingId">
                            <input type="hidden" name="tenID" value="$tenID">
                HTML;
                if($prepBool==1){
                    echo<<<HTML
                        <!-- Add payment -->
                        <button onclick="prepopulatePayment($billingDataJson)" id="add-payment-button" type="button" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                                <div style="margin-right: 10px;padding:5px;border-radius:100px;background-color: #344799" >
                                    <img style="height:27.5px" src="/images/icons/Dashboard/Buttons/add_payment_light.png" alt="">
                                </div>
                            </button>
                    HTML;
                }
                echo<<<HTML
                            <!-- edit billing -->
                            <button id="openEditBillingsModalBtn" style="margin-right: 10px;" onclick="prepopulateValues($payment_billing_info_json, $billingDataJson, $prepBool)">
                                <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="$editModalType">
                            </button>

                            <!-- delete billing -->
                            <button class="delete-button" data-billing-id="$billingId" style="margin-right: 10px;">
                                <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#deleteBillingsModal">
                            </button>
                        </td>
                    </tr>
                HTML;
            }
        }
        echo <<<HTML
                </tbody>
            </table>
        HTML;
    }    
}
?>