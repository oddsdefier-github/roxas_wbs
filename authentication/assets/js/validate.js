$(document).ready(function () {
    const eyeIcon = $("#eye-icon");
    const signInForm = $("#form-signin");
    const emailInput = $("#email");
    const passInput = $("#password");
    const inputFields = $('.validate-input');
    const inputLabels = inputFields.siblings('label');
    const inputValidateFeedback = $(".input-group .validate-message");


    const cssClasses = {
        normalLabelClass: 'absolute text-sm text-gray-600 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1',
        errorLabelClass: 'absolute text-sm text-red-600 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1',
        successLabelClass: 'absolute text-sm text-green-600 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1',
        normalInputClass: 'block px-2.5 py-3 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 appearance-none border-gray-300 focus:outline-none focus:ring-0 focus:border-indigo-600 peer',
        errorInputClass: 'block px-2.5 py-3 w-full text-sm text-red-800 bg-transparent rounded-lg border-1 border-red-500 appearance-none  focus:outline-none focus:ring-0 focus:border-red-600 peer',
        successInputClass: 'block px-2.5 py-3 w-full text-sm text-green-800 bg-transparent rounded-lg border-1 border-green-500 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer'
    }

    const elements = {
        miniCheckElement: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
    </svg>`,

        checkElement: `<span data-input-state="success" class="absolute top-0 right-0 pr-3 h-full grid place-items-center">
    <img id="check-icon" src="assets/check.svg" alt="check" class="w-5 h-5">
    </span>`,

        miniCautionElement: `<span data-input-state="error"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-red-600 w-3 h-3">
    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
    </svg></span>`,

        cautionElement: `<span data-input-state="error" class="absolute top-0 right-0 pr-3 h-full grid place-items-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-red-600 w-5 h-5">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
    </svg></span>`,
    };



    eyeIcon.on("click", function () {
        if (passInput.attr("type") === "password") {
            passInput.attr("type", "text");
            eyeIcon.attr("src", "assets/eye-open.svg");
        } else {
            passInput.attr("type", "password");
            eyeIcon.attr("src", "assets/eye-close.svg");
        }
        console.log("EYE CLICK");
    });


    function signIn() {
        return new Promise((resolve, reject) => {

            let designationSelected = $("#designation-select").find(":selected").text();
            $("#designation-select").on("change", function () {
                designationSelected = $(this).find(":selected").text();
            });

            let emailInputVal = emailInput.val();
            let passInputVal = passInput.val();

            const loader = $(".loader");
            const signInMessage = $("#signin-message");

            $.ajax({
                url: "signin_process.php",
                type: "post",
                data: {
                    emailSend: emailInputVal,
                    passSend: passInputVal,
                    designationSelectedSend: designationSelected
                },
                success: function (response) {
                    var responseData = JSON.parse(response);


                    if (responseData.valid) {

                        signInForm.hide(200)

                        loader.css({
                            'display': 'flex',
                            'flex-direction': 'column',
                            'justify-content': 'center',
                            'align-items': 'center'
                        });

                        loader.show();


                        if (responseData.user_role === "Admin") {
                            setTimeout(function () {
                                loader.hide();
                                window.location.href = "../admin/index.php";
                            }, 1000);
                        } else if (responseData.user_role === "Cashier") {
                            window.location.href = "../cashier/index.php";
                        } else if (responseData.user_role === "Meter Reader") {
                            window.location.href = "../meter_reader/index.php";
                        }

                        resolve(responseData); // Resolve the Promise with response data

                    } else {

                        signInMessage.text(responseData.message)

                        inputFields.siblings('span[data-input-state="error"]').remove();
                        $('span[data-input-state="normal"]').hide();
                        $('span[data-input-state="success"]').remove();
                        inputFields.parent().next().empty();

                        inputFields.removeClass(cssClasses.errorInputClass).addClass(cssClasses.normalInputClass);
                        inputLabels.removeClass(cssClasses.errorLabelClass).addClass(cssClasses.normalLabelClass);
                        inputFields.removeClass(cssClasses.successInputClass).addClass(cssClasses.normalInputClass);
                        inputLabels.removeClass(cssClasses.successLabelClass).addClass(cssClasses.normalLabelClass);

                        const audio = new Audio('./failed.mp3');
                        audio.play();
                        $("#form-signin").addClass("shake");

                        setTimeout(function () {
                            $("#form-signin").removeClass("shake");
                            reject(responseData); // Reject the Promise with response data
                        }, 1000);

                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.error("Error:", errorThrown);
                    reject(errorThrown); // Reject the Promise with the error
                },
            });
        });
    }


    function handleSubmit(e) {
        e.preventDefault()
        signIn()
            .then(() => {
                const audio = new Audio('./success.wav');
                audio.play();
            })
            .then((responseData) => {
                console.log("User is valid");
                console.log("Admin Name: " + responseData.admin_name);
                console.log("User Role: " + responseData.user_role);
            })
            .catch((error) => {
                console.log(error)
            });
    }

    signInForm.on("submit", handleSubmit);


    // Function to validate an individual input field
    function validateField(fieldName, fieldValue) {
        const validationRules = {
            email: {
                presence: {
                    allowEmpty: false,
                    message: "cannot be empty"
                },
                email: {
                    message: "is invalid!",
                },
            },
            password: {
                exclusion: {
                    within: ["password"],
                    message: "'%{value}' is not allowed"
                },
                length: {
                    minimum: 8,
                    tooShort: "should be at least %{count} characters or more!",
                },
            },
        };

        const fieldErrors = validate({ [fieldName]: fieldValue.trim() }, validationRules);
        return fieldErrors ? fieldErrors[fieldName] : null;
    }

    // Event handler for input fields
    inputFields.on("input", function () {
        const fieldName = $(this).attr("name");
        const fieldValue = $(this).val();

        const errorMessage = validateField(fieldName, fieldValue);

        // Clear previous error messages for this field
        $(`div[data-validate-input="${fieldName}"]`).empty();
        $(this).siblings('span[data-input-state="success"]').remove();
        $(this).siblings('span[data-input-state="normal"]').show();



        if (errorMessage) {

            console.log(errorMessage)
            $(this).attr('data-input-state', 'error');
            console.log($(this).attr('data-input-state'))
            $(this).siblings('span[data-input-state="normal"]').show();

            $('button[type="submit"]')
                .text('Complete Fields')
                .prop('disabled', true);

            $(this).siblings('span[data-input-state="normal"]')
                .css({ "display": "absolute", "top": "0", "right": "0" });


            errorMessage.forEach((message) => {
                const errorHTML = `<div style="display: inline-flex; align-items: center; justify-content: start; width: 100%">${elements.miniCautionElement} <p style="margin: 2px;">${message}</p></div>`;

                $(`div[data-validate-input="${fieldName}"]`).append(errorHTML);
            });

            // Handle invalid input styling

            $(this).removeClass(cssClasses.successInputClass).addClass(cssClasses.errorInputClass);
            $(this).siblings('label').removeClass(cssClasses.successLabelClass).addClass(cssClasses.errorLabelClass);

            if ($(this).attr('name') == 'email') {
                $(this).parent().find('svg').remove();
                $(this).parent().append(elements.cautionElement);
            }
        } else {
            const inputLabel = $(this).siblings('label');
            const inputParent = $(this).parent();
            const inputParentSibling = $(this).parent().next();


            $(this).siblings('span[data-input-state="normal"]')
                .css({ "display": "absolute", "top": "0", "right": "1.5rem" });

            // Handle valid input styling
            $(this).removeClass(cssClasses.errorInputClass).removeClass(cssClasses.normalInputClass).addClass(cssClasses.successInputClass);
            inputLabel.removeClass(cssClasses.errorLabelClass).removeClass(cssClasses.normalLabelClass).addClass(cssClasses.successLabelClass);

            $(this).parent().find('svg').remove();
            inputParent.append(elements.checkElement);


            inputParentSibling.html(`<span style="display: inline-flex; align-items: center; justify-content: center; color: #16a34a;">${elements.miniCheckElement} <p style="margin: 2.5px; color: #16a34a;">Input is valid!</p><span>`);


            $(this).attr('data-input-state', 'success');
            console.log($(this).attr('data-input-state'))

            if ((emailInput.attr('data-input-state') == 'success') && passInput.attr('data-input-state') == 'success') {
                console.log("✔")
                $('button[type="submit"]')
                    .text('Submit')
                    .prop('disabled', false);
            }
        }

    });

});
