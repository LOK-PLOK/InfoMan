<?php
session_start();
ob_start();

require '../php/templates.php';
require '../views/RoomhistoryViews.php';

if($_SESSION['sessionType'] != 'admin' && $_SESSION['sessionType'] != 'dev'){
    header('Location: dashboard.php?AccessError=unauthorizedPageAttempt');    
    exit();
}

$more_links = '
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.min.css" 
integrity="sha512-wCrId7bUEl7j1H60Jcn4imkkiIYRcoyq5Gcu3bpKAZYBJXHVMmkL4rhtyhelxSFuPMIoQjiVsanrHxcs2euu/w==" crossorigin="anonymous" referrerpolicy="no-referrer"/>';

html_start('room_history.css', $more_links);

// Sidebar
require '../php/navbar.php';

// Burger Sidebar
RoomhistoryViews::burger_sidebar();


// Check if 'roomCode' is sent via GET
if (isset($_GET['roomCode'])) {
    $roomCode = $_GET['roomCode'];
    $_SESSION['roomCode'] = $roomCode; // Store 'roomCode' in session
} elseif (isset($_SESSION['roomCode'])) {
    // Retrieve 'roomCode' from session if not present in GET
    $roomCode = $_SESSION['roomCode'];
} else {
    // Default 'roomCode' if not in GET or session
    $roomCode = 'B10101';
}

if(isset($_GET['editOccStatus'])){
    if($_GET['editOccStatus'] === 'success'){
        echo '<script>showSuccessAlert("Occupancy Edited Successfully!");</script>';
    } else if($_GET['editOccStatus'] === 'error'){
        echo '<script>showFailAlert("An unexpected error has happened!");</script>';
    }
}

if(isset($_GET['deleteOccStatus'])){
    if($_GET['deleteOccStatus'] === 'success'){
        echo '<script>showSuccessAlert("Occupancy Deleted Successfully!");</script>';
    } else if($_GET['deleteOccStatus'] === 'error'){
        echo '<script>showFailAlert("An unexpected error has happened!");</script>';
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Editing Occupancy
    if(isset($_POST['edit-rent-submit'])){
        $editInfo = array(
            'occupancyID' => $_POST['edit-occupancy-id'],
            'roomID' => $_POST['edit-rent-room'],
            'occDateStart' => $_POST['edit-rent-start'],
            'occDateEnd' => $_POST['edit-rent-end'],
        );

        $result = RoomhistoryController::editOccupancy($editInfo);
        if($result){
            // Redirect to the same page or to a confirmation page after successful edit
            header('Location: room_history.php?editOccStatus=success');
            exit();
        } else {
            // Handle the error case, potentially redirecting with an error flag or displaying an error message
            header('Location: room_history.php?editOccStatus=error');
            exit();
        }
    }

    // Deleting Occupancy
    if (isset($_POST['delete-occupancy-id'])) {

        $delOccInfo = $_POST['delete-occupancy-id'];

        $result = RoomhistoryController::delete_occupancy($delOccInfo);
        if ($result) {
            // Redirect to the same page or to a confirmation page after successful deletion
            header('Location: room_history.php?deleteOccStatus=success');
            exit();
        } else {
            // Handle the error case, potentially redirecting with an error flag or displaying an error message
            header('Location: room_history.php?deleteOccStatus=error');
            exit();
        }
    }

}

?> 

<div class="container-fluid">

    <?php RoomhistoryViews::room_history_header() ?>
    <div class="d-flex align-items-center justify-content-between mt-4">
        <span class="page-header" style="font-size: 2rem">Rent History of <?php echo $roomCode ?></span>
        <div class="d-flex align-items-center justify-content-center w-25" >
            <form method="GET">
                <div class="search-container shadow">
                    <div>
                        <input class="search" type="text" value="" name="search" placeholder="Search">
                        <div class="search-icon"><i class="fas fa-search"></i></div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-2" style="max-height: 500px; overflow-y: auto;">
        <table class="rh-table rounded-corners">
            <thead class="sticky-top" style="z-index: 50;">
                <tr style="background-color: #344799;">
                    <th class="p-2">Tenant Name</th>
                    <th>Occupancy</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php

                $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
                $tenants = RoomhistoryController::room_history($roomCode, $searchTerm);
                
                if ($tenants instanceof mysqli_result) {
                    if ($tenants->num_rows === 0 && isset($_GET['search'])) {
                        // No results for a specific search term
                        echo '<tr><td colspan="5" style="text-align: center;">No results for <i>"' . htmlspecialchars($searchTerm) . '"</i></td></tr>';
                        exit();
                    } else if ($tenants->num_rows === 0) {
                        // No records found in general, not specific to a search term
                        echo '<tr><td colspan="5" style="text-align: center;">No records found</td></tr>';
                        exit();
                    }
                    // Proceed to display tenants if any are found
                } else {
                    // Handle case where $tenants is not a mysqli_result object
                    echo '<tr><td colspan="5" style="text-align: center;">Error fetching data</td></tr>';
                    exit();
                }

                foreach($tenants as $tenant) {

                    // Convert dates to a more readable format
                    $startDate = date('F d, Y', strtotime($tenant['occDateStart']));
                    $endDate = date('F d, Y', strtotime($tenant['occDateEnd']));

                    $action_buttons = '
                                <button class="editOccupancyBtn" style="margin-right: 10px; border: none; background: transparent;" data-bs-toggle="modal" data-bs-target="#editOccupancyModal" value="'.$room_tenant['occupancyID'].'"
                                    onclick="setValuesTenantInfo(
                                                        '.$tenant['occupancyID'].', 
                                                        \''.$tenant['tenantFullName'].'\', 
                                                        \''.$tenant['roomID'].'\', 
                                                        \''.$tenant['occTypeName'].'\', 
                                                        \''.$tenant['occDateStart'].'\', 
                                                        \''.$tenant['occDateEnd'].'\', 
                                                        '.number_format($tenant['occupancyRate'], 2, '.', '').'
                                                    )"
                                >
                                    <img src="/images/icons/Residents/edit.png" alt="Edit" class="action">
                                </button>
                                <button class="deleteOccupancyBtn" style="margin-right: 10px; border: none; background: transparent;" value="'.$tenant['occupancyID'].'">
                                    <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#deleteOccupancyModal">
                                </button>
                    ';  

                    echo <<<HTML
                        <tr>
                            <td style="max-width: 40px">{$tenant['tenantFullName']}</td>
                            <td style="max-width: 100px">{$tenant['occTypeName']}</td>
                            <td>{$startDate}</td>
                            <td>{$endDate}</td>
                            <td>
                               $action_buttons
                            </td>
                        </tr>
                    HTML;
                }
            ?>

            </tbody>
        </table>
    </div>

</div>



<!-- Edit Occupancy Modal -->
<?php RoomhistoryViews::editOccupancyModal() ?>

<!-- Delete Occupancy Modal -->
<?php RoomhistoryViews::deleteOccupancyModal() ?>

<script>

function setValuesTenantInfo(occupancyID, name, roomID, rentType, occDateStart, occDateEnd, rentRate) {

    rentRate = parseFloat(rentRate).toFixed(2);

    document.getElementById('edit-occupancy-id').value = occupancyID;    
    document.getElementById('edit-rent-tenant-name').value = name;
    document.getElementById('edit-rent-room').value = roomID;
    document.getElementById('edit-rent-type-name').value = rentType;
    document.getElementById('edit-rent-start').value = occDateStart;
    document.getElementById('edit-rent-end').value = occDateEnd;
    document.getElementById('edit-rent-rate').value = rentRate;

}

document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.editOccupancyBtn').forEach(button => {
        button.addEventListener('click', function() {
            const editOccInfo = this.value;
        });
    });

    // Looks for the button with the class 'deleteOccupancyBtn' and sets the value of the delete-occupancy-id input field
    document.querySelectorAll('.deleteOccupancyBtn').forEach(button => {
        button.addEventListener('click', function() {
            const delOccInfo = this.value;
            document.getElementById('delete-occupancy-id').value = delOccInfo;
        });
    });

    // End Date Setter for Edit Rent
	document.getElementById('edit-rent-start').addEventListener('change', function() {
		const startDate = new Date(this.value);

		if(!isNaN(startDate.getTime())) {
			const endDate = new Date(startDate);
			endDate.setDate(endDate.getDate() + 30);

			const endDateString = endDate.toISOString().split('T')[0];
			document.getElementById('edit-rent-end').value = endDateString;
		} else {
			alert('Invalid start date');
		}
	});

});

</script>

<?php 
ob_end_flush();
html_end(); 
?>
