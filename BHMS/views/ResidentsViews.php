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
                        <!-- Button to open Modal -->
                        <button class="btn-var-1" type="button" data-bs-toggle="modal" data-bs-target="#myModal">
                            <img src="/images/icons/Residents/add_new_light.png" alt=""> Add New
                        </button>
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
                            <div class="label label-position">
                                <div style="width: 65.9%;">Name:</div>
                                <div style="width: 17%;">Gender:</div>
                                <div>Birth Date:</div>
                            </div>
                            <div class="positioning">
                                <div class="NameInput">
                                    <!-- tenFname -->
                                    <input type="text" id="tenFname" name="tenFname" placeholder="Maria" class="FNclass shadow" required>
                                    <!-- tenMI -->
                                    <input type="text" id="tenMI" name="tenMI" placeholder="P" class="MIclass shadow">
                                    <!-- tenLname -->
                                    <input type="text" id="tenLname" name="tenLname" placeholder="Detablurs" class="LNclass shadow" required>
                                </div>
                                <!-- tenGender -->
                                <select id="tenGender" name="tenGender" class="shadow" required>
                                    <option value="" disabled selected>...</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                                <!-- tenBdate -->
                                <input type="date" id="tenBdate" name="tenBdate" class="Bday shadow" required>
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
                                <input type="text" id="tenHouseNum" name="tenHouseNum" placeholder="123" class="houseno shadow">
                                <!-- tenSt-->
                                <input type="text" id="tenSt" name="tenSt" placeholder="Mabini Street" class="street shadow">
                                <!-- tenBrgy -->
                                <input type="text" id="tenBrgy" name="tenBrgy" placeholder="" class="barangay shadow">
                                <!-- tenCityMun -->
                                <input type="text" id="tenCityMun" name="tenCityMun" placeholder="Quezon City" class="city shadow">
                                <!-- tenProvince -->
                                <input type="text" id="tenProvince" name="tenProvince" placeholder="Quezon" class="province shadow">
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
                                <input type="text" id="tenContact" name="tenContact" placeholder="123456789" class="number shadow" >
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
                                    <input type="text" id="emContactFname" name="emContactFname" placeholder="Maria" class="FNclass shadow">
                                    <!-- emContactMI -->
                                    <input type="text" id="emContactMI" name="emContactMI" placeholder="P" class="MIclass shadow">
                                    <!-- emContactLname -->
                                    <input type="text" id="emContactLname" name="emContactLname" placeholder="Detablurs" class="LNclass shadow">
                                </div>
                                <input type="text" id="ECcountrycode" name="ECcountrycode" placeholder="+63" class="countrycode shadow" style="margin-right: 4px;" disabled>
                                <!-- emContactNum -->
                                <input type="text" id="emContactNum" name="emContactNum" placeholder="123456789" class="number shadow">
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
                                <button class="btn btn-primary btn-sm dropdown-toggle shadow" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="pe-5 fs-6">Category...</span>
                                </button>
                                <ul class="dropdown-menu" style="background-color: #344799;">
                                    <li class="d-flex justify-content-center"><input type="submit"  name="ALL"value="ALL" class="no-design1"></li>
                                    <li class="d-flex justify-content-center"><input type="submit"  name="Active"value="Active" class="no-design1"></li>
                                    <li class="d-flex justify-content-center"><input type="submit"   name="Inactive" value="Inactive"class="no-design2"></li>
                                    <li class="d-flex justify-content-center"><input type="submit"   name="Name" value="Name"class="no-design2"></li>
                                </ul>
                            </div>
                        </form>
                    </div>

                    <!-- Rightside Area header -->
                    <div class="rigthside-content">
                        <form>
                            <div class="search-container shadow">
                                <input type="text" id="search" name="search" placeholder="Search" value>
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
            
            echo '
                            <tr>
                                <td>
                                    <button style="float: left; width: 100%;" class="tenant-info-btn" data-bs-toggle="modal" data-bs-target="#TenantInfo" data-tenant=\'' . $tenantDataJson . '\'
                                                                 data-appliances = \'' . $appliancesDataJson . '\' data-occupancy=\'' . $occupancyDataJson . '\'>
                                        <div class="alignleft">
                                            <span class="residenttile textstyle0">' . htmlspecialchars($tenant['tenFname'] . ' ' . $tenant['tenMI'] . '. ' . $tenant['tenLname']) . '</span>
                                        </div>
                                        <div class="alignleft">
                                            <span class="textstyle1">' . htmlspecialchars($tenant['tenContact']) . '</span>
                                        </div>
                                        <div class="alignleft">
                                            <span class="textstyle1">' . htmlspecialchars($tenant['tenHouseNum'] . ' ' . $tenant['tenSt'] . ', ' . $tenant['tenCityMun']) . '...</span>
                                        </div>
                                    </button>
                                </td>
                                <td>
                                    <div class="resize">
                                        <img src="/images/icons/Residents/' . ($tenant['isRenting'] ? 'active' : 'inactive') . '.jpg">
                                        <span>' . ($tenant['isRenting'] ? 'Active' : 'Inactive') . '</span>
                                    </div>
                                </td>
                                <td>See more...</td>
                                <td>' . htmlspecialchars($occupancy[0]['occTypeName'] ?? 'N/A') . '</td>
                                <td>' . htmlspecialchars($occupancy[0]['roomID'] ?? 'N/A') . '</td>
                                <td>' . (empty($occupancy) ? 'N/A' : htmlspecialchars(date("F j, Y", strtotime($occupancy[0]['occDateEnd'])))) . '</td>
                                <td>
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
                    <div class="modal-body bg-custom displayflex" id="tenantInfoModalBody">
                        <!-- Tenant information will be loaded here dynamically -->
                    </div>
                    <div class="modal-footer-custom bg-custom overflow-auto" style="max-height: 200px;">
                        <div class="header">Rent History</div>
                        <section class="table-data">
                            <div class="table-responsive">
                                <table class="table table-bordered styling rounded-top rounded-bottom" style="border-bottom:1px solid #344799">
                                    <thead>
                                        <tr>
                                            <th>Room Code</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="rentHistoryTableBody scrollable-tbody">
                                        <!-- Rent history will be loaded here dynamically -->
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
                        <div class="split-left">
                            <div>
                                <span class="label">Name:</span>
                                <span style="font-size: 18px;">${tenantData.tenFname} ${tenantData.tenMI}. ${tenantData.tenLname}</span>
                            </div>
                            <div>
                                <span class="label">Contact Number:</span>
                                <span>${tenantData.tenContact}</span>
                            </div>
                            <div>
                                <span class="label">Address:</span>
                                <span>${tenantData.tenHouseNum !== "0" ? tenantData.tenHouseNum + " " : ""}${tenantData.tenSt}, ${tenantData.tenCityMun}</span>
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
                        <div class="split-right">
                            <div>
                                <span class="label" style="font-size: 20px;">Emergency Contact Information</span>
                            </div>
                            <div>
                                <span class="label">Name:</span>
                                <span style="font-size: 18px;">${tenantData.emContactFname} ${tenantData.emContactMI}. ${tenantData.emContactLname}</span>
                            </div>
                            <div>
                                <span class="label">Contact Number:</span>
                                <span>${tenantData.emContactNum}</span>
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
                    occupancyData.forEach(function(occupancy) {
                        var tr = document.createElement("tr");
                        tr.innerHTML = `
                            <td>${occupancy.roomID}</td>
                            <td>${formatDate(occupancy.occDateStart)}</td>
                            <td>${formatDate(occupancy.occDateEnd)}</td>
                            <td>
                                <button class="editOccupancyBtn" style="margin-right: 10px; border: none; background: transparent;" data-bs-toggle="modal" data-bs-target="#editOccupancyModal"
                                    value=${occupancy.roomID}
                                    onclick="setValuesTenantInfo(
                                        ${occupancy.occupancyID},
                                        \'${occupancy.tenFname}\',
                                        \'${occupancy.tenMI}\',
                                        \'${occupancy.tenLname}\',
                                        \'${occupancy.roomID}\',
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
    public static function  editOccupancyModal(){
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
                    <div class="modal-content bg-custom">
                        <div class="modal-header bg-custom">
                            <span style="font-size: 25px;" class="header">Are you sure you want to delete this occupancy?</span>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body bg-custom">
                        <form method="POST" id = "deleteOccupancy">
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
    
        
                            <div class="label label-position">
                                <div style="width: 65.9%;">Name:</div>
                                <div style="width: 17%;">Gender:</div>
                                <div>Birth Date:</div>
                            </div>
                            <div class="positioning">
                                <div class="NameInput">
                                    <!-- Edit tenFname -->
                                    <input type="text" id="Edit-tenFname" name="Edit-tenFname" placeholder="First Name" class="FNclass shadow" required>
                                    <!-- Edit tenMI -->
                                    <input type="text" id="Edit-tenMI" name="Edit-tenMI" placeholder="MI" class="MIclass shadow">
                                    <!-- Edit tenLname -->
                                    <input type="text" id="Edit-tenLname" name="Edit-tenLname" placeholder="Last Name" class="LNclass shadow" required>
                                </div>
                                <select id="Edit-tenGender" name="Edit-tenGender" class="shadow" required>
                                    <option value="" disabled selected>...</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                                <!-- Edit-tenBdate -->
                                <input type="date" id="Edit-tenBdate" name="Edit-tenBdate" class="Bday shadow" required>
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
                                <!-- Edit-tenHouseNum -->
                                <input type="text" id="Edit-tenHouseNum" name="Edit-tenHouseNum" placeholder="House Number" class="houseno shadow" >
                                <!-- Edit-tenSt -->
                                <input type="text" id="Edit-tenSt" name="Edit-tenSt" placeholder="Street" class="street shadow" >
                                <!-- Edit-tenBrgy -->
                                <input type="text" id="Edit-tenBrgy" name="Edit-tenBrgy" placeholder="" class="barangay shadow">
                                <!-- Edit-tenCityMun -->
                                <input type="text" id="Edit-tenCityMun" name="Edit-tenCityMun" placeholder="City/Municipality" class="city shadow" >
                                <!-- Edit-tenProvince -->
                                <input type="text" id="Edit-tenProvince" name="Edit-tenProvince" placeholder="Province" class="province shadow" >
                            </div>
                            <div class="label label-position label-under">
                                <div class="label-houseno">House No.</div>
                                <div class="label-street">Street</div>
                                <div class="label-city">City</div>
                                <div class="label-province">Province</div>
                            </div>
                            
                            <!-- Contact Number -->
                            <div class="label label-position">
                                <div>Contact Number:</div>
                            </div>
                            <div>
                            <input type="text" id="countrycode" placeholder="+63" class="countrycode shadow" disabled>
                                <!-- Edit-tenContact -->
                                <input type="text" id="Edit-tenContact" name="Edit-tenContact" placeholder="Contact Number" class="number shadow">
                            </div>
                            
                            <div class="header label-position">
                                <div>Emergency Contact</div>
                            </div>
                            <div class="label label-position">
                                <div style="width: 60%;">Name:</div>
                                <div>Contact Number:</div>
                            </div>
                            <div style="display: flex; justify-content:left;">
                                <div class="NameInput">
                                    <!-- Edit-emContactFname -->
                                    <input type="text" id="Edit-emContactFname" name="Edit-emContactFname" placeholder="First Name" class="FNclass shadow">
                                    <!-- Edit-emContactMI -->
                                    <input type="text" id="Edit-emContactMI" name="Edit-emContactMI" placeholder="MI" class="MIclass shadow">
                                    <!-- Edit-emContactLname -->
                                    <input type="text" id="Edit-emContactLname" name="Edit-emContactLname" placeholder="Last Name" class="LNclass shadow">
                                </div>
                                    <!-- Edit-emContactNum -->
                                    <input type="text" id="Edit-emContactNum" name="Edit-emContactNum" placeholder="Contact Number" class="number shadow">
                            </div>
                            <div class="label label-position label-under">
                                <div class="label-fn">First Name</div>
                                <div class="label-mi">Middle Initial</div>
                                <div class="label-ln">Last Name</div>
                            </div>
                            
                             <!-- Appliances -->
                            <div class="header label-position">
                                <div>Appliances</div>
                            </div>
                            <div id="Edit-applianceContainer">
                                <!-- Initially empty, fields will be added dynamically -->
                            </div>
                            <div>
                                <!-- Edit Add More Appliance -->
                                <input type="button" id="editMoreAppliance" class="btn-var-5 shadow" value="Add More">
                            </div>


                            <!-- Submit Button -->
                            <div class="displayflex">
                                <!-- edit-tenant-submit -->
                                <input type="submit" name="edit-tenant-submit" class="btn-var-4 shadow" value="Save">
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
        echo '<div class="modal fade" id="DeletemyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-custom">
                    <div class="modal-header bg-custom border-0">
                        <div class="displayflex header bg-custom">
                            <span style="font-size: 25px;" id="deleteTenantMessage">Are you sure you want to delete this tenant?</span>
                        </div>
                        <div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="modal-body bg-custom">
                        <form id="deleteTenantForm" action="../pages/residents.php" method="POST">
                            <div class="displayflex">
                                <!-- Hidden input field to hold tenant ID -->
                                <input type="hidden" name="deleteTenantId" id="deleteTenantId" value="">
                                <!-- Buttons to confirm or cancel deletion -->
                                <input type="submit" name="delete-tenant-submit" id="Yesdelete" class="btn-var-6" value="Yes">
                                <button type="button" name="No" id="Nodelete" class="btn-var-6" data-bs-dismiss="modal" aria-label="Close">No</button>
                            </div>
                        </form>
                    </div>
                    <div class="displayflex bg-custom label" style="border-radius: 10px;">
                        <span>Note: Once you have clicked \'Yes\', this cannot be undone</span>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>';
    }


}


    


?> 