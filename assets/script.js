document.addEventListener('DOMContentLoaded', () => {
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            navLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
        });
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (!href || href === '#') return;
            const target = document.querySelector(href);
            if (!target) return;
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth' });
        });
    });

    const profileIcon = document.querySelector('.profile-icon');
    const profileMenu = document.querySelector('.profile-menu');
    const profileOverlay = document.querySelector('.profile-menu-overlay');
    const menuProfileLinks = document.querySelectorAll('.profile-list li a');

    function openMenu() {
        profileIcon?.classList.add('active');
        profileMenu?.classList.add('open');
        profileOverlay?.classList.add('active');
    }
    function closeMenu() {
        profileIcon?.classList.remove('active');
        profileIcon?.setAttribute('aria-expanded', 'false');
        profileMenu?.classList.remove('open');
        profileOverlay?.classList.remove('active');
    }
    function toggleMenu() {
        if (profileMenu?.classList.contains('open')) closeMenu(); else openMenu();
    }

    if (profileIcon) {
        profileIcon.addEventListener('click', toggleMenu);
        profileIcon.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); toggleMenu(); }
        });
    }
    if (profileOverlay) profileOverlay.addEventListener('click', closeMenu);

    document.addEventListener('click', (e) => {
        if (!profileMenu || !profileIcon) return;
        if (!profileMenu.classList.contains('open')) return;
        if (profileMenu.contains(e.target) || profileIcon.contains(e.target)) return;
        closeMenu();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeMenu();
    });

    menuProfileLinks.forEach(l => l.addEventListener('click', closeMenu));

    window.addEventListener('scroll', () => {
        const sections = document.querySelectorAll('section[id]');
        const scrollPos = window.scrollY + 100;

        sections.forEach(section => {
            const id = section.getAttribute('id');
            const link = document.querySelector(`.nav-link[href="#${id}"]`);

            if (
                section.offsetTop <= scrollPos &&
                section.offsetTop + section.offsetHeight > scrollPos
            ) {
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                if (link) link.classList.add('active');
            }
        });
    });
});



const dateInput = document.getElementById('booking-date');
const today = new Date().toISOString().split('T')[0];
dateInput.setAttribute('min', today);

const serviceOptions = document.querySelectorAll('.service-option');

serviceOptions.forEach(option => {
    option.addEventListener('click', function () {
        serviceOptions.forEach(opt => opt.classList.remove('selected'));

        this.classList.add('selected');

        const radio = this.querySelector('input[type="radio"]');
        radio.checked = true;
    });
});