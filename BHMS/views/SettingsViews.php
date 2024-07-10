<?php

require 'GeneralViews.php';
require '../controllers/SettingsController.php';


/**
 * This class contains all the views that are used in the settings page.
 * 
 * @method settings_header
 * @method user_info_section
 * @method rates_and_pricing_model_view
 * @method user_information_model_view
 * @method create_user_info_model_view
 * @method edit_user_info
 * @method delete_user_info
 * @class SettingsViews
 */
class SettingsViews extends GeneralViews {

    /**
     * This method is used to display the settings header.
     * 
     * @method settings_header
     * @param none
     * @return void
     */
    public static function settings_header(){
        echo <<<HTML
        <div class="settings-header" >
        <span class="page-header">Settings</span><br>
        <span style="color:#5f5f5f;">View and manage settings to the business</span>
        </div>

        HTML;
    }

    /**
     * This method is used to display the user information section.
     * 
     * @method user_info_section
     * @param none
     * @return void
     */
    public static function user_info_section(){
        $userData = SettingsController::fetch_user_info($_SESSION['userID']);
        echo '
        <div class="user-profile shadow">
            <span class="user-name">'
                . ($userData['userFname'] ?? '') . ' ' 
                . (isset($userData['userMI']) ? $userData['userMI'] . '.' : '') . ' ' 
                . ($userData['userLname'] ?? '') . 
            '</span><br>
            <span class="user-type">'
                . ($userData['userType'] ?? '') . '</span>
        </div>
        ';
    }


    /**
     * This method is used to display the rates and pricing modal.
     * 
     * @method rates_and_pricing_model_view
     * @param none
     * @return void
     */
    public static function rates_and_pricing_model_view() {

        $applianceRate = SettingsController::getApplianceRate();
        $occupancyRates = SettingsController::getRates();
        
        $bedRate = $occupancyRates[0]['occRate'];
        $roomRate1 = $occupancyRates[1]['occRate'];
        $roomRate2 = $occupancyRates[2]['occRate'];
        $roomRate3 = $occupancyRates[3]['occRate'];
        $roomRate4 = $occupancyRates[4]['occRate'];

        $bedRateID = $occupancyRates[0]['occTypeID'];
        $roomRate1ID = $occupancyRates[1]['occTypeID'];
        $roomRate2ID = $occupancyRates[2]['occTypeID'];
        $roomRate3ID = $occupancyRates[3]['occTypeID'];
        $roomRate4ID = $occupancyRates[4]['occTypeID'];
    
        echo <<<HTML
        <div class="modal fade" id="ratesAndPricingModal" tabindex="-1" role="dialog" aria-labelledby="ratesAndPricingModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ratesModalLabel">Rates and Pricing</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form id="ratesForm" method="POST">
                            <h5 class="modal-subtitle">Appliance Rates:</h5>
                            <div class="input-with-edit">
                                <input type="text" id="appRate" class="form-control modal-input shadow"  name="ApplianceRate" value="{$applianceRate}" placeholder="{$applianceRate}" readonly>
                                <span class="edit" onclick="enableEdit(this)">edit</span>
                            </div>
                            <p class="monthly-cost">Monthly Cost</p>
                            <h5 class="modal-subtitle">Bed Rates:</h5>
                            <div class="input-with-edit">
                                <input id="bedRate" type="text" class="form-control modal-input shadow" name="bedRate" value="{$bedRate}" placeholder="{$bedRate}" readonly>
                                <span class="edit" onclick="enableEdit(this)">edit</span>
                                <input type="hidden" name="bedRateID" value="{$bedRateID}">
                            </div>
                            <p class="monthly-cost">Monthly Cost</p> 
                            <h5 class="modal-subtitle">Room Rates:</h5>
                            <div class="room-rate">
                                <p class="room-rate-label">Room 1 (6-Bed Capacity)</p>
                                <p class="room-rate-info">Applies if occupants are less than or equal to three</p>
                                <div class="input-with-edit">
                                    <input type="text" id="roomOne" class="form-control modal-input shadow" name="roomOne" value="{$roomRate1}" placeholder="{$roomRate1}" readonly>
                                    <span class="edit" onclick="enableEdit(this)">edit</span>
                                    <input type="hidden" name="roomRate1ID" value="{$roomRate1ID}">
                                </div>
                                <p class="monthly-cost">Monthly Cost</p>
                            </div>
                            <div class="room-rate">
                                <p class="room-rate-label">Room 2 (6-Bed Capacity)</p>
                                <p class="room-rate-info">Applies if occupants are more than three</p>
                                <div class="input-with-edit">
                                    <input type="text" id="roomTwo" class="form-control modal-input shadow" name="roomTwo" value="{$roomRate2}" placeholder="{$roomRate2}" readonly>
                                    <span class="edit" onclick="enableEdit(this)">edit</span>
                                    <input type="hidden" name="roomRate2ID" value="{$roomRate2ID}">
                                </div>
                                <p class="monthly-cost">Monthly Cost</p>
                            </div>
                            <div class="room-rate">
                                <p class="room-rate-label">Room 3 (4-Bed Capacity)</p>
                                <p class="room-rate-info">Applies if occupants are less than or equal to two</p>
                                <div class="input-with-edit">
                                    <input type="text" id="roomThree" class="form-control modal-input shadow" name="roomThree" value="{$roomRate3}" placeholder="{$roomRate3}" readonly>
                                    <span class="edit" onclick="enableEdit(this)">edit</span>
                                    <input type="hidden" name="roomRate3ID" value="{$roomRate3ID}">
                                </div>
                                <p class="monthly-cost">Monthly Cost</p>
                            </div>
                            <div class="room-rate">
                                <p class="room-rate-label">Room 4 (4-Bed Capacity)</p>
                                <p class="room-rate-info">Applies if occupants are more than two</p>
                                <div class="input-with-edit">
                                    <input type="text" id="roomFour" class="form-control modal-input shadow" name="roomFour" value="{$roomRate4}" placeholder="{$roomRate4}" readonly>
                                    <span class="edit" onclick="enableEdit(this)">edit</span>
                                    <input type="hidden" name="roomRate4ID" value="{$roomRate4ID}">
                                </div>
                                <p class="monthly-cost-bottom">Monthly Cost</p>
                            </div>
                            <button type="submit" class="btn-save-changes shadow" id="edit-rate-pricing" name="edit-rate-pricing" >Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        HTML;
    }
    

    /**
     * This method is used to display the user information model view.
     * 
     * @method user_information_model_view
     * @param array $user_list - list of users
     * @return void
     */
    public static function user_information_model_view($user_list){
        echo <<<HTML
        <div class="modal fade" id="userInfoModal" tabindex="-1" role="dialog" aria-labelledby="userInfoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userInfoModalLabel">User Information</h5>
                        <div class="header-buttons">
                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <table class="table shadow">
                            <thead class="table-header">
                                <tr>
                                    <th>Names</th>
                                    <th>Status</th>
                                    <th>Position</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
        HTML; 
    
        // Loop for user info in the list
        foreach ($user_list as $user) {
            $userDataJson = htmlspecialchars(json_encode($user));
            $statusImage = $user['isActive'] ? 'active.jpg' : 'inactive.jpg';
            $statusText = $user['isActive'] ? 'active' : 'inactive';
            // para edit og delete
            $userID = $user['userID'];
            $userFname = $user['userFname'];
            $userMname = $user['userMI'];
            $userLname = $user['userLname'];
            $isActive = $user['isActive'];
            $userType = $user['userType'];
            $username = $user['username'];
            $password = $user['password'];
            
            $userMIFormatted = ($user['userMI'] != NULL) ? $user['userMI'] . '.' : '';
            echo <<<HTML
            <tr class="userInfoRow" data-user="$userDataJson">
                <td>{$userFname} {$userMIFormatted} {$userLname}</td>
                <td>
                    <div class="resize">
                        <img src="/images/icons/Residents/$statusImage">
                        <span>$statusText</span>
                    </div>
                </td>
                <td>{$userType}</td>
                <td>
                    <button class="bg-transparent" data-bs-toggle="modal" data-bs-target="#editUserInfoModal" style="border: none;" 
                    onclick="editUser('$userID', '$userFname', '$userMname', '$userLname','$isActive','$userType','$username','$password')">
                        <img src="/images/icons/Residents/edit.png" alt="Edit" class="action">
                    </button>
                    <button class="bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteUserInfoModal" onclick="deleteUser($userID)" style="border: none">
                        <img src="/images/icons/Residents/delete.png" alt="Delete" class="action">
                    </button>
                </td>
            </tr>
            HTML;
        }
    
        echo <<<HTML
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        HTML;
    }


    /**
     * This method is used to display the create user information model view.
     * 
     * @method create_user_info_model_view
     * @param none
     * @return void
     */
    public static function create_user_info_model_view(){
        echo <<<HTML
        <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <form id="createUserForm"  method="POST">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Create User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="userName" class="form-label">Name:</label>
                        <!-- userFName -->
                        <input type="text" id="userFname" name="userFname" placeholder="First Name" class="FNclass shadow" onkeyup="checkFields();" required>
                        <!-- userMname -->
                        <input type="text" id="userMname" name="userMname" placeholder="MI" class="MIclass shadow" onkeyup="checkFields();" required>
                        <!-- userLName -->
                        <input type="text" id="userLname" name="userLname" placeholder="Last Name" class="LNclass shadow" onkeyup="checkFields();" required>
                    </div>
                    <p class="monthly-cost">First Name, Middle Initial, Last Name</p>
                    <div class="mb-3">
                        <label for="userStatus" class="form-label">Status:</label>
                        <!-- isActive -->
                        <select class="form-select shadow" id="isActive" name="isActive" onkeyup="checkFields();" required>
                            <option value="choose a status" selected>Choose a status</option>
                            <option value="1"><strong>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="userPosition" class="form-label">Position:</label>
                        <!-- userType -->
                        <select class="form-select shadow" id="userType" name="userType" onkeyup="checkFields();" required>
                            <option value="choose a status" selected>Choose a user type</option>
                            <option value="staff"><strong>Staff</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <!-- username -->
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" id="username" name="username" placeholder="Input username" class="form-control shadow" onkeyup="checkFields();" required>
                    </div>
                    <div class="mb-3">
                        <!-- password -->
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control shadow" id="password" name="password" placeholder="Input password" onkeyup="checkFields();" required>
                    </div>
                    <div class="mb-3">
                        <!-- confirm password -->
                        <label for="confirmPassword" class="form-label">Confirm Password:</label>
                        <input type="password" class="form-control shadow" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" onkeyup="checkPasswordMatch();" required>
                    </div>
                    <span id="confirmPassWarning" style="color: red;"></span>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="create-user-submit" name="create-user-submit" class="btn-create-save shadow" data-bs-dismiss="modal" >Create</button>
                </div>
                </div>
            </form>
            </div>
        </div>
        HTML;
    }


    /**
     * This method is used to display the edit user information model view.
     * 
     * @method edit_user_info
     * @param none
     * @return void
     */
    public static function edit_user_info(){
        echo <<< HTML
        <div class="modal fade" id="editUserInfoModal" tabindex="-1" aria-labelledby="editUserInfoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Edit User Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                <form id="editUserInfoForm" method="POST">
                        <!-- Hidden  input for ID-->
                        <input type="hidden" id="Edit-userID" name="Edit-userID" value = "">
                    <div class="mb-3">
                        <label for="userName" class="form-label">Name:</label>
                        <!-- Edit-userFname -->
                        <input type="text" id="Edit-userFname" name="Edit-userFname" placeholder="Juan Jihyo" class="FNclass shadow" onkeyup="editcheckFields();" required>
                        <!-- Edit-userMname -->
                        <input type="text" id="Edit-userMname" name="Edit-userMname" placeholder="D." class="MIclass shadow" onkeyup="editcheckFields();">
                        <!-- Edit-userLname -->
                        <input type="text" id="Edit-userLname" name="Edit-userLname" placeholder="Santos" class="LNclass shadow" onkeyup="editcheckFields();" required>
                    </div>
                    <p class="monthly-cost">First Name, Middle Initial, Last Name</p>
                    <div class="mb-3">
                        <!-- Edit-userStatus -->
                        <label for="userStatus" class="form-label">Status:</label>
                        <select class="form-select shadow" id="Edit-isActive" name="Edit-isActive" onkeyup="editcheckFields();" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <!-- Edit-userType -->
                        <label for="userPosition" class="form-label">Position:</label>
                        <input type="text" class="form-control shadow" id="Edit-userType" name="Edit-userType" placeholder="Admin" onkeyup="editcheckFields();" required>
                    </div>
                    
                    <div class="mb-3">
                        <!-- Edit-userName -->
                        <label for="userPosition" class="form-label">Username:</label>
                        <input type="text" class="form-control shadow" id="Edit-userName" name="Edit-userName" placeholder="Admin" onkeyup="editcheckFields();" required>
                    </div>

                    <div class="mb-3">
                        <!-- Edit-password -->
                        <label for="Edit-password" class="form-label">Password:</label>
                        <input type="password" class="form-control shadow" id="Edit-password" name="Edit-password" placeholder="Admin" onkeyup="editcheckFields();" required>
                    </div>

                    <div class="mb-3">
                        <!-- Edit-confirmpassword -->
                        <label for="Edit-confirmPassword" class="form-label">Confirm password:</label>
                        <input type="password" class="form-control shadow" id="Edit-confirmPassword" name="Edit-confirmPassword" placeholder="" onkeyup="PasswordMatchEdit();" required>
                    </div>
                    <div class="mb-3">
                        <span id="Edit-confirmPassWarning" style="color: red;"></span>
                    </div>

                    <div class="modal-footer border-0">
                    <button type="submit" class="btn-create-save shadow" data-bs-dismiss="modal" id="edit-confirm" name = "edit-confirm">Save</button>
                    </div>
                </form>
                </div>
                
                </div>
            </div>
        </div>
        HTML;
    }


    /**
     * This method is used to display the delete user information model view.
     * 
     * @method delete_user_info
     * @param none
     * @return void
     */
    public static function delete_user_info() {
        echo <<<HTML
        <div class="modal fade" id="deleteUserInfoModal" tabindex="-1" aria-labelledby="deleteUserInfoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                <p class="confirmation-question">Are you sure you want to delete this user?</p>
                <form id="deleteUserInfoForm" method="POST">
                    <input type="hidden" name="deleteUserID" id="Delete-userID">
                    <div class="button-container">
                        <button type="submit" name="deleteUserInfoSubmit" id="Yesdelete" class="btn-delete-yes">Yes</button>
                        <button type="button" name="deleteUserInfoButton" class="btn-delete-no" data-bs-dismiss="modal" aria-label="Close">No</button>
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