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
            presence: {
                allowEmpty: false,
                message: "First name cannot be empty",
            },
        },
        middleName: {
            presence: {
                allowEmpty: false,
                message: "Middle name cannot be empty",
            },
        },
        lastNameInput: {
            presence: {
                allowEmpty: false,
                message: "Last name cannot be empty",
            },
        },
        age: {
            presence: {
                allowEmpty: false,
                message: "Age cannot be empty",
            },
        },
        contact: {
            presence: {
                allowEmpty: false,
                message: "Contact number cannot be empty",
            },
        },
        email: {
            presence: {
                allowEmpty: false,
                message: "Email cannot be empty",
            },
            email: {
                message: "Please enter a valid email address",
            },
        },
        streetAddress: {
            presence: {
                allowEmpty: false,
                message: "Street address cannot be empty",
            },
        },
    };


    applicationForm.on("submit", function (e) {
        e.preventDefault();

        // const formData = {
        //     firstName: $('input[name="first-name"]').val(),
        //     email: $('input[name="email"]').val(),
        // };

        // const validationResult = validate(formData, validationRules);
        // console.log(validationResult)
        // $('input[name="first-name"]').removeClass('border border-red-500 text-red-500');

        // if (validationResult) {
        //     $('input[name="first-name"]').val("Pakyo empty");
        // }

        // else {
        //     console.log("Form is valid, submitting...");
        // }

        const formData = {
            firstName: firstNameInput.val(),
            middleName: middleNameInput.val(),
            lastName: lastNameInput.val(),
            age: ageInput.val(),
            contact: contactInput.val(),
            email: emailInput.val(),
            streetAddress: streetAddressInput.val()
        }

        const validateInput = validate(formData, validationRules);

        if (validateInput) {
            console.log(validateInput)
            $.each(validateInput, function (index, item) {
                console.log("Index:", index, "Item:", item.length);
            })
        } else {
            console.log("Form is valid, submitting...");
        }
    });



}());