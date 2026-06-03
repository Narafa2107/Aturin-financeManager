import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');
    const main = document.querySelector('.main-content');

    if (toggle && sidebar && main) {
        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('expanded');

            if (sidebar.classList.contains('expanded')) {
                main.style.marginLeft = '240px';
            } else {
                main.style.marginLeft = '90px';
            }
        });
    }
});