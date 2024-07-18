function setValuesTenantInfo(occupancyID, name, roomID, rentTypeID, rentType, occDateStart, occDateEnd, rentRate) {

    rentRate = parseFloat(rentRate).toFixed(2);

    document.getElementById('edit-occupancy-id').value = occupancyID;    
    document.getElementById('edit-rent-tenant-name').value = name;
    document.getElementById('edit-rent-room').value = roomID;
    document.getElementById('edit-rent-type').value = rentTypeID;
    document.getElementById('edit-rent-type-name').value = rentType;
    document.getElementById('edit-rent-start').value = occDateStart;
    document.getElementById('edit-rent-end').value = occDateEnd;
    document.getElementById('edit-rent-rate').value = rentRate;
}

function setValuesEditRoom(roomID, roomCapacity) {
    document.getElementById('edit-rm-code').value = roomID;
    document.getElementById('edit-rm-code-hidden').value = roomID;
    document.getElementById('edit-rm-cap').value = roomCapacity;
}

function delRoomID(roomID){
    document.getElementById('delete-room-id').value = roomID;
}


document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.editOccupancyBtn').forEach(button => {
        button.addEventListener('click', function() {
            const editOccInfo = this.value;
        });
    });

    // Looks for the button with the class 'deleteOccupancyBtn' and sets the value of the delete-occupancy-id input field
    document.querySelectorAll('.deleteOccupancyBtn').forEach(button => {
        button.addEventListener('click', function() {
            const delOccInfo = this.value;
            document.getElementById('delete-occupancy-id').value = delOccInfo;
        });
    });

    document.querySelectorAll('.deactOccupancyBtn').forEach(button => {
        button.addEventListener('click', function() {
            const deactOccInfo = this.value;
            document.getElementById('deact-occupancy-id').value = deactOccInfo;
            console.log(document.getElementById('deact-occupancy-id').value);
        });
    });

    const showAvailRmBtn = document.querySelector('.show-avail-rm-btn');
    const roomInfo = document.querySelectorAll('.rm-info-container');

    // Store the initial display state of each room
    const initialDisplayStates = Array.from(roomInfo).map(room => window.getComputedStyle(room).display);

    // Toggle visibility on button click
    showAvailRmBtn.addEventListener('click', () => {
        let visibleRoomsCount = roomInfo.length;

        roomInfo.forEach((room, index) => {
            const availInfo = room.getElementsByClassName('rm-info-avail')[0];
            if (availInfo && availInfo.textContent === 'Not Available') {
                if (room.style.display === 'none') {
                    room.style.display = initialDisplayStates[index]; // Restore initial state
                } else {
                    room.style.display = 'none';
                    visibleRoomsCount--; // Decrement count as room is made invisible
                }
            }
        });

        // Update button text based on the count of visible rooms
        showAvailRmBtn.textContent = visibleRoomsCount === roomInfo.length ? 
            'Show Available Rooms' : 'Show All Rooms';
    });

    // End Date Setter for Edit Rent
	document.getElementById('edit-rent-start').addEventListener('change', function() {
		const startDate = new Date(this.value);

		if(!isNaN(startDate.getTime())) {
			const endDate = new Date(startDate);
			endDate.setDate(endDate.getDate() + 30);

			const endDateString = endDate.toISOString().split('T')[0];
			document.getElementById('edit-rent-end').value = endDateString;
		} else {
			alert('Invalid start date');
		}
	});


    const addRoomInput = document.getElementById('add-new-rm-code');

    // Convert input to uppercase and limit to 6 characters
    addRoomInput.addEventListener('input', () => {
        addRoomInput.value = addRoomInput.value.toUpperCase().slice(0, 6);
    });


});


