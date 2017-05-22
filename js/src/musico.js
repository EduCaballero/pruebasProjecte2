$(document).ready(function () {
    $('#pending-table .enabled').click(signUpConcert);
});

function signUpConcert() {
    var id = $(this).closest('tr').children('input').val();
    var signup = $(this).hasClass('signup') ? 1 : 0;
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "signup-concert.php",
        data: {concertId: id, signup: signup},
        success: function (resp) {
            $('#pending-table tbody').html(resp);
            $('#pending-table .enabled').click(signUpConcert);
        },
        error: function () {
            console.log('Algo ha petado');
        }
    });
}