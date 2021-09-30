let button = document.querySelector('#hamburger-button');
let overlay_burger = document.querySelector('#hamburger-overlay');
let site_header = document.querySelector('#site-header');
let activatedClass = 'hamburger-activated';

button.addEventListener('click', function(e) {
    e.preventDefault();
    site_header.classList.add(activatedClass);
});

button.addEventListener('keydown', function (e) {
    if(site_header.classList.contains(activatedClass)) {
        if(e.repeat === false && e.which === 27) {
            site_header.classList.remove(activatedClass)
        }
    }
});

overlay_burger.addEventListener('click', function (e) {
    e.preventDefault();
    site_header.classList.remove(activatedClass);
});
