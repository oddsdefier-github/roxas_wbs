(function () {
    "user strict";
    let eyeIcon = $("#eye-icon")

    eyeIcon.on("click", function () {
        if (passInput.attr("type") === "password") {
            passInput.attr("type", "text");
            eyeIcon.attr("src", "assets/eye-open.svg");
        } else {
            passInput.attr("type", "password");
            eyeIcon.attr("src", "assets/eye-close.svg");
        }
    });



    const applicationForm = $("#form-signin");
    const emailInput = $("#email");
    const passInput = $("#password");
    const validationRules = {
        email: {
            presence: {
                allowEmpty: false,
                message: "cannot be empty",
            },
            email: {
                message: "is invalid",
            },
        },
        password: {
            presence: {
                allowEmpty: false,
                message: "cannot be empty",
            },
            length: {
                minimum: 5,
                tooShort: "should be at least %{count} characters or more"
            }
        },
    };
    $(".validate-feedback").hide()


    normalInputClass = 'border-gray-300';
    errorInputClass = 'border-red-300';
    successInputClass = 'border-green-300';

    let hasError = false;

    applicationForm.on("submit", function (e) {
        $('.validate-input').removeClass(errorInputClass).addClass(successInputClass);
        $(".input-group p").empty()

        e.preventDefault();

        const formData = {
            email: emailInput.val().trim(),
            password: passInput.val().trim(),
        }

        const validateInput = validate(formData, validationRules);

        if (validateInput) {
            console.log(validateInput)
            $.each(validateInput, function (fieldName, errorMessage) {

                const inputElement = $(`p[data-validate-input="${fieldName}"]`).prev('div').find('input');
                hasError = true;
                if (hasError) {
                    inputElement.removeClass(normalInputClass);
                    inputElement.removeClass(successInputClass);
                    inputElement.addClass(errorInputClass);

                }
                if (errorMessage.length > 1) {
                    const errorHTML = errorMessage.join("<br>");
                    $(`p[data-validate-input="${fieldName}"]`).html(errorHTML);
                } else {
                    $(`p[data-validate-input="${fieldName}"]`).text(errorMessage[0]);
                }
            });
        } else {
            console.log("Form is valid, submitting...");
        }

    });



}());