
function displayeditModal(maintID, roomID, maintDate, maintStatus, maintDesc, maintCost) {
    // Example implementation (replace with your actual modal logic)
    console.log("Editing maintenance ID: " + maintID);
    console.log("Room ID: " + roomID);
    console.log("Date: " + maintDate);
    console.log("Status: " + maintStatus);
    console.log("Description: " + maintDesc);
    console.log("Cost: " + maintCost);

    document.getElementById("Edit-maintID").value = maintID;
    document.getElementById("Edit-roomID").value = roomID;
    document.getElementById("Edit-maintDate").value = maintDate;
    document.getElementById("Edit-maintStatus").value = maintStatus;
    document.getElementById("Edit-maintDesc").value = maintDesc;
    document.getElementById("Edit-maintCost").value = maintCost;

    // Populate your modal fields or perform any other necessary actions
}
function displaydeleteModal(maintID) {
    document.getElementById("deleteMaintID").value = maintID;
    console.log("Displaying delete modal for maintenance ID: " + maintID);
    document.getElementById('deleteMaintenanceForm').action = "./maintenance.php?maintID=" + maintID;
}


// To be Asked !
document.addEventListener('DOMContentLoaded', function() {
    // Function to close modal given the modal element and button id
    function setupModalClose(modalId, buttonId) {
        var closeButton = document.getElementById(buttonId);
        var modalElement = document.getElementById(modalId);
        var modalInstance = new bootstrap.Modal(modalElement);

        closeButton.addEventListener('click', function() {
            modalInstance.hide(); // Hide the modal
        });
    }

    // Setup closing for AddModal
    setupModalClose('add-modal-info', 'addCloseButton');

    // Setup closing for EditModal
    setupModalClose('edit-modal-info', 'editCloseButton');
});    