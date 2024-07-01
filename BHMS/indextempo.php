<?php 

// Start output buffering
ob_start();

// Database credentials class
class dbcreds {
    protected static $servername = "localhost";
    protected static $username = "root";
    protected static $password = "";
    protected static $dbname = "testing";

    // Connect to the database
    public static function connect() {
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}

// Function to display tenant and their appliances
function appliance_tenant() {
    $db = new dbcreds();
    $conn = $db->connect();
    // Query to join appliances and tenants tables
    $sql = "SELECT * FROM appliances JOIN tenants ON appliances.tenID = tenants.tenID";

    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        // Fetch and display each row
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['tenName'] . "</td><td>" . $row['appName'] . "</td></tr>";
        }
    } else {
        echo "<tr><td colspan='2'>No data available</td></tr>";
    }
}

// Function to get appliances for a specific tenant
function get_tenant_appliances($tenantId=48) {
    $db = new dbcreds();
    $conn = $db->connect();
    // Query to get appliances by tenant ID
    $sql = "SELECT * FROM appliances WHERE tenID = $tenantId";

    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $appliances = [];
        // Fetch all appliances and store them in an array
        while($row = $result->fetch_assoc()) {
            $appliances[] = $row;
        }
        return $appliances;
    } else {
        return [];
    }
}

// Function to display tenants and their appliances in a table
function tenants() {
    $db = new dbcreds();
    $conn = $db->connect();
    // Query to get all tenants
    $sql = "SELECT * FROM tenants";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch and display each tenant
        while ($row = $result->fetch_assoc()) {
            // Retrieve tenant appliances
            $appliances = get_tenant_appliances($row['tenID']);
            // Debug output to console (for checking appliances array)
            echo '<script>console.log('.json_encode($appliances).')</script>';
            // Output tenant row with edit button
            echo '<tr>';
            echo '<td>' . $row['tenName'] . '</td>';
            echo '<td>';
            echo '<button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"';
            echo ' onclick="showTenantData(' . htmlspecialchars(json_encode($appliances)) . ', \'' . $row['tenName'] . '\')">';
            echo 'Edit';
            echo '</button>';
            echo '<button>Delete</button>'; // Placeholder for delete functionality
            echo '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="2">No data available</td></tr>';
    }
}

// Function to insert new tenant data and associated appliances
function submit_new_data($tenantName, $appliances) {
    $db = new dbcreds();
    $conn = $db->connect();

    $tenantName = $conn->real_escape_string($tenantName); // Sanitize input
    echo '<script>console.log("Tenant Name: ", "'. $tenantName .'")</script>';
    // Insert tenant data
    $sql = "INSERT INTO tenants (tenName) VALUES ('$tenantName')";

    if ($conn->query($sql) === TRUE) {
        $tenantId = $conn->insert_id; // Get the last inserted tenant ID
        echo "Last inserted ID is: " . $tenantId;

        // Insert each appliance associated with the tenant
        foreach ($appliances as $appliance) {
            $applianceName = $conn->real_escape_string($appliance['appName']);
            echo '<script>console.log("Appliance Name: ", "'. $applianceName .'")</script>';
            $sql = "INSERT INTO appliances (tenID, appName) VALUES ($tenantId, '$applianceName')";
            if ($conn->query($sql) !== TRUE) {
                echo "Error inserting appliance: " . $conn->error;
            }
        }

        $conn->close();
        return "New records created successfully";
    } else {
        $conn->close();
        return "Error inserting tenant: " . $conn->error;
    }
}

// Function to update tenant data and associated appliances
function edit_data($editTenantName, $editTenantID, $editAppliances) {
    $db = new dbcreds();
    $conn = $db->connect();

    $editTenantName = $conn->real_escape_string($editTenantName); // Sanitize input
    echo '<script>console.log("Tenant Name: ", "'. $editTenantName .'")</script>';
    // Update tenant data
    $sql = "UPDATE tenants SET tenName = '$editTenantName' WHERE tenID = $editTenantID";

    if ($conn->query($sql) === TRUE) {
        echo "Tenant updated successfully";
        // Delete old appliances
        $sql = "DELETE FROM appliances WHERE tenID = $editTenantID";
        if ($conn->query($sql) === TRUE) {
            echo "Appliances deleted successfully";
            // Insert updated appliances
            foreach ($editAppliances as $appliance) {
                $applianceName = $conn->real_escape_string($appliance['appName']);
                echo '<script>console.log("Appliance Name: ", "'. $applianceName .'")</script>';
                $sql = "INSERT INTO appliances (tenID, appName) VALUES ($editTenantID, '$applianceName')";
                if ($conn->query($sql) !== TRUE) {
                    echo "Error inserting appliance: " . $conn->error;
                }
            }
            $conn->close();
            return "New records created successfully";
        } else {
            $conn->close();
            return "Error deleting appliances: " . $conn->error;
        }
    } else {
        $conn->close();
        return "Error updating tenant: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Test</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Bootstrap JS bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <style>
            body {
                height: 100vh;
            }
            body, div {
                border: 0.2px solid red; /* Temporary styling for layout visualization */
            }
        </style>
    </head>
    <body>

    <div class="container-fluid h-100">
        <div class="row d-flex">
            <div class="col-sm-6">
                <h1 class="text-center">Current Data</h1>
                <div>
                    <!-- Table displaying tenant and appliance data -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Tenant Name</th>
                                <th scope="col">Appliance Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                appliance_tenant(); // Call function to display data
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-6 d-flex flex-column">
                <div class="col-sm-5 w-100">
                    <div>
                        <h1 class="text-center">Add Data</h1>
                    </div>
                    <div>
                        <!-- Form to add new tenant and appliances -->
                        <form method="POST">
                            <label for="tenantName">Tenant name</label>
                            <input type="text" class="w-50" id="tenantName" name="tenantName">
                            <div id="appliances"></div>
                            <button id="addAppliance">Add Appliance</button>
                        </div>
                        <button type="submit" name="addNewData">Submit</button>
                    </form>
                </div>
                <div class="col-sm-5 w-100">
                    <div>
                        <h1 class="text-center">Tenants</h1>
                    </div>
                    <div>
                        <!-- Table displaying tenants with action buttons -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Tenant Name</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                tenants(); // Call function to display tenant data
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for editing tenant and appliances -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Tenant</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <label for="edit-tenantName">Tenant name</label>
                    <input type="text" class="w-50" id="edit-tenantName" name="edit-tenantName">
                    <input type="hidden" id="edit-tenantID" name="edit-tenantID">
                    <div id="edit-appliances"></div>
                    <button type="button" id="edit-addAppliance">Add Appliance</button>
                    <button type="submit" name="edit-data">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>
        
    <?php
        // Handle form submission for adding new tenant data
        if (isset($_POST['addNewData'])) {
            $tenantName = $_POST['tenantName'];
            $appliances = [];
            // Collect appliances from form
            foreach($_POST['appliances'] as $appliance) {
                $appliances[] = ['appName' => $appliance];
            }
        
            $result = submit_new_data($tenantName, $appliances); // Call function to insert data
            echo $result;
            header("Location: index.php"); // Redirect to refresh the page
        }

        // Handle form submission for editing tenant data
        if (isset($_POST['edit-data'])) {
            $editTenantName = $_POST['edit-tenantName'];
            $editTenantID = $_POST['edit-tenantID'];
            $editAppliances = [];
            // Collect appliances from form
            foreach($_POST['edit-appliances'] as $appliance) {
                $editAppliances[] = ['appName' => $appliance];
            }

            $result = edit_data($editTenantName, $editTenantID, $editAppliances); // Call function to update data
            echo $result;
            header("Location: index.php"); // Redirect to refresh the page
        }

    ?>
        
    <script>
        // Function to populate the edit modal with tenant data
        function showTenantData(appliance_array, tenName) {
            console.log("I work!");
            document.getElementById('edit-tenantName').value = tenName; // Set tenant name
            document.getElementById('edit-tenantID').value = appliance_array[0].tenID; // Set tenant ID
            const editAppliances = document.getElementById('edit-appliances');
            editAppliances.innerHTML = ''; // Clear previous content

            // Add each appliance to the modal
            appliance_array.forEach(appliance => {
                const applianceDiv = document.createElement('div');
                applianceDiv.innerHTML = `
                    <label for="edit-applianceName">Appliance name</label>
                    <input type="text" class="w-50" name="edit-appliances[]" value="${appliance.appName}" required>
                    <button type="button" onclick="editDeleteAppliance(this)">Delete</button>
                `;
                editAppliances.appendChild(applianceDiv);
            });

            console.log("Appliance Array:", appliance_array);
            console.log("Tenant Name:", tenName);
            console.log(appliance_array[0].tenID);
        }

        // Variables to track the number of appliances added dynamically
        const addAppliance = document.getElementById('addAppliance');
        const editAppliance = document.getElementById('edit-addAppliance');
        let applianceCount = 0;
        let editApplianceCount = 0;

        // Event listener to add appliance input fields in the edit form
        editAppliance.addEventListener('click', function(e) {
            e.preventDefault();
            if (editApplianceCount < 5) {
                const appliances = document.getElementById('edit-appliances');
                const appliance = document.createElement('div');
                appliance.innerHTML = `
                    <label for="edit-applianceName">Appliance name</label>
                    <input type="text" class="w-50" name="edit-appliances[]" required>
                    <button type="button" onclick="editDeleteAppliance(this)">Delete</button>
                `;
                appliances.appendChild(appliance);
                editApplianceCount++;
            }
        });

        // Function to remove an appliance input field from the edit form
        function editDeleteAppliance(button) {
            const appliance = button.parentNode;
            appliance.remove();
            editApplianceCount--;
        }

        // Event listener to add appliance input fields in the add form
        addAppliance.addEventListener('click', function(e) {
            e.preventDefault();
            if (applianceCount < 5) {
                const appliances = document.getElementById('appliances');
                const appliance = document.createElement('div');
                appliance.innerHTML = `
                    <label for="applianceName">Appliance name</label>
                    <input type="text" class="w-50" name="appliances[]" required>
                    <button type="button" onclick="deleteAppliance(this)">Delete</button>
                `;
                appliances.appendChild(appliance);
                applianceCount++;
            }
        });

        // Function to remove an appliance input field from the add form
        function deleteAppliance(button) {
            const appliance = button.parentNode;
            appliance.remove();
            applianceCount--;
        }

    </script>
    </body>
</html>

<?php
// Flush output buffer
ob_end_flush();
?>
