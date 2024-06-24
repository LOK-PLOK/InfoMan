<?php

require 'GeneralViews.php';
require '../controllers/DashboardController.php';

class DashboardViews extends GeneralViews{

    public static function notification() { // Needs Model to show all Notification
        
        echo ('
            <div class="notification-group">
                <div class="notification" type="button" class="dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                    <div class="notification-num">10</div>
                    <img src="/images/icons/Dashboard/notification_bell.png">
                </div>
                <ul class="notification-dd dropdown-menu dropdown-menu-end ">
                    <li><h6 class="dropdown-header">Recent Notifications</h6></li>
                    <li class="border-bottom border-1">
                        <div class="dropdown-item text-wrap">
                            <span class="notification-item-head">Maintenance</span><br>
                            <div style="padding-left: 10px">
                                <span class="notification-item-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet at architecto</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div> 
        ');

    }

    public static function dashboard_header() {

        echo '<script>console.log('.json_encode($_SESSION['First-Name']).')</script>';
        echo ('
            <div class="header-container">
                <div>
                    <span class="page-header">Welcome Back, '.$_SESSION['First-Name'].'</span><br>
                    <span class="page-sub-header">Here\'s what we have for you today!</span>
                </div>
            </div>
        ');

    }

    public static function ov_total_residents() {

        $total_current_residents = DashboardController::total_current_residents();

        echo ('
            <div class="col-auto">
                <div class="dashboard-icons shadow" style="background-color: #344799; color: white;">
                    <div>
                        <img src="/images/icons/Dashboard/Overview/user_light.png" alt="">
                        <div>'.$total_current_residents.'</div>
                    </div>
                    <p>Total Residents</p>
                </div>
            </div>
        ');
    }

    public static function ov_bedsOcc_bedsAvail() {

        $result = DashboardController::total_occupied_beds_and_available_beds();

        echo ('
            <div class="col-auto">
                <div class="dashboard-icons shadow">
                    <div>
                        <img src="/images/icons/Dashboard/Overview/occupied_beds_dark.png" alt="">
                        <div>'.$result['occupied_beds'].'</div>
                    </div>
                    <p>Occupied Beds</p>
                </div>
            </div>
        ');

        echo ('
            <div class="col-auto">
                <div class="dashboard-icons shadow">
                    <div>
                        <img src="/images/icons/Dashboard/Overview/available_beds_dark.png" alt="">
                        <div>'.$result['available_beds'].'</div>
                    </div>
                    <p>Available Beds</p>
                </div>
            </div>
        
        ');
    }

    public static function ov_available_rooms() {

        $available_rooms = DashboardController::available_rooms();

        echo ('
             <div class="col-auto">
                <div class="dashboard-icons shadow">
                    <div>
                        <img src="/images/icons/Dashboard/Overview/available_rooms_dark.png" alt="">
                        <div>'.$available_rooms.'</div>
                    </div>
                    <p>Available Rooms</p>
                </div>
            </div> 
        ');
    }

    public static function add_tenant_model_view() {

        echo ('
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
        ');

    }

}

?>