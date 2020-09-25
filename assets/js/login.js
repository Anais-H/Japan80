import '../css/login.scss';

$(document).ready(function () {
    $(".toggle-password").click(function () {
        console.log('hey');

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#inputPassword");

        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
});

