let toggle_auth = false;
let menus = $('.auth-block');
let toggle_btn = $('.auth-toggle');

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

function toggleAuth() {
    let toggles =  $("[data-active='"+toggle_auth+"']");
    let not_toggles =  $("[data-active='"+!toggle_auth+"']");
    toggles.each(function () {
        this.dataset.active = !toggle_auth;
    })
    not_toggles.each(function () {
        this.dataset.active = toggle_auth;
    })
    updateMenus();
}

toggle_btn.click(function () {
    toggleAuth();
    toggle_auth = !toggle_auth;
})

//FORGET PASSWORD
let forget_btn = $('#forget-pass');

forget_btn.click(function () {
    let content = document.getElementById("forget-content");
    if (content.style.maxHeight) {
        content.style.maxHeight = null;
    } else {
       content.style.maxHeight = content.scrollHeight + 1 + "px";
    }
})
