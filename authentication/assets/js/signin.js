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
    $("select > option").addClass("py-5");


    const emailInput = $("#email");
    const passInput = $("#password");
    const emailLabel = $("#email_label");
    const passLabel = $("#password_label");
    const emailSuccess = $("#email_success");
    const emailError = $("#email_error");
    const passError = $("#pass_error");
    const checkIcon = $("#check-icon");


    const loader = $(".loader");
    const formSignIn = $("#form-signin");
    const submitBtn = $("#submit-btn");

    const formHeader = $("#form-header")
    const signInMessage = $("#signin-message");

    const loadingMessage = $("#loading-message")

    formSignIn.animate({
        left: '250px'
    });


    let successClassInput = "block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 border-green-600 appearance-none dark:text-white dark:border-green-500 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer";

    let errorClassInput = "block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 appearance-none dark:text-white dark:border-red-500 border-red-600 dark:focus:border-red-500 focus:outline-none focus:ring-0 focus:border-red-600 peer";

    let normalClassInput = "block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 appearance-none dark:text-white dark:border-indigo-500 border-gray-300 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-600 peer";


    let successClassLabel = "absolute text-sm text-green-600 dark:text-green-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1";

    let errorClassLabel = "absolute text-sm text-red-600 dark:text-red-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1";

    let normalClassLabel = "absolute text-sm text-gray-600 dark:text-indigo-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1";


    let errorEmailContainsSpecialChars = `
    <span class="flex justify-start space-x-2 items-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
        </svg>
        <span class="font-medium">Invalid email: Contains special characters.</span>
    </span>
    `;

    let errorEmailContainsUpperCase = `
    <span class="flex justify-start space-x-2 items-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
        </svg>
        <span class="font-medium">Invalid email: Contains uppercase characters.</span>
    </span>
    `;
    // function resetInput() {
    // 	emailLabel.addClass(normalClassLabel);
    // 	emailSuccess.hide();
    // 	emailError.hide();
    // 	checkIcon.hide();
    // 	emailInput.val("")

    // 	if (emailInput.hasClass(successClassInput) || emailLabel.hasClass(successClassInput)) {
    // 		emailInput.removeClass(successClassInput);
    // 		emailInput.addClass(normalClassInput);

    // 		emailLabel.removeClass(successClassLabel);
    // 		emailLabel.addClass(normalClassLabel);

    // 	}
    // 	if (emailInput.hasClass(errorClassInput) || emailLabel.hasClass(errorClassInput)) {
    // 		emailInput.removeClass(errorClassInput);
    // 		emailInput.addClass(normalClassInput);

    // 		emailLabel.removeClass(errorClassLabel);

    // 	}
    // }

    function refreshPage() {
        location.reload();
    }

    function liveValidateEmail() {
        $(document).ready(function () {
            emailInput.on("input", function () {

                let designationSelected = $("#designation-select").find(":selected").text();
                $("#designation-select").on("change", function () {
                    designationSelected = $(this).find(":selected").text();
                    refreshPage();
                    emailInput.prop("disabled", false);
                });

                let inputValue = $(this).val().trim();
                let specialCharRegex = /[^a-zA-Z0-9@_.-]/;

                let uppercaseDetected = false;
                let specialCharDetected = false;


                if (inputValue !== '') {
                    const lastCharacter = inputValue[inputValue.length - 1];
                    if (
                        (lastCharacter == "@") ||
                        (lastCharacter == "_") ||
                        (lastCharacter == ".") ||
                        (!isNaN(Number(lastCharacter))) ||
                        (lastCharacter != lastCharacter.toUpperCase())
                    ) {
                        $.ajax({
                            url: "input_validate.php",
                            type: "post",
                            data: {
                                emailData: inputValue
                            },
                            success: function (data, status) {
                                let response = JSON.parse(data);
                                console.log(response)


                                let email = response.emailData;
                                let designation = response.designationData;

                                console.log(email)

                                if (email === inputValue && designationSelected === designation) {
                                    if (emailInput.hasClass(normalClassInput) && emailLabel.hasClass(normalClassLabel)) {
                                        emailInput.removeClass(normalClassInput);
                                        emailInput.addClass(successClassInput);

                                        emailLabel.removeClass(normalClassLabel);
                                        emailLabel.addClass(successClassLabel);

                                        emailSuccess.show();
                                        checkIcon.show();
                                    }
                                    emailInput.prop("disabled", true);
                                }
                            }
                        })


                    } else {
                        uppercaseDetected = true;
                    }

                }


                if (specialCharRegex.test(inputValue)) {
                    specialCharDetected = true;
                }

                if (uppercaseDetected || specialCharDetected) {
                    submitBtn.prop("disabled", true);
                    if (emailInput.hasClass(normalClassInput) && emailLabel.hasClass(normalClassLabel)) {
                        emailInput.removeClass(normalClassInput);
                        emailInput.addClass(errorClassInput);

                        emailLabel.removeClass(normalClassLabel);
                        emailLabel.addClass(errorClassLabel);

                        if (specialCharDetected) {
                            emailError.html(errorEmailContainsSpecialChars)
                        } else {
                            emailError.html(errorEmailContainsUpperCase)
                        }

                        emailError.show();
                        emailError.html(errorMessageIcon)
                    }
                } else {
                    submitBtn.prop("disabled", false);
                    if (emailInput.hasClass(errorClassInput) && emailLabel.hasClass(errorClassLabel)) {
                        emailInput.removeClass(errorClassInput);
                        emailInput.addClass(normalClassInput);

                        emailLabel.removeClass(errorClassLabel);
                        emailLabel.addClass(normalClassLabel);

                        emailError.hide();

                    }
                }
            });
        });
    }
    liveValidateEmail()

    function liveValidatePass() {
        passInput.on("input", function () {
            if (passInput.hasClass(errorClassInput) && passLabel.hasClass(errorClassLabel)) {
                passInput.removeClass(errorClassInput);
                passInput.addClass(normalClassInput);

                passLabel.removeClass(errorClassLabel);
                passLabel.addClass(normalClassLabel);

                passError.hide();
            }
        })
    }
    liveValidatePass()

    function signIn() {
        let designationSelected = $("#designation-select").find(":selected").text();
        $("#designation-select").on("change", function () {
            designationSelected = $(this).find(":selected").text();
        });

        $("#form-signin").on("submit", function (e) {
            e.preventDefault();
            let emailInputVal = $("#email").val();
            let passInputVal = $("#password").val();

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

                    console.log(responseData)

                    if (responseData.valid) {
                        console.log("User is valid");
                        console.log("Admin Name: " + responseData.admin_name);
                        console.log("User Role: " + responseData.user_role);

                        if (responseData.user_role === "Admin") {
                            const audio = new Audio('./success.wav')
                            audio.play();
                            signInMessage.text(responseData.message);
                            signInMessage.removeClass("text-red-500");
                            signInMessage.addClass("text-green-500");

                            formSignIn.removeClass("ring ring-red-200")
                            formSignIn.addClass("ring ring-green-200")

                            formHeader.removeClass("text-red-500");
                            formHeader.addClass("text-green-500");

                            formHeader.text("Signing in!")

                            loader.css({
                                'display': 'flex',
                                'flex-direction': 'column',
                                'justify-content': 'center',
                                'align-items': 'center'

                            });
                            loader.show()
                            setTimeout(function () {
                                loader.hide()
                                window.location.href = "../admin/index.php";
                            }, 1000)

                        } else if (responseData.user_role === "Cashier") {
                            window.location.href = "../cashier/index.php";
                        } else if (responseData.user_role === "Meter Reader") {
                            window.location.href = "../meter_reader/index.php";
                        } else { }

                    } else {
                        const audio = new Audio('./failed.mp3')
                        audio.play();
                        $("#form-signin").addClass("shake")
                        setTimeout(function () {

                            console.log("User is not valid");
                            signInMessage.text(responseData.message);
                            formSignIn.addClass("ring ring-red-200");
                            formHeader.addClass("text-red-500");
                            formHeader.text("Can't Sign in!")
                            console.log(responseData.emptyFields.length)

                            if (responseData.emptyFields.length === 2) {
                                console.log("Both email and password are empty");

                                if (emailInput.hasClass(normalClassInput) && emailLabel.hasClass(normalClassLabel)) {
                                    emailInput.removeClass(normalClassInput);
                                    emailInput.addClass(errorClassInput);

                                    emailLabel.removeClass(normalClassLabel);
                                    emailLabel.addClass(errorClassLabel);

                                    emailError.show();

                                }
                                if (passInput.hasClass(normalClassInput) && passLabel.hasClass(normalClassLabel)) {
                                    passInput.removeClass(normalClassInput);
                                    passInput.addClass(errorClassInput);

                                    passLabel.removeClass(normalClassLabel);
                                    passLabel.addClass(errorClassLabel);

                                    passError.show();
                                }



                            } else if (responseData.emptyFields[0] == "Email") {
                                console.log("email is empty")
                                submitBtn.prop("disabled", true);


                                if (emailInput.hasClass(normalClassInput) && emailLabel.hasClass(normalClassLabel)) {
                                    emailInput.removeClass(normalClassInput);
                                    emailInput.addClass(errorClassInput);

                                    emailLabel.removeClass(normalClassLabel);
                                    emailLabel.addClass(errorClassLabel);

                                    emailError.show();

                                }


                            } else if (responseData.emptyFields[0] == "Password") {

                                if (passInput.hasClass(normalClassInput) && passLabel.hasClass(normalClassLabel)) {
                                    passInput.removeClass(normalClassInput);
                                    passInput.addClass(errorClassInput);

                                    passLabel.removeClass(normalClassLabel);
                                    passLabel.addClass(errorClassLabel);

                                    passError.show();
                                }

                            }
                        }, 200)
                        setTimeout(function () {
                            $("#form-signin").removeClass("shake")
                        }, 1000)
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.error("Error:", errorThrown);
                },
            });

        })

    }

    signIn();
    $("#designation-select").on("change", function () {
        if ($("#designation-select").find(":selected").text() === "Meter Reader") {
            emailInput.val("rogenevito@gmail.com");
            passInput.val("rogene123");
        } else if ($("#designation-select").find(":selected").text() === "Cashier") {
            emailInput.val("anthonygalang@gmail.com");
            passInput.val("anthony");
        } else {
            emailInput.val("jeffrypaner@gmail.com");
            passInput.val("jeffry123");
        }
    });
});