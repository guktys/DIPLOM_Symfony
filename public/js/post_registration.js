$(document).ready(function() {
    $('form').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            success: function(response) {
                console.log(response.message);
                $('.alert-success').css('display', 'block');
                $('.alert-success').text(response.message);
            },
            error: function(xhr, status, error) {
                console.log(response.message);
                $('.alert-danger').css('display', 'block');
                $('.alert-danger').text(response.message);
            }
        });
    });
});