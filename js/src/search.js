$(document).ready(function () {
    $('.dropdown').hover(
            function () {
                $(this).children('.dropdown-sub').slideDown(200);
            },
            function () {
                $(this).children('.dropdown-sub').stop();
                $(this).children('.dropdown-sub').slideUp(0);
            });
            
    $("#show-more-gen").click(function () {
        $("#rest-gen").slideToggle();
        $("#show-more-gen").hide();
        $("#show-less-gen").show();
    });
    $("#show-less-gen").click(function () {
        $("#rest-gen").slideToggle();
        $("#show-less-gen").hide();
        $("#show-more-gen").show();
    })
    $("#show-more-prov").click(function () {
        $("#rest-prov").slideToggle();
        $("#show-more-prov").hide();
        $("#show-less-prov").show();
    });
    $("#show-less-prov").click(function () {
        $("#rest-prov").slideToggle();
        $("#show-less-prov").hide();
        $("#show-more-prov").show();
    })
});
