console.log('Script loaded');

const menuIcon = document.getElementById('menuIcon');
const sideMenu = document.querySelector('.side-menu');
const menuOverlay = document.querySelector('.menu-overlay');
const menuLinks = document.querySelectorAll('.menu-list li a');

function toggleMenu() {
    menuIcon.classList.toggle('active');
    sideMenu.classList.toggle('open');
    menuOverlay.classList.toggle('active');
}

menuIcon.addEventListener('click', toggleMenu);
menuOverlay.addEventListener('click', toggleMenu);

menuLinks.forEach(link => {
    link.addEventListener('click', toggleMenu);
});