<?php 

require 'GeneralViews.php';
require '../controllers/MaintenanceController.php';

class MaintenanceViews extends GeneralViews{

    public static function maintenance_header(){
        echo '
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
                                        <option value="Canceled">Canceled</option>
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
                    <button class="tab-btn">Canceled</button>
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
                    <button id="openEditModalBtn" style="margin-right: 10px; border: none;">
                        <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#edit-modal-info">
                    </button>
                    <button id="openDeleteModalBtn" style="margin-right: 10px; border: none;" onclick="displaydeleteModal(\'' . htmlspecialchars($maintenance['maintID']) . '\')">
                        <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#DeletemyModal">
                    </button>
                </td>
                <script>console.log(\'' . htmlspecialchars($maintenance['maintID']) . '\')</script>
            </tr>';
        
        }
    
        // Close the HTML tags.
        echo '
                    </tbody>
                </table>
    
                <span class="table-section-footer">
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
        </div>';
    
        // Echo the JavaScript code.
        
    }

    public static function Completed_table_data(){
        echo '
        
        
                    <!-- Completed -->
                    <div class="content">
                        <div class="table-section styled-table">
                            <div class="table-cont-1" >
                                <div class="table-cont-1-1">
                                    <span>Sort By</span>
                                    <button class="blue-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Category</button>
                                </div>
        
                                <button class="search" >Search <span class="search-icon"><i class="fas fa-search"></i></span></button>
                            </div>
                            
                            <table>
                                <thead>
                                <tr class="unpaid">
                                    <th>Room Code</th>
                                    <th>Cost</th>
                                    <th>More</th>
                                    <th>Reason</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>B10203</td>
                                    <td>250.00</td>
                                    <td>See more...</td>
                                    <td>Door Repair</td>
                                    <td>May 12, 2024</td>
                                    <td class="action-buttons">
                                        <button id="openEditModalBtn" style="margin-right: 10px;border: none;">
                                            <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#edit-modal-info">
                                        </button>
                                        <button id="openDeleteModalBtn" style="margin-right: 10px;border: none;">
                                            <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#DeletemyModal">
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>10102</td>
                                    <td>400.00</td>
                                    <td>See more...</td>
                                    <td>Ceiling repair</td>
                                    <td>April 26, 2024</td>
                                    <td class="action-buttons">
                                        <button id="openEditModalBtn" style="margin-right: 10px;border: none;">
                                            <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#edit-modal-info">
                                        </button>
                                        <button id="openDeleteModalBtn" style="margin-right: 10px;border: none;">
                                            <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#DeletemyModal">
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>20204</td>
                                    <td>800.00</td>
                                    <td>See more...</td>
                                    <td>Air conditioner to be fixed</td>
                                    <td>Feb 2, 2024</td>
                                    <td class="action-buttons">
                                        <button id="openEditModalBtn" style="margin-right: 10px;border: none;">
                                            <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#edit-modal-info">
                                        </button>
                                        <button id="openDeleteModalBtn" style="margin-right: 10px;border: none;">
                                            <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#DeletemyModal">
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>B20101</td>
                                    <td>200.00</td>
                                    <td>See more...</td>
                                    <td>Bed repair</td>
                                    <td>January 13, 2024</td>
                                    <td class="action-buttons">
                                        <button id="openEditModalBtn" style="margin-right: 10px;border: none;">
                                            <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#edit-modal-info">
                                        </button>
                                        <button id="openDeleteModalBtn" style="margin-right: 10px;border: none;">
                                            <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#DeletemyModal">
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>10204</td>
                                    <td>500.00</td>
                                    <td>See more...</td>
                                    <td>General cleaning</td>
                                    <td>December 7, 2023</td>
                                    <td class="action-buttons">
                                        <button id="openEditModalBtn" style="margin-right: 10px;border: none;">
                                            <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#edit-modal-info">
                                        </button>
                                        <button id="openDeleteModalBtn" style="margin-right: 10px;border: none;">
                                            <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#DeletemyModal">
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
        
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
        
        ';
    }

    public static function Canceled_table_data(){
        echo '
        
        <!-- Canceled -->
                    <div class="content">
                        <div class="table-section styled-table">
                            <div class="table-cont-1" >
                                <div class="table-cont-1-1">
                                    <span>Sort By</span>
                                    <button class="blue-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Category</button>
                                </div>
        
                                <button class="search" >Search <span class="search-icon"><i class="fas fa-search"></i></span></button>
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
                                <tbody>
                                <tr>
                                    <td>B20101</td>
                                    <td>250.00</td>
                                    <td>See more...</td>
                                    <td>Door Repair</td>
                                    <td>April 30, 2024</td>

                                    <td class="action-buttons">
                                        <button id="openEditModalBtn" style="margin-right: 10px;border: none;">
                                            <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#edit-modal-info">
                                        </button>
                                        <button id="openDeleteModalBtn" style="margin-right: 10px;border: none;">
                                            <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#DeletemyModal">
                                        </button>

                                    </td>
                                </tr>
                                <tr>
                                    <td>B10104</td>
                                    <td>500.00</td>
                                    <td>See more...</td>
                                    <td>General cleaning</td>
                                    <td>January 28, 2024</td>

                                    <td class="action-buttons">
                                        <button id="openEditModalBtn" style="margin-right: 10px;border: none;">
                                            <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#edit-modal-info">
                                        </button>
                                        <button id="openDeleteModalBtn" style="margin-right: 10px;border: none;">
                                            <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#DeletemyModal">
                                        </button>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
        
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
</div>
        
        ';
    }
}

?>