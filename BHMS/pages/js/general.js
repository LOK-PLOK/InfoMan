/*---------------Sidebar---------------*/
const hamMenu = document.querySelector('.hamburger-sidebar');
const offScreenMenu = document.querySelector('.off-screen-menu');
const contentPage = document.querySelector('.container-fluid');

hamMenu.addEventListener('click', () => { // Sidebar Toggle Function
    hamMenu.classList.toggle('active');
    offScreenMenu.classList.toggle('active');
    if(contentPage.style.filter === 'brightness(0.2)') { // Blurs the background when sidebar is toggled
        contentPage.style.filter = '';
    } else {
        contentPage.style.filter = 'brightness(0.2)';
    }
})


/*---------------Room Logs Functions---------------*/
const showAvailRmBtn = document.querySelector('.show-avail-rm-btn');
const roomInfo = document.querySelectorAll('.rm-info-container');
const roomsLength = roomInfo.length;

// Store the initial display state of each room
const initialDisplayStates = Array.from(roomInfo).map(room => room.style.display || '');

// Toggle visibility on button click
showAvailRmBtn.addEventListener('click', () => {
    let allVisible = true;

    for(let i = 0; i < roomsLength; i++){
        const availInfo = roomInfo[i].getElementsByClassName('rm-info-avail')[0];
        if(availInfo && availInfo.textContent === 'Not Available'){
            if(roomInfo[i].style.display === 'none'){
                roomInfo[i].style.display = initialDisplayStates[i];
            } else {
                roomInfo[i].style.display = 'none';
                allVisible = false;
            }
        }
    }

    if(allVisible) {
        showAvailRmBtn.textContent = 'Show Available Rooms';
    } else {
        showAvailRmBtn.textContent = 'Show All Rooms';
    }
});