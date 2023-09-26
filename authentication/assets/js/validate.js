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
        console.log("EYE CLICK")
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

    miniCheckElement = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
    </svg>`

    checkElement = `<span data-input-state="success" class="absolute top-0 right-0 px-3 h-full grid place-items-center">
    <img id="check-icon" src="assets/check.svg" alt="check" class="w-5 h-5">
    </span>`

    miniCautionElement = `<span data-input-state="error"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-red-600 w-3 h-3">
    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
    </svg></span>`;

    cautionElement = `<span data-input-state="error" class="absolute top-0 right-0 px-3 h-full grid place-items-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-red-600 w-5 h-5">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
    </svg></span>`;

    let hasError = false;

    signInForm.on("submit", function (e) {

        inputFields.removeClass(errorInputClass).addClass(successInputClass);
        inputLabels.removeClass(errorLabelClass).addClass(successLabelClass);
        inputFields.siblings('span[data-input-state="error"]').remove();
        $('span[data-input-state="normal"]').hide();
        inputFields.parent().append(checkElement)

        inputValidateFeedback.html(`<span style="display: inline-flex; align-items: center; justify-content: center; color: #16a34a;">${miniCheckElement} <p style="margin: 2.5px; color: #16a34a;">Success!</p><span>`);

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
                    signInForm.addClass('shake');

                    $('span[data-input-state="normal"]').hide();
                    console.log("EYE REMOVED")
                    inputElement.siblings('span[data-input-state="success"]').remove();
                    inputElement.parent().append(cautionElement)
                    inputElement.removeClass(normalInputClass);
                    inputElement.addClass(errorInputClass);

                    labelElement.removeClass(normalLabelClass);
                    labelElement.addClass(errorLabelClass);

                    setTimeout(function () {
                        signInForm.removeClass('shake');
                    }, 1000)
                }

                if (errorMessage.length > 1) {
                    const errorHTML = errorMessage.map(message => `<div style="display: inline-flex; align-items: center; justify-content: center">${miniCautionElement} <p style="margin: 2.5px;">${message}</p></div>`).join("<br>");
                    $(`p[data-validate-input="${fieldName}"]`).html(errorHTML);
                } else {
                    $(`p[data-validate-input="${fieldName}"]`).css({ display: "inline-flex", "align-items": "center", "justify-content": "center" })
                    $(`p[data-validate-input="${fieldName}"]`).html(`${miniCautionElement} <p style="margin: 2.5px;">${errorMessage[0]}</p>`);
                }
            });
        } else {
            $('body').addClass('scale-out-center')
            setTimeout(function () {
                $('body').removeClass('scale-out-center');
                $('body').addClass('hidden bg-black');
                window.location.href = "https://www.youtube.com";
            }, 500)

            console.log("Form is valid, submitting...");
            

        }

    });



    inputFields.on("input", function () {
        hasError = false;
        $(this).removeClass(errorInputClass).removeClass(successInputClass).addClass(normalInputClass);
        $(this).siblings('label').removeClass(errorLabelClass).removeClass(successLabelClass).addClass(normalLabelClass);
        $(this).parent().next().empty()
        $(this).siblings('span[data-input-state="error"]').remove();
        $(this).siblings('span[data-input-state="success"]').remove();
        if (!$('span[data-input-state="normal"]').is(':visible')) {
            $('span[data-input-state="normal"]').show();
        }
    });


});