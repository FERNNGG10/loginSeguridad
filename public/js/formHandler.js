/**
 * Disables a button when a form is submitted and re-enables it after a delay.
 * @param {string} formId - The ID of the form.
 * @param {string} buttonId - The ID of the button to disable.
 * @param {string} [processingText='Processing...'] - The text to display on the button while processing.
 * @param {string} [defaultText='Submit'] - The default text to display on the button.
 */
function disableButtonOnSubmit(formId, buttonId, processingText = 'Processing...', defaultText = 'Submit') {
    document.getElementById(formId).addEventListener('submit', function(event) {
        var button = document.getElementById(buttonId);
        button.disabled = true;
        button.innerHTML = processingText;

        setTimeout(function() {
            button.disabled = false;
            button.innerHTML = defaultText;
        }, 5000);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const FORM = document.getElementById('registerForm');
    if (FORM) {
        const NAME_INPUT = document.getElementById('name');
        const EMAIL_INPUT = document.getElementById('email');
        const PASSWORD_INPUT = document.getElementById('password');
        const PASSWORD_CONFIRMATION_INPUT = document.getElementById('password_confirmation');
        const RECAPTCHA_RESPONSE = document.querySelector('.g-recaptcha-response');

        const NAME_ERROR = document.getElementById('nameError');
        const EMAIL_ERROR = document.getElementById('emailError');
        const PASSWORD_ERROR = document.getElementById('passwordError');
        const PASSWORD_CONFIRMATION_ERROR = document.getElementById('passwordConfirmationError');
        const RECAPTCHA_ERROR = document.getElementById('recaptchaError');

        /**
         * Validates the name input field.
         */
        NAME_INPUT.addEventListener('input', function () {
            const NAME_REGEX = /^[a-zA-Z0-9\s]+$/;
            if (!NAME_REGEX.test(NAME_INPUT.value)) {
                NAME_ERROR.textContent = 'Name can only contain letters, numbers, and spaces.';
            } else {
                NAME_ERROR.textContent = '';
            }
        });

        /**
         * Validates the email input field.
         */
        EMAIL_INPUT.addEventListener('input', function () {
            const EMAIL_REGEX = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!EMAIL_REGEX.test(EMAIL_INPUT.value)) {
                EMAIL_ERROR.textContent = 'Please enter a valid email address.';
            } else {
                EMAIL_ERROR.textContent = '';
            }
        });

        /**
         * Validates the password input field.
         */
        PASSWORD_INPUT.addEventListener('input', function () {
            const PASSWORD_REGEX = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;
            if (!PASSWORD_REGEX.test(PASSWORD_INPUT.value)) {
                PASSWORD_ERROR.textContent = 'Password must be 8 characters, contain at least one uppercase letter, one number, and one special character.';
            } else {
                PASSWORD_ERROR.textContent = '';
            }
        });

        /**
         * Validates the password confirmation input field.
         */
        PASSWORD_CONFIRMATION_INPUT.addEventListener('input', function () {
            if (PASSWORD_INPUT.value !== PASSWORD_CONFIRMATION_INPUT.value) {
                PASSWORD_CONFIRMATION_ERROR.textContent = 'Passwords do not match.';
            } else {
                PASSWORD_CONFIRMATION_ERROR.textContent = '';
            }
        });

        /**
         * Validates the form on submit.
         * @param {Event} event - The submit event.
         */
        FORM.addEventListener('submit', function (event) {
            let isValid = true;

            if (NAME_ERROR.textContent || EMAIL_ERROR.textContent || PASSWORD_ERROR.textContent || PASSWORD_CONFIRMATION_ERROR.textContent) {
                isValid = false;
            }

            if (RECAPTCHA_RESPONSE && RECAPTCHA_RESPONSE.value === '') {
                RECAPTCHA_ERROR.textContent = 'Please complete the ReCaptcha.';
                isValid = false;
            } else {
                RECAPTCHA_ERROR.textContent = '';
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const FORM = document.getElementById('2faForm');
    if (FORM) {
        const CODE_INPUT = document.getElementById('code');
        const CODE_ERROR = document.getElementById('codeError');

        /**
         * Validates the 2FA code input field.
         */
        CODE_INPUT.addEventListener('input', function () {
            const CODE_REGEX = /^\d{6}$/;
            if (!CODE_REGEX.test(CODE_INPUT.value)) {
                CODE_ERROR.textContent = 'Code must be a 6-digit number.';
            } else {
                CODE_ERROR.textContent = '';
            }
        });

        /**
         * Validates the 2FA form on submit.
         * @param {Event} event - The submit event.
         */
        FORM.addEventListener('submit', function (event) {
            if (CODE_ERROR.textContent) {
                event.preventDefault();
            }
        });
    }
});