<?php
    ob_start();
    require '../php/templates.php';
    require '../views/BillingsViews.php';

    $more_links = <<<HTML
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.min.css" integrity="sha512-wCrId7bUEl7j1H60Jcn4imkkiIYRcoyq5Gcu3bpKAZYBJXHVMmkL4rhtyhelxSFuPMIoQjiVsanrHxcs2euu/w==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="/styles/residents.css">
    HTML;

    html_start('billings.css', $more_links);

    // Sidebar
    require '../php/navbar.php';

    // Hamburger Sidebar
    BillingsViews::burger_sidebar();
?>

<!-- Billings Portion -->
<div class="container-fluid">

    <!-- Header -->
    <?php
        BillingsViews::billings_header()
    ?>
    
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
            
                        <!-- Paid -->
                        <div class="content active">
                            <?php
                                BillingsViews::generate_billing_table('paid');
                            ?>
                        </div>
                        

						<!-- UNPAID TABLE -->
                        <div class="content">
                            <?php
                                BillingsViews::generate_billing_table('unpaid');
                            ?>
                        </div>

                        <!-- OVERDUE TABLE -->
                        <div class="content">
                            <?php
                                BillingsViews::generate_billing_table('overdue');
                            ?>
                        </div>

    
                        <span class="table-section-footer" >
                            Showing 1 page to 3 of 3 entries
                            
                        </span>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

</div>

<?php

    BillingsViews::add_payment_modal();
    BillingsViews::edit_billing_modal();
    BillingsViews::edit_paid_billing_modal();
    BillingsViews::delete_billing_modal();
    BillingsViews::create_billing_modal();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        // LISTEN TO POST REQUEST FROM CREATE PAYMENT MODAL
        if(isset($_POST['add-payment-submit'])){
            $new_payment = array(
                "billRefNo" => $_POST['billRefNo'],
                "tenID" => $_POST['paymentTenantID'],
                "payAmount" => $_POST['actualPaymentAmount'],
                "payMethod" => $_POST['paymentMethod'],
                "payerFname" => $_POST['payer-fname'],
                "payerLname" => $_POST['payer-lname'],
                "payerMI" => $_POST['payer-MI']
            );

            $result = BillingsController::create_payment($new_payment);

            $status = BillingsController::update_billing_status($new_payment);            
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }

        // LISTEN TO POST REQUEST FROM CREATE MODAL
        if (isset($_POST['create-billing-submit'])){

                $new_billing = array(
                    "tenID" => $_POST['create-billing-tenant'],
                    "billTotal" => $_POST['create-billing-billTotal'],
                    "startDate" => $_POST['create-billing-start-date'],
                    "billDateIssued" => $_POST['create-billing-billDateIssued'],
                    "endDate" => $_POST['create-billing-end-date'],
                    "billDueDate" => $_POST['create-billing-billDueDate'],
                    "isPaid" => $_POST['create-billing-isPaid'],
                );

            $result = BillingsController::create_billings($new_billing);

            if ($result) {
                echo '<script>console.log("Billing created successfully")</script>';
            } else {
                echo '<script>console.log("Error created billing")</script>';
            }
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }

        // LISTEN TO POST REQUEST FROM DELETE MODAL
        if (isset($_POST['delete-billing-submit'])) {
            $billing_id = $_POST['billing_id'];
            $result = BillingsController::delete_billings($billing_id);
            if ($result) {
                echo '<script>console.log("Billing deleted successfully")</script>';
            } else {
                echo '<script>console.log("Error deleting billing")</script>';
            }
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }

        // LISTEN TO POST REQUEST FROM EDIT MODAL
        if (isset($_POST['edit-billing-submit'])) {
            $updated_billing = array(
                "billRefNo" => $_POST['editBillingId'],
                "billDateIssued" => $_POST['editBillDateIssued'],
                "billDueDate" => $_POST['editBillDueDate'],
                "billTotal" => $_POST['editBillTotal'],
                "isPaid" => $_POST['editStatusPayment'],
            );
            
            $result = BillingsController::update_billing($updated_billing);

            if ($result) {
                echo '<script>console.log("Billing created successfully")</script>';
            } else {
                echo '<script>console.log("Error created billing")</script>';
            }
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }

        //LISTEN TO POST REQUEST FROM EDIT PAID BILLING
        if (isset($_POST['edit-paid-billing-submit'])) {

            $updated_bp = array(
                "billRefNo" => $_POST['editPaidBillingId'],
                "billDueDate" => $_POST['editPaidBillDueDate'],
                "billTotal" => $_POST['editPaidBillTotal'],
                "payMethod" => $_POST['edit-payMethod'],
                "payDate" => $_POST['edit-datePaid'],
                "payerFname" => $_POST['edit-payer-fname'],
                "payerLname" => $_POST['edit-payer-lname'],
                "payerMI" => $_POST['edit-payer-MI']
            );

            echo '<script>console.log('.json_encode($updated_bp).')</script>';

            $result = BillingsController::update_billing_payment($updated_bp);

            if ($result) {
                echo '<script>console.log("Billing created successfully")</script>';
            } else {
                echo '<script>console.log("Error created billing")</script>';
            }
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }

    }
    
?>


<!-- Additional JavaScript -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="/js/date.js"></script>
<script src="/js/prepopulate.js"></script>
<script src="/js/checkbox.js"></script>
<script src="/js/date.js"></script>

<script>
    const payOccType = document.getElementById('payment-occupanyType');
    const addPaymentBtn = document.getElementById('add-payment-button');
    const noOfAppliances = document.getElementById('noOfAppliances');
    const totalAmountPayment = document.getElementById('paymentAmount');
    const actualAmountPayment = document.getElementById('actualPaymentAmount');
    const applianceRate = document.getElementById('applianceRate');

    let totalAppliance = 0;
    let totalOccRate = 0;

    payOccType.addEventListener('change', function() {
        console.log(this.value);
        totalOccRate = parseInt(this.value);
        totalAmountPayment.value = totalOccRate + totalAppliance;
        actualAmountPayment.value = totalOccRate + totalAppliance;
    });

    addPaymentBtn.addEventListener('click', function() {
        console.log(this.value);    
    });

    noOfAppliances.addEventListener('change', function() {
        let value = parseInt(this.value);
        if (value < 0) {
            value = 0;
        } else if (value > 5) {
            value = 5;
        }
        this.value = value;
        totalAppliance = value * parseInt(applianceRate.value);
        totalAmountPayment.value = totalOccRate + totalAppliance;
        actualAmountPayment.value = totalOccRate + totalAppliance;
    });

    $(function(){
        $("#tenantName").selectize();
        $("#editDatePayment").selectize();
        $("#create-billing-tenant").selectize();
    });

    
    document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteBillingsModal'));
    const deleteButtons = document.querySelectorAll('.delete-button');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const billingId = this.getAttribute('data-billing-id');
            document.getElementById('billing_id').value = billingId;
            deleteModal.show();
        });
    });

    document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(button => {
        button.addEventListener('click', function() {
            deleteModal.hide();
        });
    });

    document.getElementById('deleteBillingsModal').addEventListener('hidden.bs.modal', function () {
        var backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => backdrop.remove());
    });
});


    calculateDate('start-date', 'dummy-end-date','end-date');
    calculateDate('create-billing-start-date', 'create-billing-dummy-end-date','create-billing-end-date');

    
function handleTabSwitching() {
    const tabs = document.querySelectorAll('.tab-btn');
    const allContent = document.querySelectorAll('.content');
    const slider = document.querySelector('.line');

    function switchTab(tabIndex) {
        tabs.forEach((tab, index) => {
            if (index === tabIndex) {
                tab.classList.add('active');
                slider.style.width = tab.offsetWidth + "px";
                slider.style.left = tab.offsetLeft + "px";
            } else {
                tab.classList.remove('active');
            }
        });

        allContent.forEach((content, index) => {
            if (index === tabIndex) {
                content.classList.add('active');
            } else {
                content.classList.remove('active');
            }
        });
        localStorage.setItem('activeTabIndex', tabIndex);
    }


    const activeTabIndex = localStorage.getItem('activeTabIndex');
    if (activeTabIndex !== null) {
        switchTab(parseInt(activeTabIndex));
    }


    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => {
            switchTab(index);
        });
    });
}

document.addEventListener('DOMContentLoaded', handleTabSwitching);

</script>


<?php 
    html_end(); 
    ob_end_flush();
?>