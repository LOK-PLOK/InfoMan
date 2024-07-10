//rates and pricing edit button
function enableEdit(span) {
    const input = span.previousElementSibling;
    input.removeAttribute('readonly');
    span.style.display = 'none'; // Hide the edit span

    // Clicking away from input
    input.addEventListener('blur', () => {
        input.setAttribute('readonly', true);
        span.style.display = 'inline'; // Show the edit span again
    });
}

function checkPasswordMatch() {
    var pass = document.getElementById('password').value;
    var confPass = document.getElementById('confirmPassword').value;
    var errorSpan = document.getElementById('confirmPassWarning');
    var submitBtn = document.getElementById('create-user-submit');

    if(pass !== confPass) {
        errorSpan.textContent = "*Passwords do not match.";
        submitBtn.disabled = true;
    } else {
        errorSpan.textContent = "";
        checkFields();
    }
}

function checkFields() {
    var userFname = document.getElementById('userFname').value;
    var userMname = document.getElementById('userMname').value;
    var userLname = document.getElementById('userLname').value;
    var isActive = document.getElementById('isActive').value;
    var userType = document.getElementById('userType').value;
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirmPassword').value;
    var submitBtn = document.getElementById('create-user-submit');

    if (userFname === "" || userMname === "" || userLname === "" || isActive === "" || userType === "" || username === "" || password === "" || confirmPassword === "") {
        submitBtn.disabled = true;
    } else {
        submitBtn.disabled = false;
    }   
}
checkFields();

function editUser(UserID,userFname,userMname,userLname,isActive,userType,username,password){
    document.getElementById('Edit-userID').value = UserID;
    document.getElementById('Edit-userFname').value = userFname;
    document.getElementById('Edit-userMname').value = userMname;
    document.getElementById('Edit-userLname').value = userLname;
    document.getElementById('Edit-userName').value = username;
    document.getElementById('Edit-password').value = password;
    document.getElementById('Edit-userType').value = userType;
    document.getElementById('Edit-isActive').value = isActive;
}

// function PasswordMatchEdit(){
//     var pass = document.getElementById('Edit-password').value;
//     var confPass = document.getElementById('Edit-confirmPassword').value;
//     var errorSpan = document.getElementById('Edit-confirmPassWarning');
//     var submitBtn = document.getElementById('edit-confirm');

//     if(pass !== confPass) {
//         errorSpan.textContent = "*Passwords do not match.";
//         submitBtn.disabled = true;
//     } else {
//         errorSpan.textContent = "";
//         editcheckFields();
//     }   
// }

function editcheckFields() {
    var confirmPassword = document.getElementById('Edit-confirmPassword').value;
    var submitBtn = document.getElementById('edit-confirm');

    if (confirmPassword === "") {
        submitBtn.disabled = true;
    } else {
        submitBtn.disabled = false;
    }   
}

editcheckFields();

const createUserForm = document.getElementById('createUserForm');

function deleteUser(userID) {
    document.getElementById('Delete-userID').value = userID;
}