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


    // public static function residents_table_upper(){
    //     echo('
    //         <div class="data-container">

    //     <!-- Table Header -->
    //     <header class="upper">
    //         <!-- Leftside Area header -->
    //         <div class="leftside-content">
    //             <span class="text-color">Sort by:</span>
    //             <div class="btn-group">
    //                 <button class="btn btn-secondary btn-sm dropdown-toggle shadow" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    //                     <span class="pe-5 fs-6">Category...</span>
    //                 </button>
    //                 <ul class="dropdown-menu">
    //                     I Love you wehhhh
    //                 </ul>
    //                 </div>
    //         </div>

    //         <!-- Rightside Area header -->
    //         <div class="rigthside-content">
    //             <form>
    //                 <div class="search-container shadow">
    //                     <input type="text" id="search" name="search" placeholder="Search">
    //                     <span class="search-icon"><i class="fas fa-search"></i></span>
    //                 </div>
    //             </form>
    //         </div>
    //     </header>

    //     <!-- Table Actual -->
    //     <section class="table-data">
    //         <table class="table styled-table">
    //             <thead>
    //                 <tr>
    //                     <th>Residents Info</th>
    //                     <th>Status</th>
    //                     <th>More</th>
    //                     <th>Occupancy</th>
    //                     <th>Room Code</th>
    //                     <th>End Date</th>
    //                     <th>Action</th>
    //                 </tr>
    //             </thead>
    //             <tbody>
    //     ');
    // }

    public static function residents_table_display($tenant_list){

        echo('
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
                <tbody>
        ');

        echo '<tbody>'; // Start the table body
    
        // Loop through each tenant in the list
        foreach ($tenant_list as $tenant) {
            echo '
            <tr>
                <td>
                    <button style="float: left; width: 100%;" id="tenantinfo" data-bs-toggle="modal" data-bs-target="#TenantInfo">
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
                    <button id="openEditModalBtn" style="margin-right: 10px;">
                        <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#editmyModal">
                    </button>
                    <button id="openDeleteModalBtn" style="margin-right: 10px;">
                        <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#DeletemyModal">
                    </button>
                </td>
            </tr>
            ';
        }
    
        echo '</tbody>'; // End the table body

        echo('
                
            </table>
        </section>

        <!-- Pagination -->
        <footer>
            <div class="Leftside-portion">
                <Span class="text-color">Showing 1 page to 3 of 3 entries</Span>
            </div>
            <div class="Rightside-portion">
                <!-- <div class="Previous-Next">
                <button class="Previous">Previous</button>
                <Span class="current">1</Span>
                <button class="Next">Next</button>
                </div> -->

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
</div>
        ');
    }

//     public static function residents_table_lower(){
//         echo('
                
//             </table>
//         </section>

//         <!-- Pagination -->
//         <footer>
//             <div class="Leftside-portion">
//                 <Span class="text-color">Showing 1 page to 3 of 3 entries</Span>
//             </div>
//             <div class="Rightside-portion">
//                 <!-- <div class="Previous-Next">
//                 <button class="Previous">Previous</button>
//                 <Span class="current">1</Span>
//                 <button class="Next">Next</button>
//                 </div> -->

//                 <ul class="Previous-Next">
//                     <li class="Previous"><a class="page-link" href="#">Previous</a></li>
//                     <li class="current"><a class="page-link" href="#">1</a></li>
//                     <li class="not-current"><a class="page-link" href="#">2</a></li>
//                     <li class="not-current"><a class="page-link" href="#">3</a></li>
//                     <li class="Next page-item"><a class="page-link" href="#">Next</a></li>
//                 </ul>
//             </div> 
//         </footer>
//     </div>
// </div>
//         ');
//     }
}


?>