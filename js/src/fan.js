$(document).ready(function () {
    $('#vote-concert .enabled').click(voteConcert);
    $('#vote-music .enabled').click(voteMusic);
});

function voteConcert() {
    var id = $(this).closest('tr').children('input').val();
    // Por que demonios el else del php no funciona con true/false?!
    // Compruebo si es un voto a favor o en contra mirando si el boton
    // tiene la clase de pulgar arriba, 1 = si, 0 = no
    var vote = $(this).hasClass('fa-thumbs-o-up') ? 1 : 0;
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "vote-concert.php",
        data: {concertId: id, vote: vote},
        success: function (resp) {
            $('#vote-concert tbody').html(resp);
            $('#vote-concert .enabled').click(voteConcert);
        },
        error: function () {
            console.log('Algo ha petado');
        }
    });
}

function voteMusic() {
    var id = $(this).closest('tr').children('input').val();
    var vote = $(this).hasClass('fa-thumbs-o-up') ? 1 : 0;
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "vote-music.php",
        data: {musicId: id, vote: vote},
        success: function (resp) {
            $('#vote-music tbody').html(resp);
            $('#vote-music .enabled').click(voteMusic);
        },
        error: function () {
            console.log('Algo ha petado');
        }
    });
}