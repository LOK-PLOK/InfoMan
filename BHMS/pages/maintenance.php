<?php
// Start output buffering at the beginning of your script
ob_start();
session_start();

require '../php/templates.php';
require '../views/MaintenanceViews.php';

echo '<script src="../js/maintenance_edit&delete_modal.js"></script>';

html_start('maintenance.css');

// Sidebar
require '../php/navbar.php';
MaintenanceViews::burger_sidebar();
?>


<div class="container-fluid">


    <!-- Header -->
    <?php
    MaintenanceViews::maintenance_header();
    MaintenanceViews::maintenance_content();
    
    ?>
    
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <!-- Overview -->

    <!-- Add New Maintenance Modal -->
<?php
MaintenanceViews::create_maintenance_modal();

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['create-new-maintenance'])) {
        $create_maintenance = array(
            "roomID" => htmlspecialchars($_POST['maintenance-room-code']),
            "maintDate" => htmlspecialchars($_POST['maintDate']),
            "maintStatus" => htmlspecialchars($_POST['maintStatus']),
            "maintDesc" => htmlspecialchars($_POST['maintDesc']),
            "maintCost" => htmlspecialchars($_POST['maintCost'])
            
        );
        echo '<script>console.log(' . json_encode($create_maintenance) . ');</script>';
        $result = MaintenanceController::create_new_maintenance($create_maintenance);
        if ($result) {
            echo '<script>console.log("New maintenance added successfully")</script>';
        } else {
            echo '<script>console.log("Error")</script>';
        }

        // Output the contents of $create_rent for debugging
        echo '<script>console.log(' . json_encode($create_maintenance) . ');</script>';
    }

    

    
    // After handling the form submission, redirect to avoid form resubmission
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit(); // Make sure to exit after redirect

}
?>

<?php 

if (isset($_POST['delete-maintenance-submit'])){
    $maintenanceID = $_GET['maintID'];
    echo '<script>console.log(' .$maintenanceID. ');</script>';
}



?>

<!-- Add New Maintenance Modal -->

   

<!-- Revision Edit MODAL -->
<div class="modal fade" id="edit-modal-info" tabindex="-1" aria-labelledby="edit-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-custom">
            <div class="modal-header bg-custom">
                <h5 class="modal-title" id="edit-modal">Room Maintenance Information</h5>
                <button type="button" class="btn-close" id="editCloseButton" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-custom">
                <form action="/action_page.php" class="modalcolumn">
                    <!-- Row 1: Room Code -->
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-4 text-md-end">
                            <label for="edit-roomcode" class="form-label">Room Code:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="edit-roomcode" name="edit-roomcode" placeholder="Enter room code..." class="form-control shadow" required>
                        </div>
                    </div>
                    <!-- Row 2: Date -->
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-4 text-md-end">
                           <label for="edit-date" class="form-label">Date:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="date" id="edit-date" name="edit-date" class="form-control shadow" required>
                        </div>
                    </div>
                    <!-- Row 3: Reason -->
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-4 text-md-end">
                            <label for="edit-reason" class="form-label">Reason:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="edit-reason" name="edit-reason" placeholder="Enter a reason..." class="form-control shadow" required>
                        </div>
                    </div>
                    <!-- Row 4: Status -->
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-4 text-md-end">
                            <label for="edit-status" class="form-label">Status:</label>
                        </div>
                        <div class="col-md-8">
                            <select id="edit-status" name="edit-status" class="form-select shadow" required>
                                <option value="" disabled selected>Choose the status...</option>
                                <option value="On-going">On-going</option>
                                <option value="Completed">Completed</option>
                                <option value="Canceled">Canceled</option>
                            </select>
                        </div>
                    </div>
                    <!-- Row 5: Maintenance Cost -->
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-4 text-md-end">
                            <label for="edit-maintenance-cost" class="form-label">Maintenance Cost:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="edit-maintenance-cost" name="edit-maintenance-cost" placeholder="Enter the cost..." class="form-control shadow" required>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="displayflex">
                        <input type="submit" class="btn-var-2" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal Revision-------------- -->
<div class="modal fade" id="DeletemyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-custom">
            <div class="modal-header bg-custom">
                <div class="displayflex header bg-custom">
                    <span style="font-size: 25px;">Are you sure you want to delete this maintenance information?</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-custom">
                <form id="deleteMaintenanceForm" action="../pages/maintenance.php" method="POST">
                <!-- Hidden input to store the maintenance ID -->
                
                <div class="displayflex">
                    <input type="hidden" id="deleteMaintID" value="">
                    <input type="submit" name="Yes" id="Yesdelete" name="delete-maintenance-submit" class="btn-var-2 ms-4 me-4" value="Yes">
                    <input type="button" name="No" id="Nodelete" class="btn-var-2 ms-4 me-4" value="No" data-bs-dismiss="modal" aria-label="Close">
                </div>
                
                </form>
            </div>
            <div class="displayflex bg-custom label" style="border-radius: 10px;">
                <span>Note: Once you have clicked 'Yes', this cannot be undone</span>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<!-- Additional JavaScript -->
<script>
    // To be Asked !
    document.addEventListener('DOMContentLoaded', function() {
        // Function to close modal given the modal element and button id
        function setupModalClose(modalId, buttonId) {
            var closeButton = document.getElementById(buttonId);
            var modalElement = document.getElementById(modalId);
            var modalInstance = new bootstrap.Modal(modalElement);

            closeButton.addEventListener('click', function() {
                modalInstance.hide(); // Hide the modal
            });
        }

        // Setup closing for AddModal
        setupModalClose('add-modal-info', 'addCloseButton');

        // Setup closing for EditModal
        setupModalClose('edit-modal-info', 'editCloseButton');
    });
</script>

<?php html_end(); ?>

<?php
// End output buffering and flush the buffer
ob_end_flush();
?>