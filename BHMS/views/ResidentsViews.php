<?php 

require 'GeneralViews.php';
require '../controllers/ResidentsController.php';

ResidentsController::updateTenantRentStatus();


/**
 * This class contains all the views that are used in the residents page.
 * 
 * @method residents_header
 * @method add_tenant_modal_view
 * @method residents_table_display
 * @method residents_info_model_view
 * @method editOccupancyModal
 * @method deleteOccupancyModal
 * @method edit_tenant_modal_view
 * @method delete_tenant_model_view
 * @class ResidentsViews
 */
class ResidentsViews extends GeneralViews{

    /**
     * This method is used to display the header of the residents page.
     * 
     * @method residents_header
     * @return void
     */
    public static function residents_header(){
        
        $total_current_residents = ResidentsController::total_current_residents();
        
        echo <<<HTML
            <div class="header-container">
            <div class="left-content">
                <div>
                        <span class="page-header">Residents</span><br>
                        <span class="page-sub-header">Manage all the residents in the boarding house</span>
                </div>
                <div class="left-content-button">
                <button class="btn-var-3 shadow" type="button" data-bs-toggle="modal" data-bs-target="#myModal" onmouseover="document.getElementById('dashboard-add-user').src='/images/icons/Dashboard/Buttons/add_user_dark.png'" onmouseout="document.getElementById('dashboard-add-user').src='/images/icons/Dashboard/Buttons/add_user_light.png'">
                <img id="dashboard-add-user" src="/images/icons/Dashboard/Buttons/add_user_light.png" alt="">Add Tenant</button>
                </div>
            </div>
            <div class="right-content">
                <div class="current-residents">
                        <span>Current Number of Residents</span>
                </div>
                <div class="right-child">
                        <img src="/images/icons/Residents/number_of_residents.png" alt="">
                        <div>$total_current_residents</div>
                </div>
            </div>
        </div>

        HTML;
    }


    /**
     * This method is used to display the modal for adding a new tenant.
     * 
     * @method add_tenant_modal_view
     * @return void
     */
    public static function add_tenant_modal_view() {
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
                            <!-- Name, Gender, Birth Date -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="add-new-tenant-label">Name:</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="tenFname" name="tenFname" placeholder="Juan" class="form-control shadow" required>
                                    <label class="add-new-tenant-sup-label" for="tenFname">First Name</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="tenMI" name="tenMI" placeholder="D" class="form-control shadow" maxlength="1">
                                    <label class="add-new-tenant-sup-label" for="tenMI">Middle Initial</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="tenLname" name="tenLname" placeholder="Cruz" class="form-control shadow" required>
                                    <label class="add-new-tenant-sup-label" for="tenLname">Last Name</label>
                                </div>
                            </div>
                            <!-- Address -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="add-new-tenant-label">Address:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="tenHouseNum" name="tenHouseNum" placeholder="123" class="form-control shadow">
                                    <label class="add-new-tenant-sup-label" for="tenHouseNum">House No.</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="tenSt" name="tenSt" placeholder="45 Street" class="form-control shadow">
                                    <label class="add-new-tenant-sup-label" for="tenSt">Street</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="tenBrgy" name="tenBrgy" placeholder="Barangay" class="form-control shadow">
                                    <label class="add-new-tenant-sup-label" for="tenBrgy">Barangay</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="tenCityMun" name="tenCityMun" placeholder="City" class="form-control shadow">
                                    <label class="add-new-tenant-sup-label" for="tenCityMun">City/Municipality</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="tenProvince" name="tenProvince" placeholder="Cebu" class="form-control shadow">
                                    <label class="add-new-tenant-sup-label" for="tenProvince">Province</label>
                                </div>
                            </div>
                            <!-- Gender, Birth Date, Contact Number -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="add-new-tenant-label">Gender:</label>
                                    <select id="tenGender" name="tenGender" class="form-control shadow">
                                        <option value="" disabled selected style="display:none;">...</option>
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                        <option value="O">Others</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="add-new-tenant-label">Birth Date:</label>
                                    <input type="date" id="tenBdate" name="tenBdate" class="form-control shadow">
                                </div>
                                <div class="col-md-6">
                                    <label class="add-new-tenant-label">Contact Number:</label>
                                    <div class="row">
                                        <div class="col-4">
                                            <input type="text" id="countrycode" placeholder="+63" class="form-control shadow" disabled>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="tenContact" name="tenContact" placeholder="09XXXXXXXXX" class="form-control shadow" required
                                            pattern="\d{11}" title="Please enter an 11-digit phone number." onkeyup="this.value = this.value.replace(/\D/g, '').substring(0, 11)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Emergency Contact -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="add-new-tenant-label">Emergency Contact Name:</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="emContactFname" name="emContactFname" placeholder="Maria" class="form-control shadow">
                                    <label class="add-new-tenant-sup-label" for="emContactFname">First Name</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="emContactMI" name="emContactMI" placeholder="D" class="form-control shadow" maxlength="1">
                                    <label class="add-new-tenant-sup-label" for="emContactMI">Middle Initial</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="emContactLname" name="emContactLname" placeholder="Cruz" class="form-control shadow">
                                    <label class="add-new-tenant-sup-label" for="emContactLname">Last Name</label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="add-new-tenant-label">Emergency Contact Number:</label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="text" id="ECcountrycode" name="ECcountrycode" placeholder="+63" class="form-control shadow" disabled>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" id="emContactNum" name="emContactNum" placeholder="09XXXXXXXXX" class="form-control shadow"
                                            pattern="\d{11}" title="Please enter an 11-digit phone number." onkeyup="this.value = this.value.replace(/\D/g, '').substring(0, 11)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Appliances -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="add-new-tenant-label">Appliances</label>
                                </div>
                                <div id="applianceContainer" class="col-12">
                                    <!-- Initially empty, fields will be added dynamically -->
                                </div>
                                <div class="col-12 mt-2">
                                    <input type="button" id="addMoreAppliance" class="btn-var-5 shadow" value="Add More">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12" style="text-align:center;">
                                    <input type="submit" name="create-tenant-submit" class="btn-var-4 shadow" style="display: block; margin: 10px auto; max-width: 200px;" value="Add">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        HTML;
    }


    /**
     * This method is used to display the table of residents.
     * 
     * @method residents_table_display
     * @param array $tenant_list -  The list of tenants to be displayed in the table
     * @return void
     */
    public static function residents_table_display($tenant_list){

        // Start echoing the HTML content
        echo <<<HTML
            <div class="data-container">

                <!-- Table Header -->
                <header class="upper">
                    <!-- Leftside Area header -->
                    <div class="leftside-content">
                        <span class="text-color">Sort by:</span>
                        <form method="GET">
                            <div class="btn-group" style="z-index: 1000;">
                                <button class="btn-var-7 dropdown-toggle shadow" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="pe-5 fs-6" style="padding-left: 20px;">Category...</span>
                                </button>
                                <ul class="dropdown-menu" style="background-color: #EDF6F7; z-index:1050;">
                                    <li class="d-flex justify-content-center"><input type="submit"  name="ALL" value="ALL" class="dropdown-content"></li>
                                    <li class="d-flex justify-content-center"><input type="submit"  name="Active" value="Active" class="dropdown-content"></li>
                                    <li class="d-flex justify-content-center"><input type="submit"   name="Inactive" value="Inactive"class="dropdown-content"></li>
                                    <li class="d-flex justify-content-center"><input type="submit"   name="Evicted" value="Evicted"class="dropdown-content"></li>
                                    <li class="d-flex justify-content-center"><input type="submit"   name="Name" value="Name"class="dropdown-content"></li>
                                </ul>
                            </div>
                        </form>
                    </div>

                    <!-- Rightside Area header -->
                    <div>
                        <form>
                            <div class="search-container shadow">
                                <input type="text" class="search" id="search" name="search" placeholder="Search" value>
                                <span class="search-icon"><i class="fas fa-search"></i></span>
                            </div>
                        </form>
                    </div>
                </header>

                <!-- Table Actual -->
                <section class="table-data overflow-auto" style="max-height: 500px;">
                    <table class="table styled-table">
                        <thead>
                            <tr>
                                <th>Residents Info</th>
                                <th>Status</th>
                                <th>More</th>
                                <th>Occupancy</th>
                                <th>Room Code</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
        HTML;

        // Loop through each tenant in the list
        foreach ($tenant_list as $tenant) {
            $tenantDataJson = htmlspecialchars(json_encode($tenant));
            $appliances = ResidentsController::get_appliances($tenant['tenID']);
            $appliancesDataJson = htmlspecialchars(json_encode($appliances));
            $occupancy = ResidentsController::get_occupancy($tenant['tenID']);
            $occupancyDataJson = json_encode($occupancy);

            $evictButton = '
                <button class="openEditModalBtn" style="margin-right: 10px;" 
                    data-bs-toggle="modal" 
                    data-bs-target="#evictTenantModal" 
                    onclick="evictTenant( \'' . htmlspecialchars($tenant['tenID']) . '\')">
                    <img src="/images/icons/Residents/eviction.png" alt="Edit" class="action" >
                </button>
            ';

            if($tenant['isRenting'] == 0){
                $statusImg = 'inactive';
                $statusText = 'Inactive';
            } else if ($tenant['isRenting'] == 1){
                $statusImg = 'active';
                $statusText = 'Active';
            } else {
                $statusImg = 'evicted';
                $statusText = 'Evicted';
            }

            echo '
                            <tr>
                                <td>
                                    <button style="float: left; width: 100%;" class="tenant-info-btn" data-bs-toggle="modal" data-bs-target="#TenantInfo" data-tenant=\'' . $tenantDataJson . '\'
                                                                 data-appliances = \'' . $appliancesDataJson . '\' data-occupancy=\'' . $occupancyDataJson . '\'>
                                        <div class="alignleft">
                                            <span class="residenttile textstyle0">' . htmlspecialchars($tenant['tenFname'] . ($tenant['tenMI'] ? ' ' . $tenant['tenMI'] . '.' : '') . ' ' . $tenant['tenLname']) . '</span>
                                        </div>
                                        <div class="alignleft">
                                            <span class="textstyle1">' . htmlspecialchars($tenant['tenContact']) . '</span>
                                        </div>
                                        <div class="alignleft">
                                            <span class="textstyle1">' . htmlspecialchars($tenant['tenHouseNum'] . ' ' . $tenant['tenSt'] . ' ' . $tenant['tenCityMun']) . '...</span>
                                        </div>
                                    </button>
                                </td>
                                <td>
                                    <div class="resize">
                                        <img src="/images/icons/Residents/' . $statusImg . '.jpg">
                                        <span>' . $statusText . '</span>
                                    </div>
                                </td>
                                <td>See more...</td>
                                <td style="max-width: 200px">' . htmlspecialchars($occupancy[0]['occTypeName'] ?? 'N/A') . '</td>
                                <td>' . htmlspecialchars($occupancy[0]['roomID'] ?? 'N/A') . '</td>
                                <td>' . (empty($occupancy) ? 'N/A' : htmlspecialchars(date("F j, Y", strtotime($occupancy[0]['occDateEnd'])))) . '</td>
                                <td>' .

                                    ($tenant['isRenting'] == 1 ? $evictButton : '') .
                                '
                                    <button class="openEditModalBtn" style="margin-right: 10px;" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editmyModal" 
                                        onclick="showTenantData('.htmlspecialchars(json_encode($appliances)).','.$tenantDataJson.')"
                                        >
                                        <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" >
                                    </button>
                                    <button class="openDeleteModalBtn" style="margin-right: 10px;" data-bs-toggle="modal" data-bs-target="#DeletemyModal" onclick="displaydeleteModal(
                                        \'' . htmlspecialchars($tenant['tenID']) . '\')">
                                        <img src="/images/icons/Residents/delete.png" alt="Delete" class="action">
                                    </button>
                                </td>
                            </tr>';
        }
    
        // Close the table and container
        echo <<<HTML
                        </tbody>
                    </table>
                </section>
            </div>
        HTML;
    
        
        // Modal for displaying tenant information
        self::residents_info_model_view();
        self::editOccupancyModal();
        self::deleteOccupancyModal();
        // Modal for Delete tenant
        self::delete_tenant_model_view();
        
    }


    /**
     * This method is used to display the modal for viewing tenant information.
     * 
     * @method residents_info_model_view
     * @return void
     */
    public static function residents_info_model_view() {
        
        echo <<<HTML
        <!-- Tenant Info Modal -->
        <div class="modal fade" id="TenantInfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">   
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content bg-custom">
                    <div class="modal-header bg-custom">
                        <span style="font-size: 25px;" class="header">Tenant Information</span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="tenant-modal-body bg-custom displayflex" id="tenantInfoModalBody">
                        <!-- Tenant information will be loaded here dynamically -->
                    </div>
                    <div class="modal-footer-custom bg-custom " >
                        <div class="header">Rent History</div>
                        <section class="table-data">
                            <div class="table-responsive overflow-auto" style="max-height: 200px;">
                                <table class="table table-bordered styling rounded-top rounded-bottom" style="border-bottom:1px solid #344799; border-top:1px solid #344799;">
                                    <thead>
                                        <tr>
                                            <th>Room Code</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Rent Type</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="rentHistoryTableBody">
                                        <!-- Rent history will be loaded here dynamically -->
                                        <tr>
                                            <td colspan="5" style="text-align: center;color: rgb(118, 118, 118);">No data available</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        HTML;

        // JavaScript for handling the click event and loading data into modal
        echo '
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            var tenantInfoModalBody = document.getElementById("tenantInfoModalBody");
            var rentHistoryTableBody = document.getElementById("rentHistoryTableBody");
            var tenantInfoButtons = document.querySelectorAll(".tenant-info-btn");
        
            tenantInfoButtons.forEach(function(btn) {
                btn.addEventListener("click", function() {
                    var tenantData = JSON.parse(this.getAttribute("data-tenant"));
                    var appliancesData = JSON.parse(this.getAttribute("data-appliances"));
                    var occupancyData = JSON.parse(this.getAttribute("data-occupancy"));
        
                    // Update tenant information section
                    tenantInfoModalBody.innerHTML = `
                        <div class="tenant-split-left">
                            <div>
                                <span class="label">Name:</span>
                                <span style="font-size: 18px;">${tenantData.tenFname} ${tenantData.tenMI ? tenantData.tenMI + "." : ""} ${tenantData.tenLname}</span>
                            </div>
                            <div>
                                <span class="label">Contact Number:</span>
                                <span>${tenantData.tenContact}</span>
                            </div>
                            <div>
                                <span class="label">Address:</span>
                                <span>${tenantData.tenHouseNum ? tenantData.tenHouseNum + " " : ""}${tenantData.tenSt ? tenantData.tenSt + " " : ""} ${tenantData.tenCityMun ? tenantData.tenCityMun : ""}</span>
                            </div>
                            <div>
                                <span class="label">Gender:</span>
                                <span>${tenantData.tenGender}</span>
                            </div>
                            <div>
                                <span class="label">Birth Date:</span>
                                <span>${formatDate(tenantData.tenBdate)}</span>
                            </div>
                            <div>
                                <span class="label">Appliances:</span>
                                <ul id="appliancesList"></ul>
                            </div>
                        </div>
                        <div class="tenant-split-right">
                            <div>
                                <span class="label" style="font-size: 20px;">Emergency Contact Information</span>
                            </div>
                            <div>
                                <span class="label">Name:</span>
                                <span style="font-size: 18px;">${tenantData.emContactFname ? tenantData.emContactFname + " " : ""} ${tenantData.emContactMI ? tenantData.emContactMI + "." : ""} ${tenantData.emContactLname ? tenantData.emContactLname : ""}</span>
                            </div>
                            <div>
                                <span class="label">Contact Number:</span>
                                <span>${tenantData.emContactNum ? tenantData.emContactNum : ""}</span>
                            </div>
                        </div>
                    `;
        
                    // Update appliances list
                    var appliancesList = document.getElementById("appliancesList");
                    appliancesList.innerHTML = ""; // Clear previous content
                    appliancesData.forEach(function(appliance) {
                        var li = document.createElement("li");
                        li.textContent = appliance.appInfo.concat(" - ₱", appliance.appRate);
                        appliancesList.appendChild(li);
                    });
        
                    // Update rent history table with occupancy data
                    rentHistoryTableBody.innerHTML = ""; // Clear previous content
                    if (occupancyData.length === 0) {
                        var tr = document.createElement("tr");
                        var td = document.createElement("td");
                        td.colSpan = 5;
                        td.style.textAlign = "center";
                        td.style.color = "rgb(118, 118, 118)";
                        td.textContent = "No data available";
                        tr.appendChild(td);
                        rentHistoryTableBody.appendChild(tr);
                    } else {
                        occupancyData.forEach(function(occupancy) {
                            var tr = document.createElement("tr");
                            tr.innerHTML = `
                                <td>${occupancy.roomID}</td>
                                <td>${formatDate(occupancy.occDateStart)}</td>
                                <td>${formatDate(occupancy.occDateEnd)}</td>
                                <td style="max-width:200px;">${occupancy.occTypeName}</td>
                                <td>
                                    <button class="editOccupancyBtn" style="margin-right: 10px; border: none; background: transparent;" data-bs-toggle="modal" data-bs-target="#editOccupancyModal"
                                        value=${occupancy.roomID}
                                        onclick="setValuesTenantInfo(
                                            ${occupancy.occupancyID},
                                            \'${occupancy.tenFname}\',
                                            \'${occupancy.tenMI}\',
                                            \'${occupancy.tenLname}\',
                                            \'${occupancy.roomID}\',
                                            \'${occupancy.occTypeID}\',
                                            \'${occupancy.occTypeName}\',
                                            \'${occupancy.occDateStart}\',
                                            \'${occupancy.occDateEnd}\',
                                            ${occupancy.occupancyRate}
                                        );"
                                    >
                                        <img src="/images/icons/Residents/edit.png" alt="Edit" class="action">
                                    </button>
        
                                    <button class="deleteOccupancyBtn" style="margin-right: 10px; border: none; background: transparent;" onclick="deleteOccupancy(${occupancy.occupancyID})">
                                        <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#deleteOccupancyModal">
                                    </button>
                                </td>
                            `;
                            rentHistoryTableBody.appendChild(tr);
                        });
                    }
                });
            });
        });
        </script>
        ';
        

    }


    /**
     * This method is used to display the modal for editing the occupancy of a tenant.
     * 
     * @method editOccupancyModal
     * @return void
     */
    public static function editOccupancyModal(){
        $rooms = ResidentsController::get_rooms();
    
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
                                    <input type="hidden" name="edit-rent-type" id="edit-rent-type">
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
     * This method is used to display the modal for deleting an occupancy.
     * 
     * @method deleteOccupancyModal
     * @return void
     */
    public static function deleteOccupancyModal(){
        echo <<<HTML
            <div class="modal fade" id="deleteOccupancyModal" tabindex="-1" aria-labelledby="deleteOccupancyModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                    <p class="confirmation-question">Are you sure you want to delete this occupancy?</p>
                    <form method="POST" id = "deleteOccupancy">
                    <input type="hidden" name="delete-occupancy-id" id="delete-occupancy-id">
                        <div class="button-container">
                            <button type="submit" name="delete-occupancy-submit" class="btn-delete-yes" value="Yes">Yes</button>
                            <button type="button" name="No" id="Nodelete" class="btn-delete-no" data-bs-dismiss="modal" value="No" style="background: red;">No</button>
                        </div>
                    </form>
                        <p class="note">Note: Once you have clicked 'Yes', this cannot be undone.</p>
                    </div>
                </div>
                </div>
            </div>
        HTML;
    }


    /**
     * This method is used to display the modal for editing a tenant.
     * 
     * @method edit_tenant_modal_view
     * @return void
     */
    public static function edit_tenant_modal_view(){
        echo <<<HTML
        <!-- Edit Tenant Modal -->
        <div class="modal fade" id="editmyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content bg-custom">
                    <div class="modal-header bg-custom">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Tenant</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-custom">
                        <form id="editTenantForm" method="POST">
                            <!-- Hidden field for tenant ID -->
                            <input type="hidden" id="Edit-tenID" name="Edit-tenID">

                            <!-- Name, Gender, Birth Date -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="add-new-tenant-label">Name:</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="Edit-tenFname" name="Edit-tenFname" placeholder="Juan" class="form-control shadow" required>
                                    <label class="add-new-tenant-sup-label" for="Edit-tenFname">First Name</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="Edit-tenMI" name="Edit-tenMI" placeholder="D" class="form-control shadow" maxlength="1">
                                    <label class="add-new-tenant-sup-label" for="Edit-tenMI">Middle Initial</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="Edit-tenLname" name="Edit-tenLname" placeholder="Cruz" class="form-control shadow" required>
                                    <label class="add-new-tenant-sup-label" for="Edit-tenLname">Last Name</label>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="add-new-tenant-label">Address:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="Edit-tenHouseNum" name="Edit-tenHouseNum" placeholder="123" class="form-control shadow">
                                    <label class="add-new-tenant-sup-label" for="Edit-tenHouseNum">House No.</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="Edit-tenSt" name="Edit-tenSt" placeholder="45 Street" class="form-control shadow">
                                    <label class="add-new-tenant-sup-label" for="Edit-tenSt">Street</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="Edit-tenBrgy" name="Edit-tenBrgy" placeholder="Barangay" class="form-control shadow">
                                    <label class="add-new-tenant-sup-label" for="Edit-tenBrgy">Barangay</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="Edit-tenCityMun" name="Edit-tenCityMun" placeholder="City" class="form-control shadow">
                                    <label class="add-new-tenant-sup-label" for="Edit-tenCityMun">City/Municipality</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="Edit-tenProvince" name="Edit-tenProvince" placeholder="Cebu" class="form-control shadow">
                                    <label class="add-new-tenant-sup-label" for="Edit-tenProvince">Province</label>
                                </div>
                            </div>

                            <!-- Gender, Birth Date, Contact Number -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="add-new-tenant-label">Gender:</label>
                                    <select id="Edit-tenGender" name="Edit-tenGender" class="form-control shadow" required>
                                        <option value="" disabled selected style="display:none;">...</option>
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                        <option value="O">Others</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="add-new-tenant-label">Birth Date:</label>
                                    <input type="date" id="Edit-tenBdate" name="Edit-tenBdate" class="form-control shadow" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="add-new-tenant-label">Contact Number:</label>
                                    <div class="row">
                                        <div class="col-4">
                                            <input type="text" id="countrycode" placeholder="+63" class="form-control shadow" disabled>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="Edit-tenContact" name="Edit-tenContact" placeholder="09XXXXXXXXX" class="form-control shadow" required
                                            pattern="\d{11}" title="Please enter an 11-digit phone number." onkeyup="this.value = this.value.replace(/\D/g, '').substring(0, 11)">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Emergency Contact -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="add-new-tenant-label">Emergency Contact Name:</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="Edit-emContactFname" name="Edit-emContactFname" placeholder="Maria" class="form-control shadow">
                                    <label class="add-new-tenant-sup-label" for="Edit-emContactFname">First Name</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" id="Edit-emContactMI" name="Edit-emContactMI" placeholder="D" class="form-control shadow" maxlength="1">
                                    <label class="add-new-tenant-sup-label" for="Edit-emContactMI">Middle Initial</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="Edit-emContactLname" name="Edit-emContactLname" placeholder="Cruz" class="form-control shadow">
                                    <label class="add-new-tenant-sup-label" for="Edit-emContactLname">Last Name</label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="add-new-tenant-label">Emergency Contact Number:</label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="text" id="ECcountrycode" name="ECcountrycode" placeholder="+63" class="form-control shadow" disabled>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" id="Edit-emContactNum" name="Edit-emContactNum" placeholder="09XXXXXXXXX" class="form-control shadow"
                                            pattern="\d{11}" title="Please enter an 11-digit phone number." onkeyup="this.value = this.value.replace(/\D/g, '').substring(0, 11)">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Appliances -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="add-new-tenant-label">Appliances</label>
                                </div>
                                <div id="Edit-applianceContainer" class= "col-12">
                                    <!-- Initially empty, fields will be added dynamically -->
                                </div>
                                <div class="col-12 mt-2">
                                    <input type="button" id="editMoreAppliance" class="btn-var-5 shadow" value="Add More">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12" style="text-align:center;">
                                    <input type="submit" name="edit-tenant-submit" class="btn-var-4 shadow" style="display: block; margin: 10px auto; max-width: 200px;" value="Save">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

 
        HTML;
    }
    

    /**
     * This method is used to display the modal for deleting a tenant.
     * 
     * @method delete_tenant_model_view
     * @return void
     */
    public static function delete_tenant_model_view(){
        echo <<<HTML
        <div class="modal fade" id="DeletemyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                    <p class="confirmation-question">Are you sure you want to delete this tenant?</p>
                        <form id="deleteTenantForm" action="../pages/residents.php" method="POST">
                            <input type="hidden" name="deleteTenantId" id="deleteTenantId" value="">
                            <div class="button-container">
                                <button type="submit" name="delete-tenant-submit" id="Yesdelete" class="btn-delete-yes" value="Yes">Yes</button>
                                <button type="button" name="No" id="Nodelete" class="btn-delete-no" data-bs-dismiss="modal" aria-label="Close">No</button>
                            </div>
                        </form>
                        <p class="note">Note: Once you have clicked 'Yes', this cannot be undone.</p>
                    </div>
                </div>
            </div>
        </div>
        HTML;
    }

    /**
     * This method is used to display the modal for evicting a tenant.
     * 
     * @method evictTenantModal
     * @return void
     */
    public static function evictTenantModal(){
        echo <<<HTML
            <div class="modal fade" id="evictTenantModal" tabindex="-1" aria-labelledby="evictTenantModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                        <p class="confirmation-question">Are you sure you want to evict this tenant?</p>
                        <form method="POST">
                            <input type="hidden" name="evictTenID" id="evictTenID">
                            <div class="button-container">
                                <button type="submit" name="evict-tenant-submit" class="btn-delete-yes" value="Yes">Yes</button>
                                <button type="button" name="No" id="Nodelete" class="btn-delete-no" data-bs-dismiss="modal" value="No">No</button>
                            </div>
                        </form>
                        <p class="note">Note: Once you have clicked 'Yes', this cannot be undone.</p>
                        </div>
                    </div>
                </div>
            </div>
        HTML;
    }


}


    


?> 