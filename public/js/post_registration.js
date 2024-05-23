$(document).ready(function () {
    const formInputs = document.querySelectorAll('.form-control.register_input');
    const registerButton = document.querySelector('.register_btn');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');

    function validateInput(input, pattern, isOptional = false) {
        const value = input.value.trim();
        const feedbackElement = input.nextElementSibling;
        const isValid = value === '' ? isOptional : pattern.test(value);

        if (isValid) {
            input.classList.remove('is-invalid');
            feedbackElement.style.display = 'none';
        } else {
            input.classList.add('is-invalid');
            feedbackElement.style.display = 'block';
        }
        checkFormValidity();
    }

    function validatePasswordMatch() {
        const feedbackElement = confirmPasswordInput.nextElementSibling;
        if (passwordInput.value === confirmPasswordInput.value) {
            confirmPasswordInput.classList.remove('is-invalid');
            feedbackElement.style.display = 'none';
        } else {
            confirmPasswordInput.classList.add('is-invalid');
            feedbackElement.style.display = 'block';
            feedbackElement.textContent = 'Паролі не співпадають.';
        }
        checkFormValidity();
    }

    function checkFormValidity() {
        const isAnyInvalid = Array.from(formInputs).some(input => input.classList.contains('is-invalid'));
        const isPasswordMismatch = passwordInput.value !== confirmPasswordInput.value;
        registerButton.disabled = isAnyInvalid || isPasswordMismatch;
    }

    formInputs.forEach(input => {
        input.addEventListener('input', function () {
            validateInput(input, getPatternForInput(input), input.id === 'telegram');
            if (input === passwordInput || input === confirmPasswordInput) {
                validatePasswordMatch();
            }
        });
    });

    function getPatternForInput(input) {
        switch (input.id) {
            case 'email':
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            case 'firstname':
            case 'lastname':
                return /^[a-zA-Zа-яА-ЯіїІЇ]+$/;
            case 'phone':
                return /^\+?\d{10,15}$/;
            case 'telegram':
                return /^https?:\/\/t\.me\/[a-zA-Z0-9_]+$/;
            case 'password':
            case 'confirm_password':
                return /.+/;
            default:
                return /.*/;  // Default pattern (matches any input)
        }
    }

    $('form').submit(function (event) {
        event.preventDefault();
        if (registerButton.disabled) {
            alert('Будь ласка, заповніть всі обов\'язкові поля правильно і переконайтеся, що паролі збігаються перед відправкою.');
            return;
        }

        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            success: function (response) {
                $('.alert-success').css('display', 'block');
                $('.alert-success').text('Ви успішно зареєстровані!');
                window.history.back();
            },
            error: function (xhr, status, error) {
                $('.alert-danger').css('display', 'block');
                $('.alert-danger').text('Помилка, спробуйте будь ласка знову пізніше!');
            }
        });
    });
});
