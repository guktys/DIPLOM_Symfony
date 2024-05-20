$(document).ready(function () {
    $('.contact.form').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (response) {
                $('.alert-success').css('display', 'block');
                $('.alert-success').text('Ви успішно надіслали листа!');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            },
            error: function (xhr, status, error) {
                $('.alert-danger').css('display', 'block');
                $('.alert-danger').text('Помилка, спробуйте будь ласка знову пізніше!');
            }
        });
    });
});