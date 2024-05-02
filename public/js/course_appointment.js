$('#appointment_form').submit(function (event) {
    event.preventDefault();
    var formData = $(this).serialize();
    console.log(formData);
    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: formData,
        success: function (response) {
            $('.alert-success').css('display', 'block');
            $('.alert-success').text('Ви успішно зареєстровані!');
            setTimeout(function () {
                window.history.back();
            }, 1000);
        },
        error: function (xhr, status, error) {
            $('.alert-danger').css('display', 'block');
            $('.alert-danger').text('Помилка, спробуйте будь ласка знову пізніше!');
        }
    });
})
;