<?php
    require '../php/templates.php';
    html_start('maintenance.css');
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
            <span class="page-header">Maintenance</span><br>
        </div>
        <button type="button" class="btn-var-1 bg-btn" data-bs-toggle="modal" data-bs-target="#add-modal-info">
            <img src="/images/icons/Residents/add_new_light.png" alt=""> Add Maintenance
        </button>
    </div>
    
    <!-- Overview -->

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

                    <!-- On-going -->
                    <div class="content active">
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
                                <tr>
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
                                    <td>B10101</td>
                                    <td>250.00</td>
                                    <td>See more...</td>
                                    <td>Door Repair</td>
                                    <td>May 20, 2024</td>

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
                                    <td>B20102</td>
                                    <td>500.00</td>
                                    <td>See more...</td>
                                    <td>General cleaning</td>
                                    <td>May 30, 2024</td>
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

<!-- Revision Add MODAL -->
<div class="modal fade" id="add-modal-info" tabindex="-1" aria-labelledby="add-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-custom">
            <div class="modal-header bg-custom">
                <h5 class="modal-title" id="add-modal">Add Maintenance</h5>
                <button type="button" class="btn-close" id="addCloseButton" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-custom">
                <form action="/action_page.php" class="modalcolumn">
                    <!-- Row 1: Room Code -->
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-4 text-md-end">
                            <label for="roomcode" class="form-label">Room Code:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="roomcode" name="roomcode" placeholder="Enter room code..." class="form-control shadow" required>
                        </div>
                    </div>
                    <!-- Row 2: Date -->
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-4 text-md-end">
                           <label for="date" class="form-label">Date:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="date" id="date" name="date" class="form-control shadow" required>
                        </div>
                    </div>
                    <!-- Row 3: Reason -->
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-4 text-md-end">
                            <label for="reason" class="form-label">Reason:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="reason" name="reason" placeholder="Enter a reason..." class="form-control shadow" required>
                        </div>
                    </div>
                    <!-- Row 4: Status -->
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-4 text-md-end">
                            <label for="status" class="form-label">Status:</label>
                        </div>
                        <div class="col-md-8">
                            <select id="status" name="status" class="form-select shadow" required>
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
                            <input type="text" id="maintenancecost" name="maintenancecost" placeholder="Enter the cost..." class="form-control shadow" required>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="displayflex">
                        <input type="submit" class="btn-var-2" value="Add">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
                    <span style="font-size: 25px;">Are you sure you want to delete this maintenance information?</span></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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