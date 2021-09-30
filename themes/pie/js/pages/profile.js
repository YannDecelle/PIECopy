let menus = $('.profile-content-menu');

function updateMenus() {
    menus.each(function () {
        let active = (this.dataset.active === 'true');
        if(!active) {
            $(this).hide();
        }else {
            $(this).show();
        }
    })
}

updateMenus();

let btns = $('.profile-content-nav-btn');

btns.click(function () {
    btns.each(function () {
        $(this).removeClass('active');
    })
    $(this).addClass('active');
    appearMenu(this.dataset.action);
})

function appearMenu(type) {
    let menu = document.querySelectorAll("[data-type='"+type+"']");
    menus.each(function () {
        this.dataset.active = 'false';
    })
    menu[0].dataset.active = 'true';
    updateMenus();
}

//POPUP
let overlay = $('#overlay')
let editor = $('#profile-editor')
let close_btn = $('#profile-editor-close')
let open_btn = $('#profile-editor-open')

function togglePopup(value) {
    if(value) {
        jQuery('html, body').animate({scrollTop: 0}, 0);
        overlay.show();
        editor.show();
    }else {
        overlay.hide();
        editor.hide();
    }
}
togglePopup(false);

overlay.click(function () {
    togglePopup(false);
})
close_btn.click(function () {
    togglePopup(false);
})
open_btn.click(function () {
    togglePopup(true);
})