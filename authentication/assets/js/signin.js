function signIn() {
    console.log("SIGNING IN")
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
