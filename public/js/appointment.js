checkJQuery();

function checkJQuery() {
    $('input[name="time"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        timePicker: true, // Включает выбор времени
        timePicker24Hour: true, // Используйте 24-часовой формат времени
        timePickerIncrement: 5, // Интервал в минутах для выбора времени
        minYear: 2024,
        maxYear: parseInt(moment().format('YYYY'), 10),
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
    document.getElementById("service").addEventListener("change", function () {
        displayNoneCostBlock();
        let totalSuma = 0;
        let selectedServiceId = this.value;
        let selectedServiceClass = this.options[this.selectedIndex].className;
        let cost = this.options[this.selectedIndex].getAttribute('cost');
        let costBlock = document.getElementById("const_container_" + selectedServiceClass);
        let consumable_items_costs = document.querySelectorAll("#const_container_" + selectedServiceClass + " .cost");
        consumable_items_costs.forEach(function (element) {
            let textContent = element.textContent.trim().split(" ");
            let price = textContent[0];
            totalSuma = totalSuma + Number(price);
        });
        totalSuma = totalSuma + Number(cost);
        let priceBlock = document.querySelector("#const_container_" + selectedServiceClass + ' .service_price');

        priceBlock.innerHTML = "<div class=\"row\">\n" +
            " <div class=\"col text-start\">Послуга</div>\n" +
            " <div class=\"col text-end cost\"> " + cost + " грн</div>\n" +
            " </div>";
        let costTotalSumaElement = document.querySelector("#const_container_" + selectedServiceClass + ' .total_suma');
        costTotalSumaElement.innerHTML = totalSuma+" грн";
        costBlock.style.display = "block";
    });

    function displayNoneCostBlock() {
        let costBlocks = document.querySelectorAll(".const_container");
        if (costBlocks) {
            costBlocks.forEach(function (element) {
                element.style.display = "none";
            });
        }
    }

    $('#appointment_form').submit(function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
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
    });

}
