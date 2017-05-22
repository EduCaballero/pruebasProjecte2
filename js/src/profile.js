$(document).ready(function () {
    $('input[type="file"').change(function () {
        $('.img-caption-name').html($('input[type="file"').val());
    });
});