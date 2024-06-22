<?php
    require '../php/templates.php';
    html_start('room_logs.css');
?>

<!-- Sidebar -->
<?php require '../php/navbar.php'; ?>

<!-- Burger Sidebar -->
<div class="hamburger-sidebar">
    <i class="fa-solid fa-bars"></i>
</div>

<!-- Room Logs Section -->
<div class="container-fluid">

    <!-- Header -->
    <div class="header-container" >
        <span class="page-header">Room Logs</span><br>
    </div>

    <!-- Room Log Actions -->
    <div class="rm-log-button">
        <button class="show-avail-rm-btn">Show Available Rooms</button>
        <button type="button" data-bs-toggle="modal" data-bs-target="#add-new-rm">Add New Room</button>
    </div>

    <!-- Room Information -->
    <div class="row rm-container">
        <div class="col-auto">
            <div class="rm-info-container">
                <div class="rm-info-head">
                    <span class="rm-info-code">B10101</span>
                    <i class="fa-solid fa-circle" style="color: #ff0000;"></i>
                    <i type="button" class="fa-solid fa-ellipsis" style="color: #C7D5DD" data-bs-toggle="modal" 
                    data-bs-target="#rm-info-modal"></i>
                </div>
                <div>
                    <span class="rm-info-avail">Not Available</span><br>
                    <span class="rm-info-status" style="color: #ff0000">FULLY OCCUPIED</span> 
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="rm-info-container">
                <div class="rm-info-head">
                    <span class="rm-info-code">B10102</span>
                    <i class="fa-solid fa-circle" style="color: #FF8D23;"></i>
                    <i type="button" class="fa-solid fa-ellipsis" style="color: #C7D5DD" data-bs-toggle="modal" 
                    data-bs-target="#rm-info-modal"></i>
                </div>
                <div>
                    <span class="rm-info-avail">Available (BS only)</span><br>
                    <span class="rm-info-status" style="color: #FF8D23">2/6</span> 
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="rm-info-container">
                <div class="rm-info-head">
                    <span class="rm-info-code">B10201</span>
                    <i class="fa-solid fa-circle" style="color: #ff0000;"></i>
                    <i type="button" class="fa-solid fa-ellipsis" style="color: #C7D5DD" data-bs-toggle="modal" 
                    data-bs-target="#rm-info-modal"></i>
                </div>
                <div>
                    <span class="rm-info-avail">Not Available</span><br>
                    <span class="rm-info-status" style="color: #ff0000">FULLY OCCUPIED</span> 
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="rm-info-container">
                <div class="rm-info-head">
                    <span class="rm-info-code">B10202</span>
                    <i class="fa-solid fa-circle" style="color: #00BA00;"></i>
                    <i type="button" class="fa-solid fa-ellipsis" style="color: #C7D5DD" data-bs-toggle="modal" 
                    data-bs-target="#rm-info-modal"></i>
                </div>
                <div>
                    <span class="rm-info-avail">Available</span><br>
                    <span class="rm-info-status" style="color: #00BA00">NOT OCCUPIED</span> 
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="rm-info-container">
                <div class="rm-info-head">
                    <span class="rm-info-code">B10202</span>
                    <i class="fa-solid fa-circle" style="color: #00BA00;"></i>
                    <i type="button" class="fa-solid fa-ellipsis" style="color: #C7D5DD" data-bs-toggle="modal" 
                    data-bs-target="#rm-info-modal"></i>
                </div>
                <div>
                    <span class="rm-info-avail">Available</span><br>
                    <span class="rm-info-status" style="color: #00BA00">NOT OCCUPIED</span> 
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="rm-info-container">
                <div class="rm-info-head">
                    <span class="rm-info-code">B10202</span>
                    <i class="fa-solid fa-circle" style="color: #00BA00;"></i>
                    <i type="button" class="fa-solid fa-ellipsis" style="color: #C7D5DD" data-bs-toggle="modal" 
                    data-bs-target="#rm-info-modal"></i>
                </div>
                <div>
                    <span class="rm-info-avail">Available</span><br>
                    <span class="rm-info-status" style="color: #00BA00">NOT OCCUPIED</span> 
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="rm-info-container">
                <div class="rm-info-head">
                    <span class="rm-info-code">B10202</span>
                    <i class="fa-solid fa-circle" style="color: #00BA00;"></i>
                    <i type="button" class="fa-solid fa-ellipsis" style="color: #C7D5DD" data-bs-toggle="modal" 
                    data-bs-target="#rm-info-modal"></i>
                </div>
                <div>
                    <span class="rm-info-avail">Available</span><br>
                    <span class="rm-info-status" style="color: #00BA00">NOT OCCUPIED</span> 
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="rm-info-container">
                <div class="rm-info-head">
                    <span class="rm-info-code">B10202</span>
                    <i class="fa-solid fa-circle" style="color: #00BA00;"></i>
                    <i type="button" class="fa-solid fa-ellipsis" style="color: #C7D5DD" data-bs-toggle="modal" 
                    data-bs-target="#rm-info-modal"></i>
                </div>
                <div>
                    <span class="rm-info-avail">Available</span><br>
                    <span class="rm-info-status" style="color: #00BA00">NOT OCCUPIED</span> 
                </div>
            </div>
        </div>
    </div>
        
</div>

<!-- Room Information Modal -->
<div class="modal fade" id="rm-info-modal" tabindex="-1" aria-labelledby="room-information" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="rm-modal-title" id="room-information">Room Information</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div>
                <p class="rm-modal-info">Room Code: <span>B10101</span> </p>
                <p class="rm-modal-info">Availability: <span>Not Available</span></p>
                <p class="rm-modal-info">Status: <span>Fully Occupied</span></p>
            </div>
            <div class="rm-occupants">
                <p class="rm-modal-info">Occupants: </p>
                <table>
                    <thead>
                        <tr>
                            <th>Tenant Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Maria P. Detablurs</td>
                            <td>January 9, 2024</td>
                            <td>December 9, 2024</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
</div> 

<!-- Add New Room Modal -->
<div class="modal fade" id="add-new-rm" tabindex="-1" aria-labelledby="add-new-rm-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content m-5">
        <div class="modal-header">
            <h3 class="rm-modal-title" id="add-new-rm-modal">Add New Room</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post">
            <div class="modal-body">
                <div class="row-fluid d-flex justify-content-between">
                    <div class="d-flex flex-column justify-content-evenly w-50">
                        <label for="add-new-rm-code" class="input-label my-3">Room Code: </label>
                        <label for="add-new-rm-cap" class="input-label my-3">Room Capacity: </label>
                    </div>
                    <div class="d-flex flex-column justify-content-evenly w-50">
                        <input type="text" name="add-new-rm-code" id="add-new-rm-code" placeholder="Enter room code..." class="my-3 shadow w-100"><br>
                        <input type="number" name="add-new-rm-cap" id="add-new-rm-cap" placeholder="Enter room capacity..." class="my-3 shadow w-100">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn-var-4">Add</button>
            </div>
        </form>
    </div>
    </div>
</div>

<script src="/js/general.js"></script>

<?php html_end(); ?>