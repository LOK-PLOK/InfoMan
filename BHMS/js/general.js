function showSuccessAlert(message) {
    Swal.fire({
        position: 'bottom-end',
        icon: 'success',
        title: message,
        showConfirmButton: false,
        timer: 3000,
        toast: true,
        showCloseButton: true,
        customClass: {
            popup: 'custom-toast', // Apply custom toast styling
            title: 'alert-success',
            closeButton: 'alert-close-button'
        }
    });
}

function showFailAlert(message) {
    Swal.fire({
        position: 'bottom-end',
        icon: 'error',
        title: message,
        showConfirmButton: false,
        timer: 3000,
        toast: true,
        showCloseButton: true,
        customClass: {
            popup: 'custom-toast',
            title: 'alert-error',
            closeButton: 'alert-close-button'
        }
    });
}

function showWarningAlert(message) {
    Swal.fire({
        position: 'bottom-end',
        icon: message,
        title: 'This is a warning alert!',
        showConfirmButton: false,
        timer: 3000,
        toast: true,
        showCloseButton: true,
        customClass: {
            popup: 'custom-toast',
            title: 'alert-warning',
            closeButton: 'alert-close-button'
        }
    });
}

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

