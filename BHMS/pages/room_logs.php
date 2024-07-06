<?php
session_start();
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
RoomlogsViews::editOccupancyModal();
RoomlogsViews::addNewRoomModal();
RoomlogsViews::editRoomModal();
RoomlogsViews::deleteRoomModal();

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Adding New Room
    if(isset($_POST['add-room-submit'])){
        $newRoomInfo = array(
            'roomID' => $_POST['add-new-rm-code'],
            'capacity' => $_POST['add-new-rm-cap'],
        );

        $result = RoomlogsController::addNewRoom($newRoomInfo);
        if($result){
            // Redirect to the same page or to a confirmation page after successful addition
            header('Location: room_logs.php?addRoomStatus=success');
            exit();
        } else {
            // Handle the error case, potentially redirecting with an error flag or displaying an error message
            header('Location: room_logs.php?addRoomStatus=error');
            exit();
        }
    }

    // Editing Room
    if(isset($_POST['edit-room-submit'])){
        $editRoomInfo = array(
            'roomID' => $_POST['edit-rm-code-hidden'],
            'capacity' => $_POST['edit-rm-cap'],
        );

        $result = RoomlogsController::editRoom($editRoomInfo);
        if($result){
            // Redirect to the same page or to a confirmation page after successful edit
            header('Location: room_logs.php?editRoomStatus=success');
            exit();
        } else {
            // Handle the error case, potentially redirecting with an error flag or displaying an error message
            header('Location: room_logs.php?editRoomStatus=error');
            exit();
        }
    }

    // Deleting Room
    if(isset($_POST['delete-room-submit'])){
        $delRoomInfo = $_POST['delete-room-id'];

        $result = RoomlogsController::deleteRoom($delRoomInfo);
        if($result){
            // Redirect to the same page or to a confirmation page after successful deletion
            header('Location: room_logs.php?deleteRoomStatus=success');
            exit();
        } else {
            // Handle the error case, potentially redirecting with an error flag or displaying an error message
            header('Location: room_logs.php?deleteRoomStatus=error');
            exit();
        }
    }

    // Editing Occupancy
    if(isset($_POST['edit-rent-submit'])){
        $editInfo = array(
            'occupancyID' => $_POST['edit-occupancy-id'],
            'roomID' => $_POST['edit-rent-room'],
            'occDateStart' => $_POST['edit-rent-start'],
            'occDateEnd' => $_POST['edit-rent-end'],
        );

        $result = RoomlogsController::editOccupancy($editInfo);
        if($result){
            // Redirect to the same page or to a confirmation page after successful edit
            header('Location: room_logs.php?editOccStatus=success');
            exit();
        } else {
            // Handle the error case, potentially redirecting with an error flag or displaying an error message
            header('Location: room_logs.php?editOccStatus=error');
            exit();
        }
    }
    
    // Deleting Occupancy
    if (isset($_POST['delete-occupancy-id'])) {

        $delOccInfo = $_POST['delete-occupancy-id'];

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

<script src="../js/roomLogsGeneral.js"></script>

<?php 
ob_end_flush();
html_end(); 
?>

