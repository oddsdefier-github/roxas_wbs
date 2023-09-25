(function () {
    "user strict";
    const firstNameInput = $('input[name="first-name"]');
    const middleNameInput = $('input[name="middle-name"]');
    const lastNameInput = $('input[name="last-name"]');
    const ageInput = $('input[name="age"]');
    const genderInput = $('input[name="gender"]');
    const contactInput = $('input[name="phone_number"]');
    const emailInput = $('input[name="email"]');
    const propertyTypeInput = $('input[name="property-type"]');
    const streetAddressInput = $('input[name="street-address"]');
    const brgyInput = $('input[name="brgy"]');
    const validIdCheck = $('input[name="valid-id"]');
    const proofOfOwnershipCheck = $('input[name="proof_of_ownership"]');
    const deedOfSaleCheck = $('input[name="deed_of_sale"]');
    const affidavitCheck = $('input[name="affidavit"]');


    const applicationForm = $("#application_form");
    const validationRules = {
        firstName: {
            format: {
                pattern: /^[a-zA-Z\s]+$/,
                message: "can only contain letters (A-Z, a-z) and spaces"
            },
            presence: {
                allowEmpty: false,
                message: "cannot be empty",
            },
            length: {
                minimum: 3,
                tooShort: "should be at least %{count} characters or more"
            }
        },
        middleName: {
            format: {
                pattern: /^[a-zA-Z\s]+$/,
                message: "can only contain letters (A-Z, a-z) and spaces"
            },
            presence: {
                allowEmpty: false,
                message: "cannot be empty",
            },
            length: {
                minimum: 3,
                tooShort: "should be at least %{count} characters or more"
            }
        },
        lastName: {
            format: {
                pattern: /^[a-zA-Z\s]+$/,
                message: "can only contain letters (A-Z, a-z) and spaces"
            },
            presence: {
                allowEmpty: false,
                message: "cannot be empty",
            },
            length: {
                minimum: 3,
                tooShort: "should be at least %{count} characters or more"
            }
        },
        age: {
            presence: {
                allowEmpty: false,
                message: "cannot be empty",
            },
            numericality: {
                onlyInteger: true,
                lessThanOrEqualTo: 80,
                greaterThan: 18
            }
        },
        contact: {
            presence: {
                allowEmpty: false,
                message: "cannot be empty",
            },
            format: {
                pattern: /^(?:\+63|09)\d{9,}$/,
                message: "should start with +63 or 09 and have at least 11 digits"
            }
        },
        email: {
            presence: {
                allowEmpty: false,
                message: "cannot be empty",
            },
            email: {
                message: "is invalid",
            },
        },
        streetAddress: {
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


    normalInputClass = 'ring-gray-300';
    errorInputClass = 'ring-red-300';
    successInputClass = 'ring-green-300';

    let hasError = false;

    applicationForm.on("submit", function (e) {
        $('.validate-input').removeClass(errorInputClass).addClass(successInputClass);

        $(".validate-feedback").empty()

        e.preventDefault();

        const formData = {
            firstName: firstNameInput.val().trim(),
            middleName: middleNameInput.val().trim(),
            lastName: lastNameInput.val().trim(),
            age: ageInput.val().trim(),
            contact: contactInput.val().trim(),
            email: emailInput.val().trim(),
            streetAddress: streetAddressInput.val().trim()
        }

        const validateInput = validate(formData, validationRules);

        if (validateInput) {
            console.log(validateInput)
            $.each(validateInput, function (fieldName, errorMessage) {

                const inputElement = $(`#${fieldName}-validation-message`).prev();

                hasError = true;
                if (hasError) {
                    inputElement.removeClass(normalInputClass);
                    inputElement.addClass(errorInputClass);
                }
                if (errorMessage.length > 1) {
                    const errorHTML = errorMessage.join("<br>"); // Join items with <br>
                    $(`#${fieldName}-validation-message`).html(errorHTML);
                } else {
                    $(`#${fieldName}-validation-message`).text(errorMessage[0]);
                }
            });
        } else {
            console.log("Form is valid, submitting...");
        }

    });



}());