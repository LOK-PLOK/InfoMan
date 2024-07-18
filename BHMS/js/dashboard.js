document.getElementById('new-rent-type').addEventListener('change', function () {
    const selectedValue = this.value;

    if (selectedValue) {
        const [occTypeID, occRate] = selectedValue.split('|');

        const inputOccTypeID = document.getElementById('new-rent-occ-typeID');
        inputOccTypeID.value = occTypeID;
        
        // Example: Update elements based on occTypeID and occRate
        const viewOccupancyRate = document.getElementById('new-rent-rate');
        const actualOccupancyRate = document.getElementById('actual-new-rent-rate');
        
        viewOccupancyRate.value = occRate;
        actualOccupancyRate.value = occRate;

        if (inputOccTypeID.value == 6) {
            // Show the share tenant input
            document.getElementById('shared-tenant').style.display = 'block';
        } else {
            // Hide the share tenant input
            document.getElementById('shared-tenant').style.display = 'none';
        }

        
    }
});

// End Date Setter for Add New Rent
document.getElementById('new-rent-start').addEventListener('change', function() {
    const startDate = new Date(this.value);

    if(!isNaN(startDate.getTime())) {
        const endDate = new Date(startDate);
        endDate.setDate(endDate.getDate() + 30);

        const endDateString = endDate.toISOString().split('T')[0];
        document.getElementById('new-rent-end').value = endDateString;
    } else {
        alert("Invalid start date");
    }
});

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



