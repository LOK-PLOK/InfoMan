<?php
    ob_start();
    require '../php/templates.php';
    require '../views/BillingsViews.php';

    $more_links = <<<HTML
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.min.css" integrity="sha512-wCrId7bUEl7j1H60Jcn4imkkiIYRcoyq5Gcu3bpKAZYBJXHVMmkL4rhtyhelxSFuPMIoQjiVsanrHxcs2euu/w==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="/styles/residents.css">
    <script src="/js/date.js"></script>
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
                                BillingsViews::paid_table();
                            ?>
                        </div>
                        

						<!-- UNPAID TABLE -->
                        <div class="content">
                            <?php
                                BillingsViews::unpaid_table();
                            ?>
                        </div>

						<!-- OVERDUE TABLE -->
                        <?php
                            BillingsViews::overdue_table();
                        ?>
    
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

<?php
    BillingsViews::add_payment_modal();
    BillingsViews::edit_billing_modal();
    BillingsViews::delete_billing_modal();
    BillingsViews::create_billing_modal();

    if (isset($_POST['create-billing-submit'])){

            $new_billing = array(
                "tenID" => $_POST['create-billing-tenant'],
                "billTotal" => $_POST['create-billing-billTotal'],
                "billDateIssued" => $_POST['create-billing-billDateIssued'],
                "billDueDate" => $_POST['create-billing-billDueDate'],
                "isPaid" => $_POST['create-billing-isPaid']
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

    // if (isset($_POST['create-billing-submit'])){

    // }
    
    // if (isset($_POST['edit-payment-submit'])){
    //     $payment_details = array(
    //         "tenID" => $_POST['tenantName'],
    //         "billTotal" => $_POST['billTotal'],
    //         "editStatusPayment" => $_POST['editStatusPayment'],
            
    //     )
    // }

    // if (isset($_POST['add-payment-submit'])){
    //     $new_payment = array(
    //         "tenID" => $_POST['tenantName'],
    //         "billTotal" => $_POST['paymentAmount'],
    //         "billDateIssued" => $_POST['start-date'],
    //         "billDueDate" => $_POST['end-date'],
    //         "isPaid" => $_POST['isPaid']
    //     );
    // }

    
?>


<!-- Additional JavaScript -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(function(){
        $("#tenantName").selectize();
        $("#editTenantName").selectize();
        $("#editDatePayment").selectize();
        $("#editStatusPayment").selectize();
        $("#create-billing-tenant").selectize();
    });

    
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-button');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const billingId = this.getAttribute('data-billing-id');
                document.getElementById('billing_id').value = billingId;
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteBillingsModal'));
                deleteModal.show();
            });
        });
    });

    calculateDate('#start-date', '#end-date');
    calculateDate('#create-billing-billDateIssued', '#create-billing-billDueDate');
</script>

<?php 
    html_end(); 
    ob_end_flush();
?>