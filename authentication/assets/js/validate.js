document.addEventListener("DOMContentLoaded", () => {
    const eyeIcon = $("#eye-icon");
    const signInForm = $("#form-signin");
    const emailInput = $("#email");
    const passInput = $("#password");
    const inputFields = $('.validate-input');
    const inputLabels = inputFields.siblings('label');
    const signInMessage = $("#signin-message");
    const cssClasses = {
        input: {
            normal: 'block px-2.5 py-3 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 appearance-none border-gray-300 focus:outline-none focus:ring-0 focus:border-indigo-600 peer',
            error: 'block px-2.5 py-3 w-full text-sm text-red-800 bg-transparent rounded-lg border-1 border-red-500 appearance-none  focus:outline-none focus:ring-0 focus:border-red-600 peer',
            success: 'block px-2.5 py-3 w-full text-sm text-green-800 bg-transparent rounded-lg border-1 border-green-500 appearance-none focus:outline-none focus:ring-0 focus:border-green-600 peer'
        },
        label: {
            normal: 'absolute text-sm text-gray-600 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1',
            error: 'absolute text-sm text-red-600 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1',
            success: 'absolute text-sm text-green-600 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1'
        }
    };

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

    function togglePasswordVisibility() {
        const inputType = passInput.attr("type");
        console.log(`Current input type: ${inputType}`);
        const newType = inputType === "password" ? "text" : "password";
        const newIcon = inputType === "password" ? "assets/eye-open.svg" : "assets/eye-close.svg";
        passInput.attr("type", newType);
        eyeIcon.attr("src", newIcon);
    }

    function processSignIn() {
        return new Promise((resolve, reject) => {
            let designationSelected = $("#designation-select").find(":selected").text();
            let emailInputVal = emailInput.val();
            let passInputVal = passInput.val();

            $.ajax({
                url: "signin_process.php",
                type: "post",
                data: {
                    emailSend: emailInputVal,
                    passSend: passInputVal,
                    designationSelectedSend: designationSelected
                },
                success: function (response) {
                    const responseData = JSON.parse(response);

                    if (responseData.valid) {
                        resolve(responseData);
                        console.log(responseData)
                    } else {
                        signInMessage.text(responseData.message);
                        handleLoginFailure();

                        reject(responseData); // Reject the Promise with response data
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.error("Error:", errorThrown);
                    reject(errorThrown);
                },
            });
        });
    }

    function handleLoginFailure() {
        inputFields.siblings('span[data-input-state="error"]').remove();
        $('span[data-input-state="success"]').remove();
        $('span[data-input-state="normal"]').show();

        inputFields.parent().next().empty();

        inputFields.removeClass(cssClasses.input.error + ' ' + cssClasses.input.success).addClass(cssClasses.input.normal);
        inputLabels.removeClass(cssClasses.label.error + ' ' + cssClasses.label.success).addClass(cssClasses.label.normal);
        inputFields.val("")

        $('span[data-input-state="normal"]')
            .css({ "display": "absolute", "top": "0", "right": "0.1rem" });


        const audio = new Audio('./failed.mp3');
        audio.play();

        $("#form-signin").addClass("shake");

        setTimeout(function () {
            $("#form-signin").removeClass("shake");

        }, 500);
    }

    function playSuccessAudio() {
        const audio = new Audio('./success.wav');
        audio.play();
    }

    async function preloadPages(pages) {
        let loadedPages = {};

        for (let page of pages) {
            const data = await $.get(page);
            loadedPages[page] = data;
        }
        console.log(loadedPages)
        return loadedPages;
    }

    async function redirectToRolePage(userRole) {
        const roleRedirects = {
            "Admin": "../admin/index.php",
            "Cashier": "../cashier/index.php",
            "Meter Reader": "../meter_reader/index.php"
        };

        if (roleRedirects[userRole]) {
            signInForm.hide(200);

            const loader = $(".loader");
            loader.css({
                'display': 'flex',
                'flex-direction': 'column',
                'justify-content': 'center',
                'align-items': 'center'
            });

            // Show the loader
            loader.show();

            // Preload the pages asynchronously
            const pagesToPreload = [
                '../admin/clients.php',
                '../admin/dashboard.php',
                '../admin/clients_application.php',
                '../admin/logs.php',
                '../admin/client_application_review.php',
            ];

            await preloadPages(pagesToPreload);

            setTimeout(() => {
                $('#loading-message').text('Loading the page, please wait....')
            }, 100)
            await new Promise(resolve => setTimeout(resolve, 3000));
            loader.hide();

            // Redirect to the appropriate role page
            window.location.href = roleRedirects[userRole];
        } else {
            console.error('Unexpected user role:', userRole);
        }
    }




    function formSubmissionHandler(e) {
        e.preventDefault();
        if (validateFormOnSubmit()) {
            processSignIn()
                .then(responseData => {
                    if (responseData && responseData.user_role) {
                        playSuccessAudio();
                        redirectToRolePage(responseData.user_role);
                    } else {
                        console.error('Unexpected responseData structure:', responseData);
                    }
                })
                .catch(console.log);
        }
    }

    function validateFormOnSubmit() {
        const emailError = validateField("email", emailInput.val());
        const passwordError = validateField("password", passInput.val());
        const allErrors = {
            email: emailError,
            password: passwordError
        };

        let isValid = true;

        for (const [field, error] of Object.entries(allErrors)) {
            if (error) {
                isValid = false;
                displayFieldError(field, error);
            } else {
                displayFieldSuccess(field);
            }
        }

        return isValid;
    }

    function validateField(fieldName, fieldValue) {
        const fieldErrors = validate({ [fieldName]: fieldValue.trim() }, validationRules);
        return fieldErrors ? fieldErrors[fieldName] : null;
    }

    function displayFieldError(fieldName, errorMessage) {
        const targetInput = $(`input[name=${fieldName}]`);
        const targetLabel = targetInput.siblings('label');
        const targetParent = targetInput.parent();
        const targetParentSibling = targetInput.parent().next();

        targetInput.removeClass(cssClasses.input.success).addClass(cssClasses.input.error);
        targetLabel.removeClass(cssClasses.label.success).addClass(cssClasses.label.error);


        targetParent.find('span[data-input-state="error"], span[data-input-state="valid"]').remove();
        $('span[data-input-state="normal"]')
            .css({ "display": "absolute", "top": "0", "right": "0.1rem" });

        targetParentSibling.empty();

        errorMessage.forEach((message) => {
            const errorHTML = `<div style="display: inline-flex; align-items: center; justify-content: start; width: 100%">${elements.miniCautionElement} <p style="margin: 2px;">${message}</p></div>`;
            targetParentSibling.append(errorHTML);
        });

        if (fieldName == 'email') {
            targetParent.append(elements.cautionElement);
        }
    }

    function displayFieldSuccess(fieldName) {
        const targetInput = $(`input[name=${fieldName}]`);
        const targetLabel = targetInput.siblings('label');
        const targetParent = targetInput.parent();
        const targetParentSibling = targetInput.parent().next();

        targetInput.removeClass(cssClasses.input.error).addClass(cssClasses.input.success);
        targetLabel.removeClass(cssClasses.label.error).addClass(cssClasses.label.success);

        targetParent.find('span[data-input-state="error"], span[data-input-state="valid"]').remove();
        $('span[data-input-state="normal"]')
            .css({ "display": "absolute", "top": "0", "right": "1.5rem" });

        targetParentSibling.empty();

        const successHTML = `<span style="display: inline-flex; align-items: center; justify-content: center; color: #16a34a;">${elements.miniCheckElement} <p style="margin: 2.5px; color: #16a34a;">Input is valid!</p><span>`;
        targetParentSibling.append(successHTML);

        if (fieldName == 'email') {
            targetParent.append(elements.checkElement);
        }
    }


    function validateIndividualInput(inputElement) {

        // Clear previous error messages for this field
        const fieldName = inputElement.attr("name");
        const fieldValue = inputElement.val();
        const errorMessage = validateField(fieldName, fieldValue);


        $(`div[data-validate-input="${fieldName}"]`).empty();
        inputElement.siblings('span[data-input-state="success"]').remove();
        inputElement.siblings('span[data-input-state="normal"]').show();

        if (errorMessage) {
            inputElement.attr('data-input-state', 'error');

            errorMessage.forEach((message) => {
                const errorHTML = `<div style="display: inline-flex; align-items: center; justify-content: start; width: 100%">${elements.miniCautionElement} <p style="margin: 2px;">${message}</p></div>`;
                $(`div[data-validate-input="${fieldName}"]`).append(errorHTML);
            });

            // Handle invalid input styling
            inputElement.removeClass(cssClasses.input.success).addClass(cssClasses.input.error);
            inputElement.siblings('label').removeClass(cssClasses.label.success).addClass(cssClasses.label.error);

            inputElement.siblings('span[data-input-state="normal"]')
                .css({ "display": "absolute", "top": "0", "right": "0.1rem" });

            if (inputElement.attr('name') == 'email') {
                inputElement.parent().find('svg').remove();
                inputElement.parent().append(elements.cautionElement);
            }

            updateSubmitButtonState();

            return false; // indicates the input is not valid
        } else {
            const inputLabel = inputElement.siblings('label');
            const inputParent = inputElement.parent();
            const inputParentSibling = inputElement.parent().next();

            // Handle valid input styling
            inputElement.removeClass(cssClasses.input.error + ' ' + cssClasses.input.normal).addClass(cssClasses.input.success);
            inputLabel.removeClass(cssClasses.label.error + ' ' + cssClasses.label.normal).addClass(cssClasses.label.success);

            inputElement.siblings('span[data-input-state="normal"]')
                .css({ "display": "absolute", "top": "0", "right": "1.5rem" });

            inputElement.parent().find('svg').remove();
            inputParent.append(elements.checkElement);

            inputParentSibling.html(`<span style="display: inline-flex; align-items: center; justify-content: center; color: #16a34a;">${elements.miniCheckElement} <p style="margin: 2.5px; color: #16a34a;">Input is valid!</p><span>`);

            inputElement.attr('data-input-state', 'success');

            updateSubmitButtonState();

            return true; // indicates the input is valid
        }
    }

    function updateSubmitButtonState() {
        const allInputsValid = inputFields.toArray().every(input => $(input).attr('data-input-state') == 'success');
        if (allInputsValid) {
            $('button[type="submit"]').text('Submit').prop('disabled', false);
        } else {
            $('button[type="submit"]').text('Complete Fields').prop('disabled', true);
        }
    }

    function formSubmissionHandler(e) {
        e.preventDefault();

        let allInputsValid = true;
        inputFields.each(function () {
            if (!validateIndividualInput($(this))) {
                allInputsValid = false;
            }
        });

        if (allInputsValid) {
            processSignIn()
                .then(responseData => {
                    playSuccessAudio();
                    redirectToRolePage(responseData.user_role);
                })
                .catch(console.log);
        }
    }

    inputFields.on("input", function () {
        validateIndividualInput($(this));
    });


    eyeIcon.on("click", togglePasswordVisibility);
    signInForm.on("submit", formSubmissionHandler);

});
