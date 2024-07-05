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
    console.log("I reached here1");
    e.preventDefault();
    if (addApplianceCount < 5) {
        console.log("I reached here2");
        const applianceContainer = document.getElementById('applianceContainer');
        console.log("I reached here3");
        const appliance = document.createElement('div');
        console.log("I reached here4");
        appliance.style = "margin-bottom: 5px;";
        appliance.innerHTML = `
            <input type="text" class="appliance shadow" name="appliances[]" placeholder="Appliance ${addApplianceCount + 1}" required>
            <button type="button" class="deleteButton" onclick="deleteAppliance(this)" style ="background: none; border: medium; margin-left: 10px;">
            <img class="deleteapplinace" src="/images/icons/Residents/delete.png" alt="Delete" style="width: 30px !important;  height: 30px !important;"></button>
        `;
        applianceContainer.appendChild(appliance);
        addApplianceCount++;
    }   
    console.log("I reached here5");
});



