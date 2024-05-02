checkJQuery();
function checkJQuery() {
    $('input[name="time"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        timePicker: true, // Включает выбор времени
        timePicker24Hour: true, // Используйте 24-часовой формат времени
        timePickerIncrement: 5, // Интервал в минутах для выбора времени
        minYear: 2024,
        maxYear: parseInt(moment().format('YYYY'),10),
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(32, 'hour'),
        locale: {
            format: 'DD.MM.YYYY HH:mm',
            applyLabel: "Прийняти",
            cancelLabel: "Відміна",
            fromLabel: "Від",
            toLabel: "До",
            customRangeLabel: "Вибрати",
            daysOfWeek: ["Нд", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
            monthNames: [
                "Січень", "Лютий", "Березень", "Квітень", "Травень", "Червень", "Липень",
                "Серпень", "Вересень", "Жовтень", "Листопад", "Грудень"
            ],
            firstDay: 1
        }
    });

    $('#appointment_form').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            success: function(response) {
                $('.alert-success').css('display', 'block');
                $('.alert-success').text('Ви успішно зареєстровані!');
                setTimeout(function () {
                    window.history.back();
                }, 1000);
            },
            error: function(xhr, status, error) {
                $('.alert-danger').css('display', 'block');
                $('.alert-danger').text('Помилка, спробуйте будь ласка знову пізніше!');
            }
        });
    });

}
