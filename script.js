const mobileMenu = document.getElementById('mobile-menu');
const navbarMenu = document.getElementById('navbar-menu');
const profileIcon = document.getElementById('profile-icon');
const dropdownMenu = document.getElementById('dropdown-menu');

mobileMenu.addEventListener('click', () => {
    navbarMenu.classList.toggle('active');
});

profileIcon.addEventListener('click', () => {
    dropdownMenu.classList.toggle('show');
});

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
    if (!event.target.matches('#profile-icon')) {
        if (dropdownMenu.classList.contains('show')) {
            dropdownMenu.classList.remove('show');
        }
    }
};
