<?php

include 'GeneralViews.php';
include '../controllers/DashboardController.php';

class DashboardViews extends GeneralViews{

    public static function dashboard_header() {

        echo '<script>console.log('.json_encode($_SESSION['First-Name']).')</script>';
        echo <<<HTML
            <div class="header-container">
                <div>
                    <span class="page-header">Welcome Back, {$_SESSION['First-Name']}</span><br>
                    <span class="page-sub-header">Here\'s what we have for you today!</span>
                </div>
            </div>
        HTML;

    }

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

    public static function add_tenant_model_view() {

        echo<<<HTML
            <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content bg-custom">
                        <div class="modal-header bg-custom">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Tenant</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body bg-custom">
                            <form method="POST">
                                <!-- Name,Gender,Date -->
                                <div class="label label-position">
                                    <div style="width: 65.9%;">Name:</div>
                                    <div style="width: 17%;">Gender:</div>
                                    <div>Birth Date:</div>
                                </div>
                                <div class="positioning">
                                    <div class="NameInput">
                                        <input type="text" id="tenFname" name="tenFname" placeholder="Maria" class="FNclass shadow" required>
                                        <input type="text" id="tenMI" name="tenMI" placeholder="P" class="MIclass shadow" required>
                                        <input type="text" id="tenLname" name="tenLname" placeholder="Detablurs" class="LNclass shadow" required>
                                    </div>
                                    <select id="tenGender" name="tenGender" class="shadow">
                                        <option value="" disabled selected>...</option>
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                    </select>
                                    <input type="date" id="tenBdate" name="tenBdate" class="Bday shadow">
                                </div>
                                <div class="label label-position label-under">
                                    <div class="label-fn">First Name</div>
                                    <div class="label-mi">Middle Inital</div>
                                    <div class="label-ln">Last Name</div>
                                </div>
                                <!-- Address -->
                                <div class="label label-position">
                                    <div>Address:</div>
                                </div>
                                <div>
                                    <input type="text" id="tenHouseNum" name="tenHouseNum" placeholder="123" class="houseno shadow">
                                    <input type="text" id="tenSt" name="tenSt" placeholder="Mabini Street" class="street shadow">
                                    <input type="text" id="tenBrgy" name="tenBrgy" placeholder="" class="barangay shadow">
                                    <input type="text" id="tenCityMun" name="tenCityMun" placeholder="Quezon City" class="city shadow">
                                    <input type="text" id="tenProvince" name="tenProvince" placeholder="Quezon" class="province shadow">
                                </div>
                                <div class="label label-position label-under">
                                    <div class="label-houseno">House No.</div>
                                    <div class="label-street">Street</div>
                                    <div class="label-barangay">Barangay</div>
                                    <div class="label-city">City/Municipality</div>
                                    <div class="label-province">Province</div> 
                                </div>
                                <!-- Contact Number -->
                                <div class="label label-position">
                                    <div>Contact Number:</div>
                                </div>
                                <div>
                                    <input type="text" id="countrycode" placeholder="+63" class="countrycode shadow" disabled>
                                    <input type="text" id="tenContact" name="tenContact" placeholder="123456789" class="number shadow" required>
                                </div>
                                <!-- Emergenct Contact -->
                                <div class="header label-position">
                                    <div>Emergency Contact</div>
                                </div>
                                <div class="label label-position">
                                    <div style="width: 60%;">Name:</div>
                                    <div>Contact Number:</div>
                                </div>
                                <div style="display: flex; justify-content:left;">
                                    <div class="NameInput">
                                        <input type="text" id="emContactFname" name="emContactFname" placeholder="Maria" class="FNclass shadow">
                                        <input type="text" id="emContactMI" name="emContactMI" placeholder="P" class="MIclass shadow">
                                        <input type="text" id="emContactLname" name="emContactLname" placeholder="Detablurs" class="LNclass shadow">
                                    </div>
                                    <input type="text" id="ECcountrycode" name="ECcountrycode" placeholder="+63" class="countrycode shadow" style="margin-right: 4px;" disabled>
                                    <input type="text" id="emContactNum" name="emContactNum" placeholder="123456789" class="number shadow">
                                </div>
                                <div class="label label-position label-under">
                                    <div class="label-fn">First Name</div>
                                    <div class="label-mi">Middle Inital</div>
                                    <div class="label-ln">Last Name</div>
                                </div>
                                <!-- Appliances -->
                                <!-- <div class="header label-position">
                                    <div>Appliances</div>
                                </div>
                                <div>
                                    <input type="text" id="appliance" name="appliance" placeholder="Rice cooker" class="appliance shadow">
                                    <input type="image" id="deleteappliance" src="/images/icons/Residents/delete.png" alt="Submit" class="deleteappliance">
                                </div>
                                <div>
                                    <input type="button" name="Addmore" id="Addmore" class="btn-var-5 shadow" value="Add More">
                                </div> -->
                                <div class="displayflex">
                                    <input type="submit" name="create-tenant-submit" class="btn-var-4 shadow" value="Add">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        HTML;

    }

    public static function create_new_rent_modal() {
        $tenants = DashboardController::get_tenants();
        $rooms = DashboardController::get_rooms();
        $rent_types = DashboardController::get_types();

        echo <<<HTML
            <div class="modal fade" id="add-new-rent-modal" tabindex="-1" aria-labelledby="add-new-rent-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
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