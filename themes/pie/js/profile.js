let menus = $('.profile-content-menu');

function updateMenus() {
    menus.each(function () {
        let active = (this.dataset.active === 'true');
        if(!active) {
            $(this).hide();
        }else {
            console.log($(this))
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