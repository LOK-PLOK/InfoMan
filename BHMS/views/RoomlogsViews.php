<?php

require_once 'GeneralViews.php';
require_once '../controllers/RoomlogsController.php';

RoomlogsController::rentCountUpdater();

class RoomlogsViews extends GeneralViews{

    public static function room_logs_header() {
        echo <<<HTML
            <div class="header-container" >
                <span class="page-header">Room Logs</span><br>
            </div>
        HTML;
    }

    public static function room_info_cards() {

        $rooms = RoomlogsController::all_rooms();
    
        foreach ($rooms as $room) {
            
            $avail_color = '';
            $availability = '';
            $avail_info = '';
            
            if (intval($room['rentCount']) == intval($room['capacity'])) {
                $avail_color = '#ff0000';
                $availability = 'Not Available';
                $avail_info = 'FULLY OCCUPIED';
            } 
            else if (intval($room['rentCount']) < intval($room['capacity']) && intval($room['rentCount']) > 0) {
                $avail_color = '#ff8d23';
                $availability = 'Available (BS only)';
                $avail_info = htmlspecialchars($room['rentCount']) . '/' . htmlspecialchars($room['capacity']);
            } 
            else {
                $avail_color = '#00ba00';
                $availability = 'Available';
                $avail_info = 'NOT OCCUPIED';
            }
    
            $roomID = htmlspecialchars($room['roomID']);
    
            echo '
                <div class="col-auto">
                    <div class="rm-info-container">
                        <div class="rm-info-head">
                            <span class="rm-info-code">'.$roomID.'</span>
                            <i class="fa-solid fa-circle" style="color: '.$avail_color.';"></i>
                            <i type="button" class="fa-solid fa-ellipsis" style="color: #c7d5dd" data-bs-toggle="modal" 
                            data-bs-target="#rm-info-modal-'.$roomID.'"></i>
                        </div>
                        <div>
                            <span class="rm-info-avail">'.$availability.'</span><br>
                            <span class="rm-info-status" style="color: '.$avail_color.'">'.$avail_info.'</span> 
                        </div>
                    </div>
                </div>
            ';
        }
    }
    
    public static function room_info_modal() {
        $rooms = RoomlogsController::all_rooms();
    
        foreach ($rooms as $room) {
            $availability = '';
            $avail_info = '';
    
            if (intval($room['rentCount']) == intval($room['capacity'])) {
                $availability = 'Not Available';
                $avail_info = 'FULLY OCCUPIED';
            } 
            else if (intval($room['rentCount']) < intval($room['capacity']) && intval($room['rentCount']) > 0) {
                $availability = 'Available (BS only)';
                $avail_info = htmlspecialchars($room['rentCount']) . '/' . htmlspecialchars($room['capacity']);
            } 
            else {
                $availability = 'Available';
                $avail_info = 'NOT OCCUPIED';
            }

            $roomID = htmlspecialchars($room['roomID']);
            $room_tenants = RoomlogsController::room_tenants($roomID);
    
            echo '<script>console.log(' . json_encode($room_tenants) . ');</script>';
    
            echo <<<HTML
                <div class="modal fade" id="rm-info-modal-{$roomID}" tabindex="-1" aria-labelledby="room-information" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="rm-modal-title" id="room-information">Room Information</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div>
                                    <p class="rm-modal-info">Room Code: <span>{$roomID}</span> </p>
                                    <p class="rm-modal-info">Availability: <span>{$availability}</span></p>
                                    <p class="rm-modal-info">Status: <span>{$avail_info}</span></p>
                                </div>
                                <div class="rm-occupants">
                                    <p class="rm-modal-info">Occupants: </p>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Tenant Name</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
            HTML;
    
            foreach ($room_tenants as $room_tenant) {
                $rm_tenant_info = RoomlogsController::room_tenant_info($room_tenant['tenID']);

                $rm_tenFname = htmlspecialchars($rm_tenant_info['tenFname']);
                $rm_tenLname = htmlspecialchars($rm_tenant_info['tenLname']);
                $rm_tenMI = htmlspecialchars($rm_tenant_info['tenMI']);

                $name = $rm_tenFname . ' ' . $rm_tenMI . '. ' . $rm_tenLname;
                $start_date = date('F j, Y', strtotime($room_tenant['occDateStart']));
                $end_date = date('F j, Y', strtotime($room_tenant['occDateEnd']));

                // Determine the background color based on the isRenting status
                $bgColor = $rm_tenant_info['isRenting'] ? '#00ba00' : '#c7d5dd';

                echo '
                    <tr>
                        <td style="background-color: '.$bgColor.';">'.$name.'</td>
                        <td style="background-color: '.$bgColor.';">'.$start_date.'</td>
                        <td style="background-color: '.$bgColor.';">'.$end_date.'</td>
                        <td style="background-color: '.$bgColor.';">
                            <button class="editOccupancyBtn" style="margin-right: 10px; border: none; background: transparent;" value="'.$room_tenant['occupancyID'].'">
                                <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#editOccupancyModal">
                            </button>
                            <button class="deleteOccupancyBtn" style="margin-right: 10px; border: none; background: transparent;" value="'.$room_tenant['occupancyID'].'">
                                <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#deleteOccupancyModal">
                            </button>
                        </td>
                        </td>
                    </tr>
                ';
            }
    
            echo <<<HTML
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            HTML;

        }
    }

    public static function editOccupancyModal($occupancyID) {
        
        $rooms = RoomlogsController::all_rooms();
        $occupancy_data = RoomlogsController::get_occupancy($occupancyID);
        $tenant = RoomlogsController::room_tenant_info($occupancy_data['tenID']);

        $occ_type = RoomlogsController::get_occ_type($occupancy_data['occTypeID']);
        $name = htmlspecialchars($tenant['tenFname'] . ' ' . $tenant['tenMI'] . '. ' . $tenant['tenLname'], ENT_QUOTES);
        $occDateStart = htmlspecialchars($occupancy_data['occDateStart'], ENT_QUOTES);
        $occDateEnd = htmlspecialchars($occupancy_data['occDateEnd'], ENT_QUOTES);
        $occupancyRate = htmlspecialchars($occupancy_data['occupancyRate'], ENT_QUOTES);

        echo <<<HTML
            <div class="modal fade" id="editOccupancyModal" tabindex="-1" aria-labelledby="editOccupancyModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered d-flex justify-content-center align-items-center">
            <form method="POST">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-rent-modal">Edit Rent</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                
                    <div>
                        <div>
                            <label for="edit-rent-tenant" class="input-label">Tenant Assigned:</label>
                            <select name="edit-rent-tenant" id="edit-rent-tenant" class="w-100 shadow">
                                <option value="{$occupancy_data['tenID']}" disabled selected>{$name}</option>
                            </select>
                            <div class="d-flex justify-content-center input-sub-label">Name</div>
                        </div>
                        <div class="row-fluid">
                            <div class="col-12">
                                <label for="edit-rent-room" class="input-label">Room Details:</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="col-sm-5">
                                    <select name="edit-rent-room" id="edit-rent-room" class="w-100 shadow">
                                        <option value="{$occupancy_data['roomID']}" disabled selected>{$occupancy_data['roomID']}</option>
    HTML;
                                        foreach ($rooms as $room) {
                                            $room_id = htmlspecialchars($room['roomID'], ENT_QUOTES);
                                            echo "<option value=\"$room_id\">$room_id</option>";
                                        }       
    echo <<<HTML
                                    </select>
                                    <div class="d-flex justify-content-center input-sub-label">Room Code</div>
                                </div>
                                <div class="col-sm-5">
                                    <select name="edit-rent-type" id="edit-rent-type" class="w-100 shadow">
                                        <option value="{$occupancy_data['occupancyID']}" disabled selected>{$occ_type['occTypeName']}</option>
                                    </select>
                                    <div class="d-flex justify-content-center input-sub-label">Occupancy Type</div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="col-12">
                                <label for="edit-rent-start" class="input-label">Additional Information:</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="col-sm-5">
                                    <input type="date" name="edit-rent-start" id="edit-rent-start" class="w-100 shadow" value="$occDateStart">
                                    <input type="date" name="edit-rent-end" id="edit-rent-end" class="w-100 shadow" style="display: none" value="$occDateEnd">
                                    <div class="d-flex justify-content-center input-sub-label">Starting Date</div>
                                </div>
                                <div class="col-sm-5">
                                    <input type="number" id="edit-rent-rate" class="w-100 shadow" disabled value="$occupancyRate">
                                    <input type="hidden" name="edit-rent-rate" id="actual-edit-rent-rate" value="$occupancyRate">
                                    <div class="d-flex justify-content-center input-sub-label">Monthly Payment</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="submit" name="edit-new-rent" class="btn-var-3 add-button">Save</button>
                </div>
                </div>
            </form>
            </div>
        </div>
    HTML;
    }

    public static function deleteOccupancyModal(){
        echo <<<HTML
            <div class="modal fade" id="deleteOccupancyModal" tabindex="-1" aria-labelledby="deleteOccupancyModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-custom">
                        <div class="modal-header bg-custom">
                            <span style="font-size: 25px;">Are you sure you want to delete this occupancy?</span>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body bg-custom">
                        <form method="POST">
                            <div class="displayflex">
                                <input type="hidden" name="delete-occupancy-id" id="delete-occupancy-id">
                                <input type="submit" name="delete-occupancy-submit" class="btn-var-2 ms-4 me-4" value="Yes">
                                <input type="button" name="No" id="Nodelete" class="btn-var-2 ms-4 me-4" data-bs-dismiss="modal" value="No" style="background: red;">
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
        HTML;
    }

}

?>