<?php
    require '../php/templates.php';
    html_start('settings.css');
?>

<!-- Sidebar -->
<?php require '../php/navbar.php'; ?>

<!-- Burger Sidebar -->
<div class="hamburger-sidebar">
    <i class="fa-solid fa-bars"></i>
</div>

<!-- Room Logs Section -->
<div class="container-fluid">

    <!-- Header -->
    <div class="settings-header" >
        <span class="page-header">Settings</span><br>
        <span style="color:#5f5f5f;">View and manage settings to the business</span>
    </div>
    
    <div class="user-profile shadow">
        <span class="user-name">Juan Jihyo De los Santos</span><br>
        <span class="user-type">Admin</span>
    </div>

    <!-- Button Triggers for Modals -->
    <div class="section">
        <button class="rate-price-cont shadow" data-bs-toggle="modal" data-bs-target="#ratesAndPricingModal">
            <img src="/images/icons/Settings/rates_and_pricing.png" alt="rates and pricing icon">
            <span>Rates and Pricing</span>
            <i class="fa-solid fa-angle-right"></i>
        </button>

        <button class="rate-price-cont shadow" data-bs-toggle="modal" data-bs-target="#userInfoModal">
            <img src="/images/icons/Settings/user_info_dark.png" alt="user information icon">
            <span>User Information</span>
            <i class="fa-solid fa-angle-right"></i>
        </button>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="ratesAndPricingModal" tabindex="-1" role="dialog" aria-labelledby="ratesAndPricingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ratesModalLabel">Rates and Pricing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 class="modal-subtitle">Bed Rates:</h5>
                <div class="input-with-edit">
                    <input type="text" class="form-control modal-input shadow" placeholder="600.00">
                    <span class="edit">edit</span>
                </div>
                <p class="monthly-cost">Monthly Cost</p>
                <hr>
                <h5 class="modal-subtitle">Room Rates:</h5>
                <div class="room-rate">
                    <p class="room-rate-label">Room Rate 1</p>
                    <p class="room-rate-info">Room Capacity: 4 (Applies if occupants are less than or equal to two)</p>
                    <div class="input-with-edit">
                        <input type="text" class="form-control modal-input shadow" placeholder="2000.00">
                        <span class="edit">edit</span>
                    </div>
                    <p class="monthly-cost">Monthly Cost</p>
                </div>
                <div class="room-rate">
                    <p class="room-rate-label">Room Rate 2</p>
                    <p class="room-rate-info">Room Capacity: 4 (Applies if occupants are more than two)</p>
                    <div class="input-with-edit">
                        <input type="text" class="form-control modal-input shadow" placeholder="2400.00">
                        <span class="edit">edit</span>
                    </div>
                    <p class="monthly-cost-bottom">Monthly Cost</p>
                </div>
                <button type="button" class="btn-save-changes shadow" data-bs-dismiss="modal">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="userInfoModal" tabindex="-1" role="dialog" aria-labelledby="userInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userInfoModalLabel">User Information</h5>
                <div class="header-buttons">
                <button type="button" class="btn btn-primary shadow" id="createUserButton" data-bs-toggle="modal" data-bs-target="#createUserModal">Create User</button>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead class="table-header">
                        <tr>
                            <th>Names</th>
                            <th>Status</th>
                            <th>Position</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Juan Jihyo De los Santos</td>
                            <td>
                            <div class="resize">
                                <img src="/images/icons/Residents/active.jpg">
                                <span>Active</span>
                            </div>
                            </td>
                            <td>Admin</td>
                            <td>
                            <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#editUserInfoModal">
                            <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#deleteUserInfoModal">
                            </td>
                        </tr>
                        <tr>
                            <td>Sharon Mina Cuizon</td>
                            <td>
                            <div class="resize">
                                <img src="/images/icons/Residents/inactive.jpg">
                                <span>Inactive</span>
                            </div>
                            </td>
                            <td>Staff</td>
                            <td>
                            <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#editUserInfoModal">
                            <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#deleteUserInfoModal">
                            </td>
                        </tr>
                        <tr>
                            <td>Momo Hirai</td>
                            <td>
                            <div class="resize">
                                <img src="/images/icons/Residents/active.jpg">
                                <span>Active</span>
                            </div>
                            </td>
                            <td>Staff</td>
                            <td>
                            <img src="/images/icons/Residents/edit.png" alt="Edit" class="action" data-bs-toggle="modal" data-bs-target="#editUserInfoModal">
                            <img src="/images/icons/Residents/delete.png" alt="Delete" class="action" data-bs-toggle="modal" data-bs-target="#deleteUserInfoModal">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createUserModalLabel">Create User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form -->
        <form>
          <!-- Name -->
          <div class="mb-3">
            <label for="userName" class="form-label">Name:</label>
            <input type="text" id="fname" name="firstname" placeholder="First Name" class="FNclass shadow" required>
            <input type="text" id="mi" name="Middle Initial" placeholder="Middle Initial" class="MIclass shadow" required>
            <input type="text" id="lname" name="lastname" placeholder="Last Name" class="LNclass shadow" required>
          </div>
          <p class="monthly-cost">First Name, Middle Initial, Last Name</p>
          <!-- Status -->
          <div class="mb-3">
            <label for="userStatus" class="form-label">Status:</label>
            <select class="form-select" id="userStatus" required>
                <option value="choose a status">Choose a status</option>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
          <!-- Position -->
          <div class="mb-3">
            <label for="userPosition" class="form-label">Position:</label>
            <input type="text" class="form-control" id="userPosition" placeholder="Enter position" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-create-save shadow" data-bs-dismiss="modal">Create</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editUserInfoModal" tabindex="-1" aria-labelledby="editUserInfoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createUserModalLabel">Edit User Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form -->
        <form>
          <!-- Name -->
          <div class="mb-3">
            <label for="userName" class="form-label">Name:</label>
            <input type="text" id="fname" name="firstname" placeholder="Juan Jihyo" class="FNclass shadow" required>
            <input type="text" id="mi" name="Middle Initial" placeholder="D." class="MIclass shadow" required>
            <input type="text" id="lname" name="lastname" placeholder="Santos" class="LNclass shadow" required>
          </div>
          <p class="monthly-cost">First Name, Middle Initial, Last Name</p>
          <!-- Status -->
          <div class="mb-3">
            <label for="userStatus" class="form-label">Status:</label>
            <select class="form-select" id="userStatus" required>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
          <!-- Position -->
          <div class="mb-3">
            <label for="userPosition" class="form-label">Position:</label>
            <input type="text" class="form-control" id="userPosition" placeholder="Admin" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-create-save shadow" data-bs-dismiss="modal">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteUserInfoModal" tabindex="-1" aria-labelledby="deleteUserInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <p class="confirmation-question">Are you sure you want to delete this user?</p>
          <div class="button-container">
            <button type="button" class="btn-delete-yes" id="deleteUserYes">Yes</button>
            <button type="button" class="btn-delete-no" data-bs-dismiss="modal">No</button>
          </div>
          <p class="note">Note: Once you have clicked 'Yes', this cannot be undone.</p>
        </div>
      </div>
    </div>
  </div>


    <!-- Login Settings Actual -->
    <div class="login-sett-cont">
        <div class="settings-sub-header" >
            <div>
                <span class="page-header" style="font-size: 30px;">Login Settings</span><br>
                <span style="color:#5f5f5f;">Change your username and password for enhanced security measures.</span>
            </div>
        </div>
        <div class="edit-acc-cont">
            <button class="save-btn btn-var-1 shadow">Save Changes</button>
            <label for="ch-username">Username</label><br>
            <div class="input-cont">
                <input type="text" id="ch-username" placeholder="AdminThingz1">
                <a href="">edit</a>
            </div>
            <hr>
            <label for="ch-password">Password</label><br>
            <div class="input-cont">
                <input type="password" id="ch-password" placeholder="***********"><br>
                <a href="">edit</a>
            </div>
            <button class="sign-out-btn btn-var-2 shadow">Sign-out</button>
        </div>
    </div>
</div>


<script src="/js/general.js"></script>
    
<?php html_end(); ?>