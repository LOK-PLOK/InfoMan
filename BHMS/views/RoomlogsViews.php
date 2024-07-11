<?php

require_once 'GeneralViews.php';
require_once '../controllers/RoomlogsController.php';

RoomlogsController::updateTenantRentStatus();
RoomlogsController::updateRoomTenantCount();
RoomlogsController::updateRoomAvailability();


/**
 * This class contains all the views that are used in the room logs page.
 *  
 * @method room_logs_header
 * @method room_info_cards
 * @method room_info_modal
 * @method editOccupancyModal
 * @method deleteOccupancyModal
 * @method addNewRoomModal
 * @method editRoomModal
 * @method deleteRoomModal
 * @class RoomlogsViews
 */
class RoomlogsViews extends GeneralViews{


    /**
     * This method is used to display the header of the room logs page.
     * 
     * @method room_logs_header
     * @return void
     */
    public static function room_logs_header() {
        echo <<<HTML
            <div>
                <span class="page-header">Room Logs</span><br>
                <span class="page-sub-header">Keep track of room assignments and tenant activities.</span>
            </div>
        HTML;
    }


    /**
     * This method is used to display the room information cards.
     * 
     * @method room_info_cards
     * @return void
     */
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
            } else if (intval($room['rentCount']) < intval($room['capacity']) && intval($room['rentCount']) > 0 && $room['isAvailable'] == 0) {
                $avail_color = '#ff0000';
                $availability = 'Room Rented (Shared Only)';
                $avail_info = htmlspecialchars($room['rentCount']) . '/' . htmlspecialchars($room['capacity']);
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
                <div class="col-auto" data-bs-toggle="modal" data-bs-target="#rm-info-modal-'.$roomID.'">
                    <div class="rm-info-container" style="cursor: pointer;">
                        <div class="rm-info-head">
                            <span class="rm-info-code">'.$roomID.'</span>
                            <i class="fa-solid fa-circle" style="color: '.$avail_color.';"></i>
                            <i type="button" class="fa-solid fa-ellipsis" style="color: #c7d5dd"></i>
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
    

    /**
     * This method is used to display the room information modal.
     * 
     * @method room_info_modal
     * @return void
     */
    public static function room_info_modal() {
        $rooms = RoomlogsController::all_rooms();
    
        foreach ($rooms as $room) {
            $availability = '';
            $avail_info = '';
    
            if (intval($room['rentCount']) == intval($room['capacity'])) {
                $availability = 'Not Available';
                $avail_info = 'FULLY OCCUPIED';
            } else if (intval($room['rentCount']) < intval($room['capacity']) && intval($room['rentCount']) > 0 && $room['isAvailable'] == 0) {
                $availability = 'Room Rented (Shared Only)';
                $avail_info = htmlspecialchars($room['rentCount']) . ' / ' . htmlspecialchars($room['capacity']);
            } else if (intval($room['rentCount']) < intval($room['capacity']) && intval($room['rentCount']) > 0) {
                $availability = 'Available (BS only)';
                $avail_info = htmlspecialchars($room['rentCount']) . ' / ' . htmlspecialchars($room['capacity']);
            } else {
                $availability = 'Available';
                $avail_info = 'NOT OCCUPIED';
            }

            $roomID = htmlspecialchars($room['roomID']);
            $room_tenants = RoomlogsController::room_tenants($roomID); 
    
            echo <<<HTML
                <div class="modal fade" id="rm-info-modal-{$roomID}" tabindex="-1" aria-labelledby="room-information" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="rm-modal-title" id="room-information">Room Information</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="rm-modal-info">Room Code: <span>{$roomID}</span> </p>
                                        <p class="rm-modal-info">Availability: <span>{$availability}</span></p>
                                        <p class="rm-modal-info">Status: <span>{$avail_info}</span></p>
                                        <p class="rm-modal-info">Capacity: <span>{$room['rentCount']} / <span>{$room['capacity']}</span></p>
                                    </div>
                                    <div class="d-flex flex-column justify-content-around">
                                        <button type="button" class="btn-var-5 my-1 bg-danger" data-bs-toggle="modal" data-bs-target="#deleteRoomModal"
                                        onclick="delRoomID('{$roomID}')">Delete Room</button>
                                        <button type="button" class="btn-var-5 my-1" data-bs-toggle="modal" data-bs-target="#edit-rm"
                                        onclick="setValuesEditRoom('{$roomID}', '{$room['capacity']}')">Edit Room</button>
                                    </div>
                                </div>
                                <div class="rm-occupants">
                                    <p class="rm-modal-info">Occupants (Current/Old): </p>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Tenant Name</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Rent Type</th>
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

                $name = $rm_tenFname . ' ' . (($rm_tenMI != NULL) ? $rm_tenMI . '. ' : '') . $rm_tenLname;
                $start_date = date('F j, Y', strtotime($room_tenant['occDateStart']));
                $end_date = date('F j, Y', strtotime($room_tenant['occDateEnd']));

                $occType = RoomlogsController::get_occ_type($room_tenant['occTypeID']);

                // Convert occDateStart and occDateEnd to DateTime objects
                $occDateStart = new DateTime($room_tenant['occDateStart']);
                $occDateEnd = new DateTime($room_tenant['occDateEnd']);
                $currentDate = new DateTime(date('Y-m-d'));

                // Calculate the difference between occDateEnd and occDateStart
                $diff = $occDateStart->diff($occDateEnd)->days;

                // Check if occDateEnd is less than the current date and the difference is less than 30
                $rm_cell_color = ($occDateEnd < $currentDate || $diff < 30) ? '#edf6f7' : '#00ba00';

                echo '
                        <tr>
                            <td style="background-color: '.$rm_cell_color.'">'.$name.'</td>
                            <td style="background-color: '.$rm_cell_color.'">'.$start_date.'</td>
                            <td style="background-color: '.$rm_cell_color.'">'.$end_date.'</td>
                            <td style="max-width: 150px; background-color: '.$rm_cell_color.'">'.$occType['occTypeName'].'</td>
                            <td style="background-color:'.$rm_cell_color.'">
                                <button class="editOccupancyBtn" style="margin-right: 10px; border: none; background: transparent;" data-bs-toggle="modal" data-bs-target="#editOccupancyModal" value="'.$room_tenant['occupancyID'].'"
                                    onclick="setValuesTenantInfo(
                                                        '.$room_tenant['occupancyID'].', 
                                                        \''.$name.'\', 
                                                        \''.$room_tenant['roomID'].'\', 
                                                        \''.$occType['occTypeName'].'\', 
                                                        \''.$room_tenant['occDateStart'].'\', 
                                                        \''.$room_tenant['occDateEnd'].'\', 
                                                        '.number_format($room_tenant['occupancyRate'], 2, '.', '').'
                                                    )"
                                >
                                    <img src="/images/icons/Residents/edit.png" alt="Edit" class="action">
                                </button>
                                <button class="deleteOccupancyBtn" style="margin-right: 10px; border: none; background: transparent;" value="'.$room_tenant['occupancyID'].'">
                                    <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#deleteOccupancyModal">
                                </button>
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


    /**
     * This method is used to display the edit occupancy modal.
     * 
     * @method editOccupancyModal
     * @return void
     */
    public static function editOccupancyModal() {
    
            $rooms = RoomlogsController::get_rooms();
    
            echo <<<HTML
                <div class="modal fade" id="editOccupancyModal" tabindex="-1" aria-labelledby="editOccupancyModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered d-flex justify-content-center align-items-center">
                <form method="POST">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="edit-rent-modal">Edit Rent</h5>
                        <button type="button" id="editOccupancyModalCloseBtn" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    
                        <div>
                            <div>
                                <!-- Occupancy ID -->
                                <input type="hidden" name="edit-occupancy-id" id="edit-occupancy-id">
                                <label for="edit-rent-tenant" class="input-label">Tenant Assigned:</label>
                                <!-- Tenant -->
                                <input type="text" id="edit-rent-tenant-name" class="w-100 shadow" disabled>
                                <div class="d-flex justify-content-center input-sub-label">Name</div>
                            </div>
                            <div class="row-fluid">
                                <div class="col-12">
                                    <label for="edit-rent-room" class="input-label">Room Details:</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="col-sm-5">
                                        <!-- Room -->
                                        <select name="edit-rent-room" id="edit-rent-room" class="w-100 shadow">
            HTML;
                                            foreach ($rooms as $room){
                                                $room_id = $room['roomID'];
                                                echo<<<HTML
                                                    <option value="$room_id">$room_id</option>
                                                HTML;
                                            }       
    
            echo <<<HTML
                                        </select>
                                        <div class="d-flex justify-content-center input-sub-label">Room Code</div>
                                    </div>
                                    <div class="col-sm-5">
                                        <!-- Occupancy Type -->
                                        <input type="text" id="edit-rent-type-name" class="w-100 shadow" disabled>
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
                                        <!-- Start Date -->
                                        <input type="date" name="edit-rent-start" id="edit-rent-start" class="w-100 shadow">
                                        <!-- End Date -->
                                        <input type="date" name="edit-rent-end" id="edit-rent-end" class="w-100 shadow" style="display: none">
                                        <div class="d-flex justify-content-center input-sub-label">Starting Date</div>
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="number" id="edit-rent-rate" class="w-100 shadow" disabled>
                                        <!-- Rent Rate -->
                                        <input type="hidden" name="edit-rent-rate" id="actual-edit-rent-rate">
                                        <div class="d-flex justify-content-center input-sub-label">Monthly Payment</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 justify-content-center">
                        <!-- Submit Button -->
                        <button type="submit" name="edit-rent-submit" class="btn-var-3 add-button">Save</button>
                    </div>
                    </div>
                </form>
                </div>
            </div>
            HTML;
    }


    /**
     * This method is used to display the delete occupancy modal.
     * 
     * @method deleteOccupancyModal
     * @return void
     */
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
                                <input type="submit" name="delete-occupancy-submit" class="bg-danger btn-var-2 ms-4 me-4" value="Yes">
                                <input type="button" name="No" id="Nodelete" class="btn-var-2 ms-4 me-4" data-bs-dismiss="modal" value="No">
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


    /**
     * This method is used to display the add new room modal.
     * 
     * @method addNewRoomModal
     * @return void
     */
    public static function addNewRoomModal(){
        echo <<<HTML
        <div class="modal fade" id="add-new-rm" tabindex="-1" aria-labelledby="add-new-rm-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content m-5">
                    <div class="modal-header">
                        <h3 class="rm-modal-title" id="add-new-rm-modal">Add New Room</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST">
                        <div class="modal-body">
                            <div class="row-fluid d-flex justify-content-between">
                                <div class="d-flex flex-column justify-content-evenly w-50">
                                    <label for="add-new-rm-code" class="input-label my-3">Room Code: </label>
                                    <label for="add-new-rm-cap" class="input-label my-3">Room Capacity: </label>
                                </div>
                                <div class="d-flex flex-column justify-content-evenly w-50">
                                    <!-- roomID -->
                                    <input type="text" name="add-new-rm-code" id="add-new-rm-code" placeholder="Enter room code..." class="my-3 shadow w-100" value="B"><br>
                                    <!-- capacity -->
                                    <input type="number" name="add-new-rm-cap" id="add-new-rm-cap" placeholder="Enter room capacity..." class="my-3 shadow w-100">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 justify-content-center">
                            <button type="submit" name="add-room-submit" class="btn-var-4">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        HTML;
    }


    /**
     * This method is used to display the edit room modal.
     * 
     * @method editRoomModal
     * @return void
     */
    public static function editRoomModal(){
        echo <<<HTML
        <div class="modal fade" id="edit-rm" tabindex="-1" aria-labelledby="edit-rm" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content m-5">
                    <div class="modal-header">
                        <h3 class="rm-modal-title" id="edit-rm-modal">Edit Room</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST">
                        <div class="modal-body">
                            <div class="row-fluid d-flex justify-content-between">
                                <div class="d-flex flex-column justify-content-evenly w-50">
                                    <label for="edit-rm-code" class="input-label my-3">Room Code: </label>
                                    <label for="edit-rm-cap" class="input-label my-3">Room Capacity: </label>
                                </div>
                                <div class="d-flex flex-column justify-content-evenly w-50">
                                    <!-- roomID -->
                                    <input type="text" name="edit-rm-code" id="edit-rm-code" placeholder="Enter room code..." class="my-3 shadow w-100"><br>
                                    <input type="hidden" name="edit-rm-code-hidden" id="edit-rm-code-hidden">
                                    <!-- capacity -->
                                    <input type="number" name="edit-rm-cap" id="edit-rm-cap" placeholder="Enter room capacity..." class="my-3 shadow w-100">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 justify-content-center">
                            <button type="submit" name="edit-room-submit" class="btn-var-4">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        HTML;
    }


    /**
     * This method is used to display the delete room modal.
     * 
     * @method deleteRoomModal
     * @return void
     */
    public static function deleteRoomModal(){
        echo <<<HTML
            <div class="modal fade" id="deleteRoomModal" tabindex="-1" aria-labelledby="deleteRoomModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-custom">
                        <div class="modal-header bg-custom">
                            <span style="font-size: 25px;">Are you sure you want to delete this room?</span>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body bg-custom">
                        <form method="POST">
                            <div class="displayflex">
                                <input type="hidden" name="delete-room-id" id="delete-room-id">
                                <input type="submit" name="delete-room-submit" class="btn-var-2 ms-4 me-4 bg-danger" value="Yes">
                                <input type="button" id="Nodelete" class="btn-var-2 ms-4 me-4" data-bs-dismiss="modal" value="No">
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

    /**
     * Displays the create new rent modal
     * 
     * @method create_new_rent_modal
     * @param none
     * @return void
     */
    public static function create_new_rent_modal() {
        $tenants = RoomlogsController::get_tenants();
        $rooms = RoomlogsController::get_rooms();
        $rent_types = RoomlogsController::get_types();

        echo <<<HTML
            <div class="modal fade" id="addNewRent" tabindex="-1" aria-labelledby="addNewRent" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered d-flex justify-content-center align-items-center">
            <form method="POST">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewRent">Add New Rent</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div>
                            <label for="new-rent-tenant" class="input-label">Tenant Assigned:</label>
                            <!-- Tenant -->
                            <select name="new-rent-tenant" id="new-rent-tenant" class="w-100 shadow">
                                <option value="" disabled selected>Select a tenant...</option>
        HTML;
                                foreach ($tenants as $tenant){
                                    $tenant_id = $tenant['tenID'];
                                    $tenant_fName = $tenant['tenFname'];
                                    $tenant_MI = $tenant['tenMI'];
                                    $tenant_lName = $tenant['tenLname'];
                                    $tenant_fullName = $tenant_fName.' '. ($tenant_MI != '' ? $tenant_MI . '. ' : '' ) .$tenant_lName;
                                    echo<<<HTML
                                        <option value="$tenant_id">$tenant_fullName</option>
                                    HTML;
                                }                         
        echo <<<HTML
                            </select>
                            <div id="shared-tenant" style="display: none;">
                                <label for="share-new-rent-tenant" class="input-label">Choose a tenant to share with:</label>
                                <!-- Shared Tenant -->
                                <select name="share-new-rent-tenant" id="share-new-rent-tenant" class="w-100 shadow">
                                    <option value="" disabled selected>Select a tenant...</option>
            HTML;
                                    foreach ($tenants as $tenant){
                                        $tenant_id = $tenant['tenID'];
                                        $tenant_fName = $tenant['tenFname'];
                                        $tenant_MI = $tenant['tenMI'];
                                        $tenant_lName = $tenant['tenLname'];
                                        $tenant_fullName = $tenant_fName.' '. ($tenant_MI != '' ? $tenant_MI . '. ' : '' ) . $tenant_lName;
                                        echo<<<HTML
                                            <option value="$tenant_id">$tenant_fullName</option>
                                        HTML;
                                    }                         
            echo <<<HTML
                                </select>
                            </div>
                            <div class="d-flex justify-content-center input-sub-label">Name</div>
                        </div>
                        <div class="row-fluid">
                            <div class="col-12">
                                <label for="new-rent-room" class="input-label">Room Details:</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="col-sm-5">
                                    <!-- Room -->
                                    <select name="new-rent-room" id="new-rent-room" class="w-100 shadow">
                                        <option value="" disabled selected>Select a Room...</option>
        HTML;
                                        foreach ($rooms as $room){
                                            $room_id = $room['roomID'];
                                            $room_cap = $room['capacity'];
                                            $room_count = $room['rentCount'];
                                            $room_avail = $room['isAvailable'];

                                            if($room_avail != 0){
                                                echo<<<HTML
                                                    <option value="$room_id">$room_id: Capacity - $room_cap</option>
                                                HTML;
                                            } else if ($room_avail == 0 && $room_count < $room_cap) {
                                                echo<<<HTML
                                                    <option value="$room_id">$room_id: Capacity - $room_cap - Shared Only</option>
                                                HTML;
                                            } else {
                                                echo<<<HTML
                                                    <option value="$room_id" disabled>$room_id: Capacity - $room_cap - Full</option>
                                                HTML;
                                            }
                                        }       

        echo <<<HTML
                                    </select>
                                    <div class="d-flex justify-content-center input-sub-label">Room Code</div>
                                </div>
                                <div class="col-sm-5">
                                    <!-- Occupancy Type -->
                                    <input type="hidden" name="new-rent-occTypeID" id="new-rent-occ-typeID" class="w-100 shadow">
                                    <select name="new-rent-type" id="new-rent-type" class="w-100 shadow">
                                            <option value="" disabled selected>Select a Type...</option>
        HTML;
                                            foreach ($rent_types as $rent_type){
                                                $occTypeID = $rent_type['occTypeID'];
                                                $occTypeName = $rent_type['occTypeName'];
                                                $occRate = $rent_type['occRate'];
                                                $combinedValue = $occTypeID . '|' . $occRate;
                                                echo<<<HTML
                                                    <option value="$combinedValue">$occTypeName</option>
                                                HTML;
                                            }
        echo <<<HTML
                                    </select>
                                    
                                    <div class="d-flex justify-content-center input-sub-label">Occupancy Type</div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="col-12">
                                <label for="new-rent-start" class="input-label">Additional Information:</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="col-sm-5">
                                    <!-- Start Date -->
                                    <input type="date" name="new-rent-start" id="new-rent-start" class="w-100 shadow">
                                    <!-- End Date -->
                                    <input type="date" name="new-rent-end" id="new-rent-end" class="w-100 shadow" style="display: none">
                                    <div class="d-flex justify-content-center input-sub-label">Starting Date</div>
                                </div>
                                <div class="col-sm-5">
                                    <input type="number" id="new-rent-rate" class="w-100 shadow" disabled>
                                    <!-- Rent Rate -->
                                    <input type="hidden" name="new-rent-rate" id="actual-new-rent-rate">
                                    <div class="d-flex justify-content-center input-sub-label">Monthly Payment</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <!-- Submit Button -->
                    <button type="submit" name="create-new-rent" class="btn-var-3 add-button">Add</button>
                </div>
                </div>
            </form>
            </div>
            </div>
        HTML;
    }
}

?>