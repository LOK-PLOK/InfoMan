// Delete Modal
function displaydeleteModal(tenID) {
    // Get the modal element (if you need to modify its display directly)
    var modalEdit = document.getElementById("DeletemyModal");

    // Populate the modal fields with the passed data
    document.getElementById('deleteTenantId').value = tenID;

    // Set the form action with the tenant ID
    document.getElementById('deleteTenantForm').action = "./residents.php?tenID=" + tenID;
}

// Edit Modal Content Injecter
function showTenantData(appliance_array, tenantData){

    console.log('Appliance Array:', appliance_array);
    console.log('Tenant Data:', tenantData);

    const editAppliances = document.getElementById('Edit-applianceContainer');
    editAppliances.innerHTML = '';

    // Display the tenant data
    document.getElementById('Edit-tenID').value = tenantData.tenID;
    document.getElementById('Edit-tenFname').value = tenantData.tenFname;
    document.getElementById('Edit-tenMI').value = tenantData.tenMI;
    document.getElementById('Edit-tenLname').value = tenantData.tenLname;
    document.getElementById('Edit-tenGender').value = tenantData.tenGender;
    document.getElementById('Edit-tenBdate').value = tenantData.tenBdate;
    document.getElementById('Edit-tenHouseNum').value = tenantData.tenHouseNum;
    document.getElementById('Edit-tenSt').value = tenantData.tenSt;
    document.getElementById('Edit-tenBrgy').value = tenantData.tenBrgy;
    document.getElementById('Edit-tenCityMun').value = tenantData.tenCityMun;
    document.getElementById('Edit-tenProvince').value = tenantData.tenProvince;
    document.getElementById('Edit-tenContact').value = tenantData.tenContact;
    document.getElementById('Edit-emContactFname').value = tenantData.emContactFname;
    document.getElementById('Edit-emContactMI').value = tenantData.emContactMI;
    document.getElementById('Edit-emContactLname').value = tenantData.emContactLname;
    document.getElementById('Edit-emContactNum').value = tenantData.emContactNum;
    

    appliance_array.forEach((appliance, index) => {
        const applianceDiv = document.createElement('div');
        applianceDiv.style = "margin-bottom: 5px;";
        applianceDiv.innerHTML = `
            <input type="text" class="appliance shadow" name="edit-appliances[]" value="${appliance.appInfo}" required>
            <button type="button" class="deleteButton" onclick="edit_deleteAppliance(this)" style ="background: none; border: medium; margin-left: 10px;">
            <img class="deleteapplinace" src="/images/icons/Residents/delete.png" alt="Delete" style="width: 30px !important;  height: 30px !important;"></button>
        `;
        editApplianceCount++;
        editAppliances.appendChild(applianceDiv);
        console.log('Appliance', index + 1, ':', appliance);
    });

}

// Delete Appliance (Create Operation)
function deleteAppliance(button) {
    const appliance = button.parentNode;
    appliance.remove();
    addApplianceCount--;
}

// Delete Appliance (Update Operation)
function edit_deleteAppliance(button) {
    const appliance = button.parentNode;
    appliance.remove();
    editApplianceCount--;
}

// Button Event Listeners For Appliances
const addApplianceBtn = document.getElementById('addMoreAppliance');
const editApplianceBtn = document.getElementById('editMoreAppliance');
let addApplianceCount = 0;
let editApplianceCount = 0;

addApplianceBtn.addEventListener('click', function(e) {
    e.preventDefault();
    if (addApplianceCount < 5) {
        const applianceContainer = document.getElementById('applianceContainer');
        const appliance = document.createElement('div');
        appliance.style = "margin-bottom: 5px;";
        appliance.innerHTML = `
            <input type="text" class="appliance shadow" name="appliances[]" placeholder="Appliance ${addApplianceCount + 1}" required>
            <button type="button" class="deleteButton" onclick="deleteAppliance(this)" style ="background: none; border: medium; margin-left: 10px;">
            <img class="deleteapplinace" src="/images/icons/Residents/delete.png" alt="Delete" style="width: 30px !important;  height: 30px !important;"></button>
        `;
        applianceContainer.appendChild(appliance);
        addApplianceCount++;
    }   
});


editApplianceBtn.addEventListener('click', function(e) {
    e.preventDefault();
    if (editApplianceCount < 5) {
        const applianceContainer = document.getElementById('Edit-applianceContainer');
        const appliance = document.createElement('div');
        appliance.style = "margin-bottom: 5px;";
        appliance.innerHTML = `
            <input type="text" class="appliance shadow" name="edit-appliances[]" placeholder="Appliance ${editApplianceCount + 1}" required>
            <button type="button" class="deleteButton" onclick="edit_deleteAppliance(this)" style ="background: none; border: medium; margin-left: 10px;">
            <img class="deleteapplinace" src="/images/icons/Residents/delete.png" alt="Delete" style="width: 30px !important;  height: 30px !important;"></button>
        `;  
        applianceContainer.appendChild(appliance);
        editApplianceCount++;
    }   
});




