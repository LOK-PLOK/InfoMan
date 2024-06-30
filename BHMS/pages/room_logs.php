<?php

ob_start();

require '../php/templates.php';
require '../views/RoomlogsViews.php';

html_start('room_logs.css');

// Sidebar
require '../php/navbar.php';

// Burger Sidebar
RoomlogsViews::burger_sidebar();

?> 

<!-- Room Logs Section -->
<div class="container-fluid">

    <!-- Header -->
    <?php RoomlogsViews::room_logs_header() ?>

    <!-- Room Log Actions -->
    <div class="rm-log-button">
        <button class="show-avail-rm-btn">Show Available Rooms</button>
        <button type="button" data-bs-toggle="modal" data-bs-target="#add-new-rm">Add New Room</button>
    </div>

    <!-- Room Information -->
    <div class="row rm-container">

    <?php
        // Code for displaying all the Room Cards
        RoomlogsViews::room_info_cards();
    ?>
        
</div> 

<!-- Room Logs Modals -->
<?php 
RoomlogsViews::room_info_modal(); 
RoomlogsViews::deleteOccupancyModal();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Deleting Occupancy
    if (isset($_POST['delete-occupancy-id'])) {

        $delOccInfo = $_POST['delete-occupancy-id'];
        // Console log the delete occupancy id
        echo "<script>console.log('Delete Occ ID: $delOccInfo');</script>";

        $result = RoomlogsController::delete_occupancy($delOccInfo);
        if ($result) {
            // Redirect to the same page or to a confirmation page after successful deletion
            header('Location: room_logs.php?deleteOccStatus=success');
            exit();
        } else {
            // Handle the error case, potentially redirecting with an error flag or displaying an error message
            header('Location: room_logs.php?deleteOccStatus=error');
            exit();
        }
    }

}
?>

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

<script>

// Add event listener for editing the button
document.querySelectorAll('.editOccupancyBtn').forEach(button => {
    button.addEventListener('click', function() {
        // Get the room ID from the button's value attribute
        const editOccId = this.value;
        console.log(`Edit Room ID: ${editOccId}`);
        
    });
});

// Looks for the button with the class 'deleteOccupancyBtn' and sets the value of the delete-occupancy-id input field
document.querySelectorAll('.deleteOccupancyBtn').forEach(button => {
    button.addEventListener('click', function() {
        const delOccInfo = this.value;
        console.log(`Delete Occ ID: ${delOccInfo}`);
        document.getElementById('delete-occupancy-id').value = delOccInfo;
    });
});

// Looks for the button with the class 'show-avail-rm-btn' and all elements with the class 'rm-info-container'
document.addEventListener('DOMContentLoaded', () => {
    const showAvailRmBtn = document.querySelector('.show-avail-rm-btn');
    const roomInfo = document.querySelectorAll('.rm-info-container');

    // Store the initial display state of each room
    const initialDisplayStates = Array.from(roomInfo).map(room => 
        window.getComputedStyle(room).display);

    // Toggle visibility on button click
    showAvailRmBtn.addEventListener('click', () => {
        let visibleRoomsCount = roomInfo.length;

        roomInfo.forEach((room, index) => {
            const availInfo = room.getElementsByClassName('rm-info-avail')[0];
            if (availInfo && availInfo.textContent === 'Not Available') {
                if (room.style.display === 'none') {
                    room.style.display = initialDisplayStates[index]; // Restore initial state
                } else {
                    room.style.display = 'none';
                    visibleRoomsCount--; // Decrement count as room is made invisible
                }
            }
        });

        // Update button text based on the count of visible rooms
        showAvailRmBtn.textContent = visibleRoomsCount === roomInfo.length ? 
            'Show Available Rooms' : 'Show All Rooms';
    });
});
</script>


<?php 

ob_end_flush();
html_end(); 

?>

