$(document).ready(function () {
    $('.dropdown').hover(
            function () {
                $(this).children('.dropdown-sub').slideDown(200);
            },
            function () {
                $(this).children('.dropdown-sub').stop();
                $(this).children('.dropdown-sub').slideUp(0);
            });

    $('#signin').click(function () {
        enableModal('#login-modal');
    });

    $('#login-form input[type="submit"]').click(function () {
        resetErrors();
        data = {};
        data["email"] = $('#login-form input[type="email"]').val();
        data["password"] = $('#login-form input[type="password"]').val();
        data["validation"] = true;
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'process-login.php',
            data: data,
            success: function (resp) {
                if (resp === true) {
                    $('#login-form').submit();
                    return false;
                } else {
                    $.each(resp, function (k, v) {
                        console.log(k + " => " + v);
                        var error_msg = '<span class="error">' + v + '</span>';
                        $('#login-form input[name="' + k + '"]').after(error_msg);
                        return false;
                    });
                    var keys = Object.keys(resp);
                    $('#login-form input[name="' + keys[0] + '"]').focus();
                }
            },
            error: function () {
                console.log('Algo ha petado');
            }
        });
        return false;
    });
});