<?php 

require 'GeneralViews.php';
require '../controllers/ResidentsController.php';

class ResidentsViews extends GeneralViews{

    public static function residents_header(){
        $total_current_residents = ResidentsController::total_current_residents();

        echo '<script>console.log('.json_encode($_SESSION['First-Name']).')</script>';
        echo ('
            <div class="header-container">
            <div class="left-content">
                <div>
                        <span class="page-header">Residents</span><br>
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
                        <div>'.$total_current_residents.'</div>
                </div>
            </div>
        </div>

        ');
    }

    public static function add_tenant_model_view(){

        echo ('
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
                                 



                                <div class="displayflex">
                                    <input type="submit" name="create-tenant-submit" class="btn-var-4 shadow" value="Add">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        ');
        // <div class="header label-position">
        //                             <div>Appliances</div>
        //                         </div>
        //                         <div>
        //                             <input type="text" id="appliance" name="appliance" placeholder="Rice cooker" class="appliance shadow">
        //                             <input type="image" id="deleteappliance" src="/images/icons/Residents/delete.png" alt="Submit" class="deleteappliance">
        //                         </div>
        //                         <div>
        //                             <input type="button" name="Addmore" id="Addmore" class="btn-var-5 shadow" value="Add More">
        //                         </div> 
    }



    public static function residents_table_display($tenant_list){

        // Start echoing the HTML content
        echo '
            <div class="data-container">
    
                <!-- Table Header -->
                <header class="upper">
                    <!-- Leftside Area header -->
                    <div class="leftside-content">
                        <span class="text-color">Sort by:</span>
                        <div class="btn-group">
                            <button class="btn btn-secondary btn-sm dropdown-toggle shadow" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="pe-5 fs-6">Category...</span>
                            </button>
                            <ul class="dropdown-menu">
                                I Love you wehhhh
                            </ul>
                        </div>
                    </div>
    
                    <!-- Rightside Area header -->
                    <div class="rigthside-content">
                        <form>
                            <div class="search-container shadow">
                                <input type="text" id="search" name="search" placeholder="Search">
                                <span class="search-icon"><i class="fas fa-search"></i></span>
                            </div>
                        </form>
                    </div>
                </header>
    
                <!-- Table Actual -->
                <section class="table-data">
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
                        <tbody>';
    
        // Loop through each tenant in the list
        foreach ($tenant_list as $tenant) {
            $tenantDataJson = htmlspecialchars(json_encode($tenant));
            echo '
                            <tr>
                                <td>
                                    <button style="float: left; width: 100%;" class="tenant-info-btn" data-bs-toggle="modal" data-bs-target="#TenantInfo" data-tenant=\'' . $tenantDataJson . '\'>
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
                                <td>' . htmlspecialchars($tenant['room'] ?? 'N/A') . '</td>
                                <td>' . htmlspecialchars($tenant['roomCode'] ?? 'N/A') . '</td>
                                <td>' . htmlspecialchars(date("F j, Y", strtotime($tenant['tenBdate']))) . '</td>
                                <td>
                                    <button class="openEditModalBtn" style="margin-right: 10px;" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editmyModal" 
                                        onclick="displayEditModal(
                                        \'' . htmlspecialchars($tenant['tenID']) . '\',
                                        \'' . htmlspecialchars($tenant['tenFname']) . '\', 
                                        \'' . htmlspecialchars($tenant['tenLname']) . '\', 
                                        \'' . htmlspecialchars($tenant['tenMI']) . '\', 
                                        \'' . htmlspecialchars($tenant['tenHouseNum']) . '\', 
                                        \'' . htmlspecialchars($tenant['tenSt']) . '\', 
                                        \'' . htmlspecialchars($tenant['tenBrgy']) . '\', 
                                        \'' . htmlspecialchars($tenant['tenCityMun']) . '\', 
                                        \'' . htmlspecialchars($tenant['tenProvince']) . '\', 
                                        \'' . htmlspecialchars($tenant['tenContact']) . '\', 
                                        \'' . htmlspecialchars($tenant['tenBdate']) . '\', 
                                        \'' . htmlspecialchars($tenant['tenGender']) . '\', 
                                        \'' . htmlspecialchars($tenant['emContactFname']) . '\', 
                                        \'' . htmlspecialchars($tenant['emContactLname']) . '\', 
                                        \'' . htmlspecialchars($tenant['emContactMI']) . '\', 
                                        \'' . htmlspecialchars($tenant['emContactNum']) . '\'
                                            )">
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
        echo '
                        </tbody>
                    </table>
                </section>
    
                <!-- Pagination -->
                <footer>
                    <div class="Leftside-portion">
                        <span class="text-color">Showing 1 page to 3 of 3 entries</span>
                    </div>
                    <div class="Rightside-portion">
                        <ul class="Previous-Next">
                            <li class="Previous"><a class="page-link" href="#">Previous</a></li>
                            <li class="current"><a class="page-link" href="#">1</a></li>
                            <li class="not-current"><a class="page-link" href="#">2</a></li>
                            <li class="not-current"><a class="page-link" href="#">3</a></li>
                            <li class="Next page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </div> 
                </footer>
            </div>
        ';
    
        // Modal for displaying tenant information
        echo '
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
                    <div class="modal-footer-custom bg-custom">
                        <div class="header">Rent History</div>
                        <section class="table-data">
                            <table class="table table-bordered styled-table rounded-top rounded-bottom">
                                <thead>
                                    <tr>
                                        <th>Room Code</th>
                                        <th>Start Date</th>
                                        <th>Due Date</th>
                                    </tr>
                                </thead>
                                <tbody id="rentHistoryTableBody">
                                    <!-- Rent history will be loaded here dynamically -->
                                </tbody>
                            </table>
                        </section>
                    </div>
                </div>
            </div>
        </div>';
    
        // Modal for Editing tenant information
        echo '
        <!-- Edit Tenant Modal -->
        <div class="modal fade" id="editmyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content bg-custom">
                    <div class="modal-header bg-custom">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Tenant</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-custom">
                        <form id="editTenantForm" action="/update_tenant.php" method="POST">
                            <!-- Hidden field for tenant ID -->
                            <input type="hidden" id="Edit-tenID" name="tenID">
    
                            <!-- Name, Gender, Date -->
                            <div class="label label-position">
                                <div style="width: 65.9%;">Name:</div>
                                <div style="width: 17%;">Gender:</div>
                                <div>Birth Date:</div>
                            </div>
                            <div class="positioning">
                                <div class="NameInput">
                                    <input type="text" id="Edit-tenFname" name="Edit-tenFname" placeholder="First Name" class="FNclass shadow" required>
                                    <input type="text" id="Edit-tenMI" name="Edit-tenMI" placeholder="MI" class="MIclass shadow" required>
                                    <input type="text" id="Edit-tenLname" name="Edit-tenLname" placeholder="Last Name" class="LNclass shadow" required>
                                </div>
                                <select id="Edit-tenGender" name="Edit-tenGender" class="shadow" required>
                                    <option value="" disabled selected>...</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
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
                                <input type="text" id="Edit-tenHouseNum" name="Edit-tenHouseNum" placeholder="House Number" class="houseno shadow" required>
                                <input type="text" id="Edit-tenSt" name="Edit-tenSt" placeholder="Street" class="street shadow" required>
                                <input type="text" id="Edit-tenBrgy" name="Edit-tenBrgy" placeholder="" class="barangay shadow">
                                <input type="text" id="Edit-tenCityMun" name="Edit-tenCityMun" placeholder="City/Municipality" class="city shadow" required>
                                <input type="text" id="Edit-tenProvince" name="Edit-tenProvince" placeholder="Province" class="province shadow" required>
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
                                <input type="text" id="Edit-tenContact" name="Edit-tenContact" placeholder="Contact Number" class="number shadow" required>
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
                                    <input type="text" id="Edit-emContactFname" name="Edit-emContactFname" placeholder="First Name" class="FNclass shadow" required>
                                    <input type="text" id="Edit-emContactMI" name="Edit-emContactMI" placeholder="MI" class="MIclass shadow" required>
                                    <input type="text" id="Edit-emContactLname" name="Edit-emContactLname" placeholder="Last Name" class="LNclass shadow" required>
                                </div>
                                
                                <input type="number" id="Edit-emContactNum" name="Edit-emContactNum" placeholder="Contact Number" class="number shadow" required>
                            </div>
                            <div class="label label-position label-under">
                                <div class="label-fn">First Name</div>
                                <div class="label-mi">Middle Initial</div>
                                <div class="label-ln">Last Name</div>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="displayflex">
                                <input type="submit" name="edit-tenant-submit" class="btn-var-4 shadow" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
        ';

        // Modal for Delete tenant
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
                                    <span>${tenantData.tenHouseNum} ${tenantData.tenSt}, ${tenantData.tenCityMun}</span>
                                </div>
                                <div>
                                    <span class="label">Gender:</span>
                                    <span>${tenantData.tenGender}</span>
                                </div>
                                <div>
                                    <span class="label">Birth Date:</span>
                                    <span>${tenantData.tenBdate}</span>
                                </div>
                                <div>
                                    <span class="label">Appliances:</span>
                                    <span>${tenantData.appliances}</span>
                                </div>
                            </div>
                            <div class="split-right">
                                <div>
                                    <span class="label" style="font-size: 20px;">Emergency Contact Information</span>
                                </div>
                                <div>
                                    <span class="label">Name:</span>
                                    <span style="font-size: 18px;">${tenantData.emContactFname} ${tenantData.emContactLname}. ${tenantData.emContactMI}</span>
                                </div>
                                <div>
                                    <span class="label">Contact Number:</span>
                                    <span>${tenantData.emContactNum}</span>
                                </div>
                            </div>
                        `;
    
                        // Update rent history section (example data)
                        rentHistoryTableBody.innerHTML = `
                            <tr>
                                <td>B10101</td>
                                <td>April 9, 2024</td>
                                <td>March 9, 2024</td>
                            </tr>
                            <tr>
                                <td>B10101</td>
                                <td>March 9, 2024</td>
                                <td>April 9, 2024</td>
                            `;
                        // Additional rows can be added here
                    });
                });
    
                // Script for edit modal
                
            });
        </script>
        ';
    }
    


}


    


?>