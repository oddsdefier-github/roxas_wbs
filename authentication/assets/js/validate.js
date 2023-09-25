$(document).ready(function () {
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



    const signInForm = $("#form-signin");
    const emailInput = $("#email");
    const passInput = $("#password");
    const validationRules = {
        email: {
            email: {
                message: "is invalid",
            },
            presence: {
                allowEmpty: false,
                message: "cannot be empty",
            },

        },
        password: {
            presence: {
                allowEmpty: false,
                message: "cannot be empty",
            },
            length: {
                minimum: 8,
                tooShort: "should be at least %{count} characters or more"
            }
        },
    };


    const inputFields = $('.validate-input');
    const inputLabels = inputFields.siblings('label');
    const inputValidateFeedback = $(".input-group p");


    normalLabelClass = 'absolute text-sm text-gray-600 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1';
    errorLabelClass = 'absolute text-sm text-red-600 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1';
    successLabelClass = 'absolute text-sm text-green-600 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1';


    normalInputClass = 'block px-2.5 py-3 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-indigo-600 peer';
    errorInputClass = 'block px-2.5 py-3 w-full text-sm text-red-800 bg-transparent rounded-lg border-1 border-red-500 appearance-none  focus:outline-none focus:ring-0 focus:border-indigo-600 peer';
    successInputClass = 'block px-2.5 py-3 w-full text-sm text-green-800 bg-transparent rounded-lg border-1 border-green-500 appearance-none focus:outline-none focus:ring-0 focus:border-indigo-600 peer';

    checkElement = `<span class="absolute top-0 right-0 px-3 h-full grid place-items-center">
    <img id="check-icon" src="assets/check.svg" alt="check" class="w-5 h-5">
    </span>`
    let hasError = false;

    signInForm.on("submit", function (e) {
        inputFields.removeClass(errorInputClass).addClass(successInputClass);
        inputLabels.removeClass(errorLabelClass).addClass(successLabelClass);
        inputValidateFeedback.empty()

        inputFields.parent().append(checkElement)

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
                const labelElement = inputElement.siblings('label');
                hasError = true;
                if (hasError) {

                    inputElement.siblings('span').remove()

                    signInForm.addClass('shake');

                    inputElement.removeClass(normalInputClass);
                    console.log()
                    inputElement.addClass(errorInputClass);
                    console.log(`${inputElement.attr('type')} input element has error class`);


                    labelElement.removeClass(normalLabelClass);
                    labelElement.addClass(errorLabelClass)
                    console.log("label element has error class")

                    setTimeout(function () {
                        signInForm.removeClass('shake');
                    }, 1000)
                }
                if (errorMessage.length > 1) {
                    const errorHTML = errorMessage.join("<br>");
                    $(`p[data-validate-input="${fieldName}"]`).html(errorHTML);
                } else {
                    $(`p[data-validate-input="${fieldName}"]`).text(errorMessage[0]);
                }

            });
        } else {
            // $('body').addClass('scale-out-center')
            // setTimeout(function () {
            //     $('body').removeClass('scale-out-center');
            //     $('body').addClass('hidden bg-black');
            //     window.location.href = "https://www.youtube.com";
            // }, 500)

            console.log("Form is valid, submitting...");
        }

    });


    inputFields.on("input", function () {
        hasError = false;
        $(this).removeClass(errorInputClass).removeClass(successInputClass).addClass(normalInputClass);
        $(this).siblings('label').removeClass(errorLabelClass).removeClass(successLabelClass).addClass(normalLabelClass);
        $(this).parent().next().empty()
    });


});