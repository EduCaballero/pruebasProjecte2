$(document).ready(function () {
    $("#overlay").click(function () {
        $("body").removeClass("has-active-menu");
    });
    $(".mobile-menu-button").click(function () {
        $("body").addClass("has-active-menu");
    });
});
