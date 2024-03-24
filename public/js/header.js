const element = document.querySelector('#header');
const menuItems = document.querySelectorAll('#main_menu .nav-link');
function getCurrentColor(element) {
    return window.getComputedStyle(element).getPropertyValue('color');
}

const initialColor = getCurrentColor(menuItems[0]);

window.addEventListener('scroll', () => {
    const scrollPosition = window.scrollY;

    if (scrollPosition > 10) {
        element.style.position = 'fixed'
        element.style.backgroundColor = '#fff';
        element.style.height = '110px';
        element.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)';

        menuItems.forEach(item => {
            item.style.color = '#B69256';
        });
    } else {
        element.style.position = 'relative'
        element.style.boxShadow = 'none';
        element.style.backgroundColor = 'rgba(255,255,255,0)';

        menuItems.forEach(item => {
            item.style.color = initialColor;
        });
    }
});
