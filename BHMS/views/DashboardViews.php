<?php
require_once 'GeneralViews.php';
require_once '../controllers/DashboardController.php';

DashboardController::updateTenantRentStatus();
DashboardController::updateRoomTenantCount();
DashboardController::updateRoomAvailability();


/**
 * Dashboard related views
 *
 * @method dashboard_header
 * @method ov_total_residents
 * @method ov_bedsOcc_bedsAvail
 * @method ov_available_rooms
 * @method add_tenant_model_view
 * @method create_new_rent_modal
 * @class DashboardViews
 * @extends GeneralViews
 */
class DashboardViews extends GeneralViews{

    /**
     * Displays the dashboard header
     * 
     * @method dashboard_header
     * @param none
     * @return void
     */
    public static function dashboard_header() {
        $userData = DashboardController::fetch_user_info($_SESSION['userID']);
        echo <<<HTML
            <div class="header-container">
                <div>
                    <span class="page-header">Welcome Back, {$userData['userFname']}</span><br>
                    <span class="page-sub-header">Here's what we have for you today!</span>
                </div>
            </div>
        HTML;
    }


    /**
     * Displays the total residents in the dashboard
     * 
     * @method ov_total_residents
     * @param none
     * @return void
     */
    public static function ov_total_residents() {

        $total_current_residents = DashboardController::total_current_residents();

        echo<<<HTML
            <div class="col-auto">
                <div class="dashboard-icons shadow" style="background-color: #344799; color: white;">
                    <div>
                        <img src="/images/icons/Dashboard/Overview/user_light.png" alt="">
                        <div>{$total_current_residents}</div>
                    </div>
                    <p>Total Residents</p>
                </div>
            </div>
        HTML;
    }


    /**
     * Displays the occupied beds and available beds in the dashboard
     * 
     * @method ov_bedsOcc_bedsAvail
     * @param none
     * @return void
     */
    public static function ov_bedsOcc_bedsAvail() {

        $result = DashboardController::total_occupied_beds_and_available_beds();

        echo<<<HTML
            <div class="col-auto">
                <div class="dashboard-icons shadow">
                    <div>
                        <img src="/images/icons/Dashboard/Overview/occupied_beds_dark.png" alt="">
                        <div>{$result['occupied_beds']}</div>
                    </div>
                    <p>Occupied Beds</p>
                </div>
            </div>
        HTML;

        echo<<<HTML
            <div class="col-auto">
                <div class="dashboard-icons shadow">
                    <div>
                        <img src="/images/icons/Dashboard/Overview/available_beds_dark.png" alt="">
                        <div>{$result['available_beds']}</div>
                    </div>
                    <p>Available Beds</p>
                </div>
            </div>
        
        HTML;
    }


    /**
     * Displays the available rooms in the dashboard
     * 
     * @method ov_available_rooms
     * @param none
     * @return void
     */
    public static function ov_available_rooms() {

        $available_rooms = DashboardController::available_rooms();

        echo<<<HTML
             <div class="col-auto">
                <div class="dashboard-icons shadow">
                    <div>
                        <img src="/images/icons/Dashboard/Overview/available_rooms_dark.png" alt="">
                        <div>{$available_rooms}</div>
                    </div>
                    <p>Available Rooms</p>
                </div>
            </div> 
        HTML;
    }


    /**
     * Displays the add tenant modal
     * 
     * @method add_tenant_model_view
     * @param none
     * @return void
     */
    public static function add_tenant_model_view() {

        echo <<<HTML
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content bg-custom">
                    <div class="modal-header bg-custom">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Tenant</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-custom">
                        <form method="POST">
                            <div class="label label-position">
                                <div style="width: 65.9%;">Name:</div>
                                <div style="width: 17%;">Gender:</div>
                                <div>Birth Date:</div>
                            </div>
                            <div class="positioning">
                                <div class="NameInput">
                                    <!-- tenFname -->
                                    <input type="text" id="tenFname" name="tenFname" placeholder="Juan" class="FNclass shadow" required>
                                    <!-- tenMI -->
                                    <input type="text" id="tenMI" name="tenMI" placeholder="P" class="MIclass shadow" maxlength="1">
                                    <!-- tenLname -->
                                    <input type="text" id="tenLname" name="tenLname" placeholder="Dela Cruz" class="LNclass shadow" required>
                                </div>
                                <!-- tenGender -->
                                <select id="tenGender" name="tenGender" class="shadow">
                                    <option value="" disabled selected>...</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                                <!-- tenBdate -->
                                <input type="date" id="tenBdate" name="tenBdate" class="Bday shadow">
                            </div>
                            <div class="label label-position label-under">
                                <div class="label-fn">First Name</div>
                                <div class="label-mi">Middle Initial</div>
                                <div class="label-ln">Last Name</div>
                            </div>
                            <!-- Address -->
                            <div class="label label-position">
                                <div>Address:</div>
                            </div>
                            <div>
                                <!-- tenHouseNum -->
                                <input type="text" id="tenHouseNum" name="tenHouseNum" placeholder="1024" class="houseno shadow">
                                <!-- tenSt-->
                                <input type="text" id="tenSt" name="tenSt" placeholder="R. Palma Street" class="street shadow">
                                <!-- tenBrgy -->
                                <input type="text" id="tenBrgy" name="tenBrgy" placeholder="Adlaon" class="barangay shadow">
                                <!-- tenCityMun -->
                                <input type="text" id="tenCityMun" name="tenCityMun" placeholder="Cebu City" class="city shadow">
                                <!-- tenProvince -->
                                <input type="text" id="tenProvince" name="tenProvince" placeholder="Cebu" class="province shadow">
                            </div>
                            <div class="label label-position label-under">
                                <div class="label-houseno">House No.</div>
                                <div class="label-street">Street</div>
                                <div class="label-barangay">Barangay</div>
                                <div class="label-city">City/Municipality</div>
                                <div class="label-province">Province</div> 
                            </div>
                            <div class="label label-position">
                                <div>Contact Number:</div>
                            </div>
                            <div>
                                <input type="text" id="countrycode" placeholder="+63" class="countrycode shadow" disabled>
                                <!-- tenContact -->
                                <input type="text" id="tenContact" name="tenContact" placeholder="09XXXXXXXXX" class="number shadow" required>
                            </div>
                            <!-- Emergency Contact -->
                            <div class="header label-position">
                                <div>Emergency Contact</div>
                            </div>
                            <div class="label label-position">
                                <div style="width: 60%;">Name:</div>
                                <div>Contact Number:</div>
                            </div>
                            <div style="display: flex; justify-content:left;">
                                <div class="NameInput">
                                    <!-- emContactFname -->
                                    <input type="text" id="emContactFname" name="emContactFname" placeholder="Glydel" class="FNclass shadow">
                                    <!-- emContactMI -->
                                    <input type="text" id="emContactMI" name="emContactMI" placeholder="L" class="MIclass shadow">
                                    <!-- emContactLname -->
                                    <input type="text" id="emContactLname" name="emContactLname" placeholder="Dela Cruz" class="LNclass shadow">
                                </div>
                                <input type="text" id="ECcountrycode" name="ECcountrycode" placeholder="+63" class="countrycode shadow" style="margin-right: 4px;" disabled>
                                <!-- emContactNum -->
                                <input type="text" id="emContactNum" name="emContactNum" placeholder="09XXXXXXXXX" class="number shadow">
                            </div>
                            <div class="label label-position label-under">
                                <div class="label-fn">First Name</div>
                                <div class="label-mi">Middle Initial</div>
                                <div class="label-ln">Last Name</div>
                            </div>
                            <!-- Appliances -->
                            <div class="header label-position">
                                <div id=>Appliances</div>
                            </div>
                            <div id="applianceContainer">
                                <!-- Initially empty, fields will be added dynamically -->
                            </div>
                            <div>
                                <!-- addbutton -->
                                <input type="button" id="addMoreAppliance" class="btn-var-5 shadow" value="Add More">
                            </div>
                            <div class="displayflex">
                                <!-- Submit Button -->
                                <input type="submit" name="create-tenant-submit" class="btn-var-4 shadow" value="Add">
                            </div>
                        </form>
                    </div>
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
        $tenants = DashboardController::get_tenants();
        $rooms = DashboardController::get_rooms();
        $rent_types = DashboardController::get_types();

        echo <<<HTML
            <div class="modal fade" id="add-new-rent-modal" tabindex="-1" aria-labelledby="add-new-rent-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered d-flex justify-content-center align-items-center">
            <form method="POST">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add-new-rent-modal">Add New Rent</h5>
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
                                    $tenant_fullName = $tenant_fName.' '.$tenant_MI.'. '.$tenant_lName;
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
                                        $tenant_fullName = $tenant_fName.' '.$tenant_MI.'. '.$tenant_lName;
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