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
                <button class="btn-var-3" type="button" data-bs-toggle="modal" data-bs-target="#addPaymentModal"><img src="/images/icons/Dashboard/Buttons/add_payment_light.png" alt="">Add Payment</button>
            </div>
        HTML;
    }

    public static function edit_payment_modal(){
        $tenants = BillingsController::get_tenants();
        echo <<< HTML
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
                                        <input class="rounded-inputs uniform-aligned-inputs" type="text" id="billTotal" name="billTotal">
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
                                    <button type="submit" name="edit-payment-submit" class="btn-var-2">Save</button>
                                </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        HTML;
    }

    public static function add_payment_modal(){
        $tenants = BillingsController::get_tenants();
        echo <<<HTML
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
                                <input type="hidden" id="isPaid" name="isPaid" value="1">
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
                                    <button type="submit" name="add-payment-submit" class="btn-var-3 add-button">Add</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        HTML;
    }


    public static function overdue_table(){
        echo <<<HTML
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
                    </tbody>
                </table>
            </div>
        HTML;
    }

    public static function unpaid_table(){
        $total_billings_unpaid = BillingsController::get_unpaid_billings();
    
        echo <<<HTML
            <table>
                <thead>
                    <tr class="orange-th">
                        <th>Date Issued</th>
                        <th>Due Date</th>
                        <th>Tenant Name</th>
                        <th>Rent Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
        HTML;

        foreach ($total_billings_unpaid as $billing) {
            $billDateIssued = $billing['billDateIssued'];
            $billDueDate = $billing['billDueDate']; 
            $tenantFullName = $billing['tenant_first_name'] . ' ' . $billing['tenant_last_name']; 
            $billTotal = $billing['billTotal'];

        echo <<<HTML
            <tr>
                <td>$billDateIssued</td>
                <td>$billDueDate</td>
                <td>$tenantFullName</td>
                <td>$billTotal</td>
                <td class="action-buttons">
                    <button id="openEditBillingsModalBtn" style="margin-right: 10px;">
                        <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#editBillingsModal">
                    </button>
                    <button id="openDeleteBillingsModalBtn" style="margin-right: 10px;">
                        <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#deleteBillingsModal">
                    </button>
                </td>
            </tr>
        HTML;
    }

    echo <<<HTML
            </tbody>
        </table>
    
        HTML;
    }

    public static function paid_table() {
        $total_billings_paid = BillingsController::get_paid_billings();
    
        echo <<<HTML
            
                <table>
                    <thead>
                        <tr>
                            <th>Date Issued</th>
                            <th>Due Date</th>
                            <th>Tenant Name</th>
                            <th>Rent Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
        HTML;
    
        foreach ($total_billings_paid as $billing) {
            $billDateIssued = $billing['billDateIssued'];
            $billDueDate = $billing['billDueDate']; 
            $tenantFullName = $billing['tenant_first_name'] . ' ' . $billing['tenant_last_name']; 
            $billTotal = $billing['billTotal'];
    
            echo <<<HTML
                <tr>
                    <td>$billDateIssued</td>
                    <td>$billDueDate</td>
                    <td>$tenantFullName</td>
                    <td>$billTotal</td>
                    <td class="action-buttons">
                        <button id="openEditBillingsModalBtn" style="margin-right: 10px;">
                            <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#editBillingsModal">
                        </button>
                        <button id="openDeleteBillingsModalBtn" style="margin-right: 10px;">
                            <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#deleteBillingsModal">
                        </button>
                    </td>
                </tr>
            HTML;
        }
    
        echo <<<HTML
                </tbody>
            </table>
        HTML;
    }  

    public static function delete_payment_modal(){
        echo <<<HTML
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
        HTML;
    }

}

?>