<?php 

require 'GeneralViews.php';
require '../controllers/MaintenanceController.php';

class MaintenanceViews extends GeneralViews{

    public static function maintenance_header(){
        echo '
        <div class="container-fluid">
            <div class="billings-header" >
        <div>
            <span class="page-header">Maintenance</span><br>
        </div>
        <button type="button" class="btn-var-1 bg-btn" data-bs-toggle="modal" data-bs-target="#add-modal-info">
            <img src="/images/icons/Residents/add_new_light.png" alt=""> Add Maintenance
        </button>
        </div>
        ';
    }

    public static function create_maintenance_modal(){
        $rooms = MaintenanceController::get_room();

        echo '
        <!-- Revision Add MODAL -->
        <div class="modal fade" id="add-modal-info" tabindex="-1" aria-labelledby="add-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-custom">
                    <div class="modal-header bg-custom">
                        <h5 class="modal-title" id="add-modal">Add Maintenance</h5>
                        <button type="button" class="btn-close" id="addCloseButton" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-custom">
                        <form method="POST" class="modalcolumn">
                            <!-- Row 1: Room Code -->
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-4 text-md-end">
                                    <label for="roomcode" class="form-label">Room Code:</label>
                                </div>
                                <div class="col-md-8">
                                     <select name="maintenance-room-code" id="maintenance-room-code" class="form-control shadow">
                                        <option value="" disabled selected>Select a Room...</option>
                        ';
                                    foreach ($rooms as $room){
                                        $room_id = $room['roomID'];
                                        echo<<<HTML
                                            <option value="$room_id">$room_id</option>
                                        HTML;
                                    }
                        echo '
                                    </select>
                                </div>
                            </div>
                            <!-- Row 2: Date -->
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-4 text-md-end">
                                <label for="date" class="form-label">Date:</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="date" id="maintDate" name="maintDate" class="w-100 form-control shadow" required>
                                </div>
                            </div>
                            <!-- Row 3: Reason -->
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-4 text-md-end">
                                    <label for="reason" class="form-label">Reason:</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="maintDesc" name="maintDesc" placeholder="Enter a reason..." class="form-control shadow" required>
                                </div>
                            </div>
                            <!-- Row 4: Status -->
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-4 text-md-end">
                                    <label for="status" class="form-label">Status:</label>
                                </div>
                                <div class="col-md-8">
                                    <select id="maintStatus" name="maintStatus" class="form-select shadow" required>
                                        <option value="" disabled selected>Choose the status...</option>
                                        <option value="On-going">On-going</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Row 5: Maintenance Cost -->
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-4 text-md-end">
                                    <label for="maintenancecost" class="form-label">Maintenance Cost:</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="maintCost" name="maintCost" placeholder="Enter the cost..." class="form-control shadow" required>
                                </div>
                            </div>
                            <!-- Submit Button -->
                            <div class="displayflex">
                                <input type="submit" id="create-new-maintenance" name="create-new-maintenance" class="btn-var-2" value="Add">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
                
                ';
    }

    public static function maintenance_content(){
        echo '
        
         <div class="billings-content">
        <div class="direction-column">
            <div class="tab-container" >
                <div class="tab-box">
                    <button class="tab-btn active">On-going</button>
                    <button class="tab-btn">Completed</button>
                    <button class="tab-btn">Cancelled</button>
                    <div class="line"></div>
                </div>
                <div class="content-box">
                ';
                    self::On_going_table_data();
                    self::Completed_table_data();
                    self::Canceled_table_data();
                    
                
    }

    public static function On_going_table_data() {
        // Fetch the "On-going" maintenance data.
        $On_going = MaintenanceController::get_On_going_data();
        echo '<script> console.log(' . json_encode($On_going) . ') </script>';
    
        // Begin the HTML output.
        echo '
        <!-- On-going -->
        <div class="content active">
            <div class="table-section styled-table">
                <div class="table-cont-1">
                    <div class="table-cont-1-1">
                        <span>Sort By</span>
                        <button class="blue-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Category</button>
                    </div>
    
                    <button class="search">Search <span class="search-icon"><i class="fas fa-search"></i></span></button>
                </div>
    
                <table>
                    <thead>
                        <tr>
                            <th>Room Code</th>
                            <th>Cost</th>
                            <th>More</th>
                            <th>Reason</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
    
        // Loop through the fetched data and create a table row for each record.
        foreach ($On_going as $maintenance) {
            echo '
            <tr>
                <td>' . htmlspecialchars($maintenance['roomID']) . '</td>
                <td>' . htmlspecialchars(number_format($maintenance['maintCost'], 2)) . '</td>
                <td>See more...</td>
                <td>' . htmlspecialchars($maintenance['maintDesc']) . '</td>
                <td>' . htmlspecialchars(date("F j, Y", strtotime($maintenance['maintDate']))) . '</td>
                <td class="action-buttons">
                    <button id="openEditModalBtn" style="margin-right: 10px; border: none;"
                        onclick="displayeditModal(\'' . htmlspecialchars($maintenance['maintID']) . '\',
                                                  \'' . htmlspecialchars($maintenance['roomID']) . '\', 
                                                  \'' . htmlspecialchars($maintenance['maintDate']) . '\', 
                                                  \'' . htmlspecialchars($maintenance['maintStatus']) . '\', 
                                                  \'' . htmlspecialchars($maintenance['maintDesc']) . '\', 
                                                  \'' . htmlspecialchars($maintenance['maintCost']) . '\')"
                        data-bs-toggle="modal" data-bs-target="#edit-modal-info">
                        <img src="/images/icons/Residents/edit.png" alt="Edit" class="action">
                    </button>
                    <button id="openDeleteModalBtn" style="margin-right: 10px; border: none;" onclick="displaydeleteModal(\'' . htmlspecialchars($maintenance['maintID']) . '\')">
                        <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#DeletemyModal">
                    </button>
                </td>
            </tr>';
        }
    
        // Close the HTML tags.
        echo '
                </tbody>
            </table>
        </div>
    </div>';
    }

    public static function Completed_table_data() {
        // Fetch the "Completed" maintenance data.
        $completed = MaintenanceController::get_completed_data();
        echo '<script> console.log(' . json_encode($completed) . ') </script>';
    
        // Begin the HTML output.
        echo '
        <!-- Completed -->
        <div class="content">
            <div class="table-section styled-table">
                <div class="table-cont-1">
                    <div class="table-cont-1-1">
                        <span>Sort By</span>
                        <button class="blue-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Category</button>
                    </div>
                    <button class="search">Search <span class="search-icon"><i class="fas fa-search"></i></span></button>
                </div>
    
                <table>
                    <thead>
                        <tr class ="completed">
                            <th>Room Code</th>
                            <th>Cost</th>
                            <th>More</th>
                            <th>Reason</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
    
        // Loop through the fetched data and create a table row for each record.
        foreach ($completed as $maintenance) {
            echo '
            <tr>
                <td>' . htmlspecialchars($maintenance['roomID']) . '</td>
                <td>' . htmlspecialchars(number_format($maintenance['maintCost'], 2)) . '</td>
                <td>See more...</td>
                <td>' . htmlspecialchars($maintenance['maintDesc']) . '</td>
                <td>' . htmlspecialchars(date("F j, Y", strtotime($maintenance['maintDate']))) . '</td>
                <td class="action-buttons">
                    <button id="openEditModalBtn" style="margin-right: 10px; border: none;"
                        onclick="displayeditModal(\'' . htmlspecialchars($maintenance['maintID']) . '\',
                                                  \'' . htmlspecialchars($maintenance['roomID']) . '\', 
                                                  \'' . htmlspecialchars($maintenance['maintDate']) . '\', 
                                                  \'' . htmlspecialchars($maintenance['maintStatus']) . '\', 
                                                  \'' . htmlspecialchars($maintenance['maintDesc']) . '\', 
                                                  \'' . htmlspecialchars($maintenance['maintCost']) . '\')"
                        data-bs-toggle="modal" data-bs-target="#edit-modal-info">
                        <img src="/images/icons/Residents/edit.png" alt="Edit" class="action">
                    </button>
                    <button id="openDeleteModalBtn" style="margin-right: 10px; border: none;" onclick="displaydeleteModal(\'' . htmlspecialchars($maintenance['maintID']) . '\')">
                        <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#DeletemyModal">
                    </button>
                </td>
            </tr>';
        }
    
        // Close the HTML tags.
        echo '
                    </tbody>
                </table>
            </div>
        </div>';
    }

    public static function Canceled_table_data() {
        // Fetch the "Canceled" maintenance data.
        $cancelled = MaintenanceController::get_canceled_data();
        echo '<script> console.log(' . json_encode($cancelled) . ') </script>';
    
        // Begin the HTML output.
        echo '
        <!-- Canceled -->
        <div class="content">
            <div class="table-section styled-table">
                <div class="table-cont-1">
                    <div class="table-cont-1-1">
                        <span>Sort By</span>
                        <button class="blue-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Category</button>
                    </div>
                    <button class="search">Search <span class="search-icon"><i class="fas fa-search"></i></span></button>
                </div>
    
                <table>
                    <thead>
                        <tr class="canceled">
                            <th>Room Code</th>
                            <th>Cost</th>
                            <th>More</th>
                            <th>Reason</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
    
        // Loop through the fetched data and create a table row for each record.
        foreach ($cancelled as $maintenance) {
            echo '
            <tr>
                <td>' . htmlspecialchars($maintenance['roomID']) . '</td>
                <td>' . htmlspecialchars(number_format($maintenance['maintCost'], 2)) . '</td>
                <td>See more...</td>
                <td>' . htmlspecialchars($maintenance['maintDesc']) . '</td>
                <td>' . htmlspecialchars(date("F j, Y", strtotime($maintenance['maintDate']))) . '</td>
                <td class="action-buttons">
                    <button id="openEditModalBtn" style="margin-right: 10px; border: none;"
                        onclick="displayeditModal(\'' . htmlspecialchars($maintenance['maintID']) . '\',
                                                  \'' . htmlspecialchars($maintenance['roomID']) . '\', 
                                                  \'' . htmlspecialchars($maintenance['maintDate']) . '\', 
                                                  \'' . htmlspecialchars($maintenance['maintStatus']) . '\', 
                                                  \'' . htmlspecialchars($maintenance['maintDesc']) . '\', 
                                                  \'' . htmlspecialchars($maintenance['maintCost']) . '\')"
                        data-bs-toggle="modal" data-bs-target="#edit-modal-info">
                        <img src="/images/icons/Residents/edit.png" alt="Edit" class="action">
                    </button>
                    <button id="openDeleteModalBtn" style="margin-right: 10px; border: none;" onclick="displaydeleteModal(\'' . htmlspecialchars($maintenance['maintID']) . '\')">
                        <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#DeletemyModal">
                    </button>
                </td>
            </tr>';
        }
    
        // Close the HTML tags.
        echo '
                    </tbody>
                </table>
            </div>
        </div>';
    }

    public static function edit_maintenance_modal(){
        $rooms = MaintenanceController::get_room(); // Fetch rooms data from database
    
        echo '
            <!-- Revision Edit MODAL -->
            <div class="modal fade" id="edit-modal-info" tabindex="-1" aria-labelledby="edit-modal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-custom">
                        <div class="modal-header bg-custom">
                            <h5 class="modal-title" id="edit-modal">Room Maintenance Information</h5>
                            <button type="button" class="btn-close" id="editCloseButton" aria-label="Close"></button>
                        </div>
                        <div class="modal-body bg-custom">
                            <form method="GET" class="modalcolumn">
                                <!-- Hidden field for maintenance ID -->
                                <input type="hidden" id="Edit-maintID" name="Edit-maintID" value="">
    
                                <!-- Row 1: Room Code -->
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-4 text-md-end">
                                        <label for="Edit-roomcode" class="form-label">Room Code:</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select id="Edit-roomID" name="Edit-roomID" class="form-control shadow" required>
                                            <option value="" disabled selected>Select a Room...</option>';
                                            foreach ($rooms as $room){
                                                $room_id = $room['roomID'];
                                                echo '<option value="' . $room_id . '">' . $room_id . '</option>';
                                            }
        echo '
                                        </select>
                                    </div>
                                </div>
                                <!-- Row 2: Date -->
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-4 text-md-end">
                                        <label for="edit-date" class="form-label">Date:</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="date" id="Edit-maintDate" name="Edit-maintDate" class="form-control shadow" required>
                                    </div>
                                </div>
                                <!-- Row 3: Reason -->
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-4 text-md-end">
                                        <label for="edit-reason" class="form-label">Reason:</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" id="Edit-maintDesc" name="Edit-maintDesc" placeholder="Enter a reason..." class="form-control shadow" required>
                                    </div>
                                </div>
                                <!-- Row 4: Status -->
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-4 text-md-end">
                                        <label for="edit-status" class="form-label">Status:</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select id="Edit-maintStatus" name="Edit-maintStatus" class="form-select shadow" required>
                                            <option value="" disabled selected>Choose the status...</option>
                                            <option value="On-going">On-going</option>
                                            <option value="Completed">Completed</option>
                                            <option value="Canceled">Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Row 5: Maintenance Cost -->
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-4 text-md-end">
                                        <label for="edit-maintenance-cost" class="form-label">Maintenance Cost:</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" id="Edit-maintCost" name="Edit-maintCost" placeholder="Enter the cost..." class="form-control shadow" required>
                                    </div>
                                </div>
                                <!-- Submit Button -->
                                <div class="displayflex">
                                    <input type="submit" name="edit-maintenance-submit" class="btn-var-2" value="Save">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }

    public static function delete_maintenance_modal(){
        echo '
        
            <!-- Delete Modal Revision -->
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
                            <form id="deleteMaintenanceForm"  method="GET">
                                <!-- Hidden input to store the maintenance ID -->
                                <input type="hidden" id="deleteMaintID" name="deleteMaintID" value="">
                                
                                <div class="displayflex">
                                    <input type="submit" name="delete-maintenance-submit" id="Yesdelete" class="btn-var-2 ms-4 me-4" value="Yes">
                                    <input type="button" name="No" id="Nodelete" class="btn-var-2 ms-4 me-4" value="No" data-bs-dismiss="modal" aria-label="Close">
                                </div>
                            </form>

                        </div>
                        <div class="displayflex bg-custom label" style="border-radius: 10px;">
                            <span>Note: Once you have clicked "Yes", this action cannot be undone.</span>
                        </div>
                        <div class="modal-footer"></div>
                    </div>
                </div>
            </div>
        ';
    }

    
}

?>