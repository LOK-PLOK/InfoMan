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