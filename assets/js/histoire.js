import '../css/histoire.scss';

$(document).ready(function () {

    // Check for click events on the navbar burger icon
    $("div#histoireLocaleNav").click(function () {

        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
        $("div#histoireLocaleNav").toggleClass("is-active");
        $("div#navMenuRaccourcis").toggleClass("is-active");

    });

    $("span#closeNavMenuRaccourcis").click(function () {

        $("div#histoireLocaleNav").toggleClass("is-active");
        $("div#navMenuRaccourcis").toggleClass("is-active");
    })
});