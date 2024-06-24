<?php
  
// $filePath = __FILE__;
// echo "The file path is: $filePath";

session_start();

require '../php/templates.php';
require '../views/ResidentsViews.php';


html_start('residents.css');

// Sidebar
require '../php/navbar.php';

// Hamburger Sidebar
ResidentsViews::burger_sidebar();


?>

<!-- Residents Contents -->
<div class="container-fluid">

<?php 

ResidentsViews::residents_header();

/** For the Add tenant */
ResidentsViews::add_tenant_model_view();

if (isset($_POST['create-tenant-submit'])) {
    $new_tenant = array(
        "tenFname" => $_POST['tenFname'],
        "tenMI" => $_POST['tenMI'],
        "tenLname" => $_POST['tenLname'],
        "tenGender" => $_POST['tenGender'],
        "tenBdate" => $_POST['tenBdate'],
        "tenHouseNum" => $_POST['tenHouseNum'],
        "tenSt" => $_POST['tenSt'],
        "tenBrgy" => $_POST['tenBrgy'],
        "tenCityMun" => $_POST['tenCityMun'],
        "tenProvince" => $_POST['tenProvince'],
        "tenContact" => $_POST['tenContact'],
        "emContactFname" => $_POST['emContactFname'],
        "emContactMI" => $_POST['emContactMI'],
        "emContactLname" => $_POST['emContactLname'],
        "emContactNum" => $_POST['emContactNum']
    );

    $result = ResidentsController::create_new_tenant($new_tenant);
    if ($result) {
        echo '<script>console.log("Tenant added successfully")</script>';
    } else {
        echo '<script>console.log("Error")</script>';
    }
    //  // After processing, redirect to the same page or another page
    //  header('Location: ' . $_SERVER['REQUEST_URI']); // Redirect to the current page
    //  exit();
}
?>
    <?php
    $tenant_list = ResidentsController::residents_table_data();
    ResidentsViews::residents_table_display($tenant_list);

    if ($tenant_list) {
        echo '<script>console.log("Tenant added successfully")</script>';
    } else {
        echo '<script>console.log("Error")</script>';
    }
    ?>
    <?php 
    /*
    <!-- Table Layout -->
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
                    <tr>
                        <td>
                            <button style="float: left; width: 100%;" id="tenantinfo"  data-bs-toggle="modal" data-bs-target="#TenantInfo">
                                <div class="alignleft">
                                    <span class="residenttile textstyle0 ">Maria P. Detablurs</span>
                                </div>
                                <div class="alignleft">
                                    <span class="textstyle1">09123456789</span>
                                </div>
                                <div class="alignleft">
                                    <span class="textstyle1">123 Mabini Street, Quezon City...</span>
                                </div>
                            </button>
                        </td>
                        <td>
                            <div class="resize">
                                <img src="/images/icons/Residents/active.jpg">
                                <span>Active</span>
                            </div>
                        </td>
                        <td>See more...</td>
                        <td>Room</td>
                        <td>B10101</td>
                        <td>December 9, 2024</td>
                        <td>
                            <button id="openEditModalBtn" style="margin-right: 10px;">
                                <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#editmyModal">
                            </button>
                            <button id="openDeleteModalBtn" style="margin-right: 10px;">
                                <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#DeletemyModal">
                            </button>
                        </td>
                    </tr>
                    
                    
                    <!-- Additional rows can be added here -->
                </tbody>
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
    */
    ?>
    

<!-- Add Tenant Modal Revision-------------- -->
 <!-- Na remove na -->

<!-- Edit Tenant Modal Revision-------------- -->
<div class="modal fade" id="editmyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-custom">
            <div class="modal-header bg-custom">
                <h5 class="modal-title" id="exampleModalLabel">Edit Tenant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-custom">
                <form action="/action_page.php">
                    <!-- Name,Gender,Date -->
                    <div class="label label-position">
                        <div style="width: 65.9%;">Name:</div>
                        <div style="width: 17%;">Gender:</div>
                        <div>Birth Date:</div>
                    </div>
                    <div class="positioning">
                        <div class="NameInput">
                            <input type="text" id="Editfname" name="Editfirstname" placeholder="Maria" class="FNclass shadow" required>
                            <input type="text" id="Editmi" name="EditMiddle Initial" placeholder="P" class="MIclass shadow" required>
                            <input type="text" id="Editlname" name="Editlastname" placeholder="Detablurs" class="LNclass shadow" required>
                        </div>
                        <select id="country" name="country" class="shadow">
                          <option value="">...</option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                        </select>
                        <input type="date" id="lname" name="lastname" class="Bday shadow">
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
                        <input type="text" id="Edithouseno" name="Edithouseno" placeholder="123" class="houseno shadow" required>
                        <input type="text" id="Editstreet" name="Editstreet" placeholder="Mabini Street" class="street shadow" required>
                        <input type="text" id="Editbarangay" name="Editbarangay" placeholder="" class="barangay shadow" required>
                        <input type="text" id="Editcity" name="Editcity" placeholder="Quezon City" class="city shadow" required>
                        <input type="text" id="Editprovince" name="Editprovince" placeholder="Quezon" class="province shadow" required>
                    </div>
                    <div class="label label-position label-under">
                        <div class="label-houseno">House No.</div>
                        <div class="label-street">Street</div>
                        <div class="label-barangay">Barangay</div>
                        <div class="label-city">City</div>
                        <div class="label-province">Province</div>
                    </div>
                    <!-- Contact Number -->
                    <div class="label label-position">
                        <div>Contact Number:</div>
                    </div>
                    <div>
                        <input type="text" id="Editcountrycode" name="Editcountrycode" placeholder="+63" class="countrycode shadow" required>
                        <input type="number" id="Editnumber" name="Editnumber" placeholder="123456789" class="number shadow" required>
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
                            <input type="text" id="EditECfname" name="EditECfirstname" placeholder="Maria" class="FNclass shadow" required>
                            <input type="text" id="EditECmi" name="EditECMiddle Initial" placeholder="P" class="MIclass shadow" required>
                            <input type="text" id="EditEClname" name="EditEClastname" placeholder="Detablurs" class="LNclass shadow" required>
                        </div>
                        <input type="text" id="EditECcountrycode" name="EditECcountrycode" placeholder="+63" class="countrycode shadow" style="margin-right: 4px;">
                        <input type="number" id="EditECnumber" name="EditECnumber" placeholder="123456789" class="number shadow" required>
                    </div>
                    <div class="label label-position label-under">
                        <div class="label-fn">First Name</div>
                        <div class="label-mi">Middle Inital</div>
                        <div class="label-ln">Last Name</div>
                    </div>
                    <!-- Appliances -->
                    <div class="header label-position">
                        <div>Appliances</div>
                    </div>
                    <div>
                        <input type="text" id="Editappliance" name="Editappliance" placeholder="Rice cooker" class="appliance shadow" required>
                        <input type="image" id="deleteappliance" src="/images/icons/Residents/delete.png" alt="Submit" class="deleteappliance">
                    </div>
                    <div>
                        <input type="button" name="Addmore" id="Addmore" class="btn-var-5 shadow" value="Add More">
                    </div>
                    <div class="displayflex">
                        <input type="submit" name="edit-tenant-submit" class="btn-var-4 shadow" value="Save">
                    </div>
                  </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal Revision-------------- -->
<div class="modal fade" id="DeletemyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-custom">
            <div class="modal-header bg-custom border-0">
                <div class="displayflex header bg-custom">
                    <span style="font-size: 25px;">Are you Sure you want to delete this tenant?</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-custom">
                <form action="/action_page.php">
                    <div class="displayflex">
                        <input type="button" name="Yes" id="Yesdelete" class="btn-var-6" value="Yes">
                        <input type="button" name="No" id="Nodelete" class="btn-var-6" value="No">
                    </div>
                </form>
            </div>
            <div class="displayflex bg-custom label" style="border-radius: 10px;">
                <span>Note: Once you have clicked 'Yes', this cannot be undone</span>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<!-- Tenant Information Modal-------------- -->
<div class="modal fade" id="TenantInfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-custom">
            <div class="modal-header bg-custom">
                <span style="font-size: 25px;" class="header">Tenant Information</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-custom displayflex">
                <div class="split-left">
                    <div>
                        <span class="label">Name:</span>
                        <span style="font-size: 18px;">Maria P. Detablurs</span>
                    </div>
                    <div>
                        <span class="label">Contack Number:</span>
                        <span>+63 9123456789</span>
                    </div>
                    <div>
                        <span class="label">Address: </span>
                        <span>123 Mabini Street, Quezon City</span>
                    </div>
                    <div>
                        <span class="label">Gender:</span>
                        <span>Female</span>
                    </div>
                    <div>
                        <span class="label">Birth Date:</span>
                        <span>May 1, 2001</span>
                    </div>
                    <div>
                        <span class="label">Appliances:</span>
                        <span>Rice cooker</span>
                    </div>
                </div>
                <div class="split-right">
                    <div>
                        <span class="label" style="font-size: 20px;">Emergency Contact Information</span>
                    </div>
                    <div>
                        <span class="label">Name:</span>
                        <span style="font-size: 18px;">Ibarra F. Detablurs</span>
                    </div>
                    <div>
                        <span class="label">Contact Number:</span>
                        <span>+63 9123456789</span>
                    </div>
                </div>
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
                        <tbody>
                            <tr>
                                <td>B10101</td>
                                <td>April 9, 2024</td>
                                <td>March 9, 2024</td>
                            </tr>
                            <tr>
                                <td>B10101</td>
                                <td>March 9, 2024</td>
                                <td>April 9, 2024</td>
                            </tr>
                            <!-- Additional rows can be added here -->
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>
</div>

<?php html_end(); ?>