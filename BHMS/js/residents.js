// Get modal elements
var modal = document.getElementById("modal");
var openModalBtn = document.getElementById("openModalBtn");
var closeBtn = document.getElementsByClassName("close-btn")[0];

// Open the modal when the button is clicked
openModalBtn.onclick = function() {
    modal.style.display = "block";
}

// Close the modal when the close button is clicked
closeBtn.onclick = function() {
    modal.style.display = "none";
}

// Close the modal when clicking anywhere outside the modal content
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

document.addEventListener('DOMContentLoaded', (event) => {
    // Get the edit modal
    var editModal = document.getElementById("editModal");

    // Get the button that opens the edit modal
    var openEditBtn = document.getElementById("openEditModalBtn");

    // Get the close button inside the edit modal
    var closeEditBtn = document.querySelector(".close-edit-btn");

    // When the user clicks the button, open the edit modal 
    openEditBtn.onclick = function() {
        editModal.style.display = "block";
    }

    // When the user clicks on the close button, close the edit modal
    closeEditBtn.onclick = function() {
        editModal.style.display = "none";
    }

    // When the user clicks anywhere outside of the edit modal, close it
    window.onclick = function(event) {
        if (event.target == editModal) {
            editModal.style.display = "none";
        }
    }
});

document.addEventListener('DOMContentLoaded', (event) => {
    // Get the delete modal
    var deleteModal = document.getElementById("deleteModal");

    // Get the button that opens the delete modal
    var openDeleteBtn = document.getElementById("openDeleteModalBtn");

    // Get the close button inside the delete modal
    var closeDeleteBtn = document.querySelector(".close-delete-btn");

    // Get the cancel button inside the delete modal
    var cancelDeleteBtn = document.getElementById("cancelDeleteBtn");

    // When the user clicks the button, open the delete modal
    openDeleteBtn.onclick = function() {
        deleteModal.style.display = "block";
    }

    // When the user clicks on the close button, close the delete modal
    closeDeleteBtn.onclick = function() {
        deleteModal.style.display = "none";
    }

    // When the user clicks on the cancel button, close the delete modal
    cancelDeleteBtn.onclick = function() {
        deleteModal.style.display = "none";
    }

    // When the user clicks anywhere outside of the delete modal, close it
    window.onclick = function(event) {
        if (event.target == deleteModal) {
            deleteModal.style.display = "none";
        }
    }
});