function enableModal(id) {
    resetErrors();
    $('body').addClass('has-active-modal');
    $(id).css('display', 'block');

    $(id + ' .close-modal').click(function () {
        disableModal(id);
    });

    $('<div class="modal-background"></div>').appendTo('body');
    // si creo el background con la clase 'in' 
    // no hace la transicion de opacidad
    setTimeout(function () { $('.modal-background').addClass('in'); }, 10);
    // si clico fuera del modal, se cierra
    $(id).click(function (e) {
        if (e.target === $(id).get(0))
            disableModal(id);
    });
}

function disableModal(id) {
    $(id).hide();
    setTimeout(function () { $('.modal-background').removeClass('in'); }, 100);
    setTimeout(function () {
        $('.modal-background').remove();
        $('body').removeClass('has-active-modal');
        $('.modal, .modal-container, .modal-content , .close-modal').off();
    }, 400);
}

function resetErrors() {
    $('input, select').removeClass('inputError');
    $('span.error').remove();
}