
function displayEditModal(tenID, tenFname, tenLname, tenMI, tenHouseNum, tenSt, tenBrgy, tenCityMun, tenProvince, tenContact, tenBdate, tenGender, emContactFname, emContactLname, emContactMI, emContactNum) {
    // Get the modal element (if you need to modify its display directly)
    var modalEdit = document.getElementById("editmyModal");

    // Populate the modal fields with the passed data
    document.getElementById('Edit-tenID').value = tenID;
    document.getElementById('Edit-tenFname').value = tenFname;  
    document.getElementById('Edit-tenLname').value = tenLname;
    document.getElementById('Edit-tenMI').value = tenMI;
    document.getElementById('Edit-tenHouseNum').value = tenHouseNum;
    document.getElementById('Edit-tenSt').value = tenSt;
    document.getElementById('Edit-tenBrgy').value = tenBrgy;
    document.getElementById('Edit-tenCityMun').value = tenCityMun;
    document.getElementById('Edit-tenProvince').value = tenProvince;
    document.getElementById('Edit-tenContact').value = tenContact;
    document.getElementById('Edit-tenBdate').value = tenBdate;
    document.getElementById('Edit-tenGender').value = tenGender;
    document.getElementById('Edit-emContactFname').value = emContactFname;
    document.getElementById('Edit-emContactLname').value = emContactLname;
    document.getElementById('Edit-emContactMI').value = emContactMI;
    document.getElementById('Edit-emContactNum').value = emContactNum;

    // Set the form action with the tenant ID
    document.getElementById('editTenantForm').action = "./residents.php?tenID=" + tenID;
}

function displaydeleteModal(tenID) {
    // Get the modal element (if you need to modify its display directly)
    var modalEdit = document.getElementById("DeletemyModal");

    // Populate the modal fields with the passed data
    document.getElementById('deleteTenantId').value = tenID;
    

    // Set the form action with the tenant ID
    document.getElementById('deleteTenantForm').action = "./residents.php?tenID=" + tenID;
}


