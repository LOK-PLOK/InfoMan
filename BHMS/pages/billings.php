<?php
    session_start();
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
                    <button class="tab-btn active">Overdue</button>
                    <button class="tab-btn">Unpaid</button>
                    <button class="tab-btn">Paid</button>
                    <div class="line"></div>
                </div>
                <div class="content-box">
                    <div class="table-section">
                        <header class="upper">
                            <!-- Leftside Area header -->
                            <div class="leftside-content">
                                <span style="color: #779CC8; font-weight: bold; margin-right: 10px;">Sort by:</span>
                                <form method="GET">
                                <div class="btn-group " style="box-shadow: 0px 4px 4px 0px rgba(0,0,0,0.25);">
                                    <button class="btn-var-7 dropdown-toggle shadow" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                      <span class="pe-5 fs-6" style="padding-left: 20px;">Category...</span>
                                    </button>

                                    <ul class="dropdown-menu" style="background-color: #EDF6F7; z-index:1050;">
                                        <li class="d-flex justify-content-center">
                                            <input type="submit"  name="" value="Newest to Oldest" class="dropdown-content">
                                        </li>
                                        <li class="d-flex justify-content-center">
                                            <input type="submit"  name="sort-oldest-to-newest" value="Oldest to Newest" class="dropdown-content">
                                        </li>
                                        <li class="d-flex justify-content-center">
                                            <input type="submit"   name="sort-order-by-name" value="Order by Name" class="dropdown-content">
                                        </li>
                                        <li class="d-flex justify-content-center">
                                            <input type="submit" name="sort-order-by-amount" value="Order by Amount" class="dropdown-content">
                                        </li>
                                    </ul>
                                </div>
                                </form>
                            </div>
            
                            <!-- Rightside Area header -->
                            <div class="rigthside-content">
                                <form method="GET">
                                    <div class="search-container shadow">
                                            <input id="search" class="search" type="text" value="" name="search" placeholder="Search">
                                            <span class="search-icon"><i class="fas fa-search"></i></span>
                                    </div>
                                </form>
                            </div>
                        </header>
                        
                        <?php
                            // if isset GET oldest to newest
                            // 2ndparam = oldest-to-newest
                            $sortType = '';
                            if(isset($_GET['sort-order-by-amount'])){
                                $sortType = 'amount';
                            }else if(isset($_GET['sort-oldest-to-newest'])){
                                $sortType = 'o-t-n';
                            }else if(isset($_GET['sort-order-by-name'])){
                                $sortType = 'name';
                            }
                        ?>

                        <!-- OVERDUE -->
                        <div class="content active overflow-auto" style="max-height: 500px;">
                            <?php
                                BillingsViews::generate_billing_table('overdue', $sortType); 
                            ?>
                        </div>
                        

						<!-- UNPAID TABLE -->
                        <div class="content overflow-auto" style="max-height: 500px;">
                            <?php
                                BillingsViews::generate_billing_table('unpaid', $sortType);
                            ?>
                        </div>

                        <!-- PAID TABLE -->
                        <div class="content overflow-auto" style="max-height: 500px;">
                            <?php
                                BillingsViews::generate_billing_table('paid', $sortType);
                            ?>
                        </div>

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

    if(isset($_GET['addPaymentStatus'])){
        if($_GET['addPaymentStatus'] == 'success'){
            echo '<script>showSuccessAlert("Payment added successfully")</script>';
        }else if($_GET['addPaymentStatus'] == 'error'){
            echo '<script>showFailAlert("Error adding payment")</script>';
        }
    }

    if(isset($_GET['addBillingStatus'])){
        if($_GET['addBillingStatus'] == 'success'){
            echo '<script>showSuccessAlert("Billing added successfully")</script>';
        }else if($_GET['addBillingStatus'] == 'error'){
            echo '<script>showFailAlert("Error adding billing")</script>';
        }
    }

    if(isset($_GET['deleteBillingStatus'])){
        if($_GET['deleteBillingStatus'] == 'success'){
            echo '<script>showSuccessAlert("Billing deleted successfully")</script>';
        }else if($_GET['deleteBillingStatus'] == 'error'){
            echo '<script>showFailAlert("Error deleting billing")</script>';
        }
    }

    if(isset($_GET['editBillingStatus'])){
        if($_GET['editBillingStatus'] == 'success'){
            echo '<script>showSuccessAlert("Billing updated successfully")</script>';
        }else if($_GET['editBillingStatus'] == 'error'){
            echo '<script>showFailAlert("Error updating billing")</script>';
        }
    }

    if(isset($_GET['editPaidBillingStatus'])){
        if($_GET['editPaidBillingStatus'] == 'success'){
            echo '<script>showSuccessAlert("Billing updated successfully")</script>';
        }else if($_GET['editPaidBillingStatus'] == 'error'){
            echo '<script>showFailAlert("Error updating billing")</script>';
        }
    }
    

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        // LISTEN TO POST REQUEST FROM CREATE PAYMENT MODAL
        if(isset($_POST['add-payment-submit'])){
            $new_payment = array(
                "billRefNo" => $_POST['billRefNo'],
                "tenID" => $_POST['paymentTenantID'],
                "payAmount" => $_POST['actualPaymentAmount'],
                "payMethod" => $_POST['paymentMethod'],
                "payerFname" => isset($_POST['payer-fname']) ? $_POST['payer-fname'] : '',
                "payerLname" => isset($_POST['payer-lname']) ? $_POST['payer-lname'] : '',
                "payerMI" => isset($_POST['payer-MI']) ? $_POST['payer-MI'] : ''
            );
            $result = BillingsController::create_payment($new_payment);
            $status = BillingsController::update_billing_status($new_payment);            
            // Redirect to the same page or to a confirmation page after successful form submission
            if ($result) {
                header('Location: billings.php?addPaymentStatus=success');
                exit();
            } else {
                // Handle the error case, potentially redirecting with an error flag or displaying an error message
                header('Location: billings.php?addPaymentStatus=error');
                exit();
            }
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
                );

            $result = BillingsController::create_billings($new_billing);
            if($result){
                header('Location: billings.php?addBillingStatus=success');
                exit();
            } else {
                header('Location: billings.php?addBillingStatus=error');
                exit();
            }
        }

        // LISTEN TO POST REQUEST FROM DELETE MODAL
        if (isset($_POST['delete-billing-submit'])) {
            $billing_id = $_POST['billing_id'];
            $result = BillingsController::delete_billings($billing_id);
            if ($result) {
                header('Location: billings.php?deleteBillingStatus=success');
                exit();
            } else {
                header('Location: billings.php?deleteBillingStatus=error');
                exit();
            }
        }

        // LISTEN TO POST REQUEST FROM EDIT MODAL
        if (isset($_POST['edit-billing-submit'])) {
            $updated_billing = array(
                "billRefNo" => $_POST['editBillingId'],
                "billTotal" => $_POST['editBillTotal'],
            );
            
            $result = BillingsController::update_billing($updated_billing);
            if($result){
                header('Location: billings.php?editBillingStatus=success');
                exit();
            } else {
                header('Location: billings.php?editBillingStatus=error');
                exit();
            }
        }

        //LISTEN TO POST REQUEST FROM EDIT PAID BILLING
        if (isset($_POST['edit-paid-billing-submit'])) {

            $updated_bp = array(
                "billRefNo" => $_POST['editPaidBillingId'],
                "billTotal" => $_POST['editPaidBillTotal'],
                "payMethod" => $_POST['edit-payMethod'],
                "payerFname" => $_POST['edit-payer-fname'],
                "payerLname" => $_POST['edit-payer-lname'],
                "payerMI" => $_POST['edit-payer-MI']
            );

            $result = BillingsController::update_billing_payment($updated_bp);

            if($result) {
                header('Location: billings.php?editPaidBillingStatus=success');
                exit();
            } else {
                header('Location: billings.php?editPaidBillingStatus=error');
                exit();
            }
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
<script src="/js/billingsFunction.js"></script>

<script>
    // searchable drop down handler
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

    // calculateDate handler
    
    calculateDate('create-billing-start-date', 'create-billing-dummy-end-date','create-billing-end-date');
    // comment this out for the mean time
    // calculateDate('start-date', 'dummy-end-date','end-date');


    // tab save even when refreshing handler
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