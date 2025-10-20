document.addEventListener('DOMContentLoaded', () => {
    const switcher = document.getElementById('themeSwitch');
    const themeStylesheet = document.createElement('link');
    themeStylesheet.id = 'themeStylesheet';
    themeStylesheet.rel = 'stylesheet';
    document.head.appendChild(themeStylesheet);

    function setTheme(theme) {
        if (theme === 'dark') {
            themeStylesheet.href = '../assets/dark_theme.css'; 
            localStorage.setItem('theme', 'dark');
            if (switcher) switcher.checked = true;
        } else {
            themeStylesheet.href = ''; 
            localStorage.setItem('theme', 'light');
            if (switcher) switcher.checked = false;
        }
    }

    
    setTheme(localStorage.getItem('theme') || 'light');

    
    if (switcher) {
        switcher.addEventListener('change', () => {
            setTheme(switcher.checked ? 'dark' : 'light');
        });
    }
});
