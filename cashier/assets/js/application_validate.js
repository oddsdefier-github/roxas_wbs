$(document).ready(function () {
    const applicationForm = $('#application_form');
    const meterNumberInput = $('input[name="meterNumber"]')
    const firstNameInput = $('input[name="firstName"]');
    const middleNameInput = $('input[name="middleName"]');
    const lastNameInput = $('input[name="lastName"]');
    const nameSuffixInput = $('select[name="nameSuffix"]');
    const birthDateInput = $('input[name="birthdate"]')
    const ageInput = $('input[name="age"]');
    const genderInput = $('select[name="gender"]');
    const phoneNumberInput = $('input[name="phoneNumber"]');
    const emailInput = $('input[name="email"]');
    const propertyTypeInput = $('select[name="propertyType"]');
    const streetAddressInput = $('input[name="streetAddress"]');
    const brgyInput = $('select[name="brgy"]');
    const municipalityInput = $('input[name="municipality"]');
    const provinceInput = $('input[name="province"]');
    const regionInput = $('input[name="region"]');
    const validIdCheck = $('input[name="validId"]');
    const proofOfOwnershipCheck = $('input[name="proofOfOwnership"]');
    const deedOfSaleCheck = $('input[name="deedOfSale"]');
    const affidavitCheck = $('input[name="affidavit"]');
    const inputFields = $('.validate-input');


    inputs = [
        meterNumberInput,
        firstNameInput,
        middleNameInput,
        lastNameInput,
        phoneNumberInput,
        emailInput,
        streetAddressInput
    ]

    function addTrackingAttr() {
        $.each(inputs, function (index, item) {
            item.attr('data-input-track', 'error')
        })
        return `tracking attribute added for the ${inputs.length} inputs`
    }

    addTrackingAttr()

    console.log(addTrackingAttr())

    const cssClasses = {
        normalLabelClass: 'block text-sm font-medium leading-6 text-gray-600',
        errorLabelClass: 'block text-sm font-medium leading-6 text-red-600',
        successLabelClass: 'block text-sm font-medium leading-6 text-green-600',
        normalInputClass: 'block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6',
        errorInputClass: 'block w-full rounded-md border-0 py-3 text-red-900 shadow-sm ring-1 ring-inset ring-red-400 placeholder:text-red-400 focus:ring-2 focus:ring-inset focus:ring-red-500 sm:text-sm sm:leading-6',
        successInputClass: 'block w-full rounded-md border-0 py-3 text-green-900 shadow-sm ring-1 ring-inset ring-green-400 placeholder:text-green-400 focus:ring-2 focus:ring-inset focus:ring-green-500 sm:text-sm sm:leading-6',

        normalSubmitClass: 'rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600',
        errorSubmitClass: 'rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600',
    };

    const elements = {
        miniCheckElement: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
        </svg>`,

        checkElement: `<span data-input-state="success" class="absolute top-0 right-0 px-3 h-full grid place-items-center">
        <img id="check-icon" src="assets/check.svg" alt="check" class="w-5 h-5">
        </span>`,

        miniCautionElement: `<span data-input-state="error"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-red-600 w-3 h-3">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
        </svg></span>`,

        cautionElement: `<span data-input-state="error" class="absolute top-0 right-0 px-3 h-full grid place-items-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-red-600 w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
        </svg></span>`
    };


    function processApplication() {
        function getSelectedItemValue(selectEl) {
            let value = selectEl.find(':selected').text();
            selectEl.on('change', function () {
                value = selectEl.find(':selected').text();
                return value;
            });
            return value;
        }
        function getAgeIntValue(ageInput) {
            age = ageInput.val().trim();
            console.log(age);
            age = age.split(" ")[0]
            if (!isNaN(age)) {
                return age;
            } else {
                return null;
            }
        }

        function getCheckedItemValue(checkboxEl) {
            return checkboxEl.is(':checked') ? 'Yes' : 'No';
        }

        function formatName(name) {
            name = name.toLowerCase();
            if (name.length > 0) {
                const words = name.split(' ');

                for (let i = 0; i < words.length; i++) {
                    if (words[i].length > 0) {
                        words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
                    }
                }
                formattedName = words.join(' ');
                return formattedName;
            }
            return name;
        }

        const formInput = {
            meterNumber: meterNumberInput.val().toUpperCase(),
            firstName: formatName(firstNameInput.val()),
            middleName: formatName(middleNameInput.val()),
            lastName: formatName(lastNameInput.val()),
            nameSuffix: getSelectedItemValue(nameSuffixInput),
            birthDate: birthDateInput.val(),
            age: getAgeIntValue(ageInput),
            gender: getSelectedItemValue(genderInput),
            phoneNumber: phoneNumberInput.val(),
            email: emailInput.val(),
            propertyType: getSelectedItemValue(propertyTypeInput),
            streetAddress: formatName(streetAddressInput.val()),
            brgy: getSelectedItemValue(brgyInput),
            municipality: municipalityInput.val(),
            province: provinceInput.val(),
            region: regionInput.val(),
            validID: getCheckedItemValue(validIdCheck),
            proofOfOwnership: getCheckedItemValue(proofOfOwnershipCheck),
            deedOfSale: getCheckedItemValue(deedOfSaleCheck),
            affidavit: getCheckedItemValue(affidavitCheck),
            getFullNameWithInitial: function () {
                const middleInitial = this.middleName.length > 0 ? this.middleName.charAt(0) + '.' : '';
                const suffix = this.nameSuffix ? ' ' + this.nameSuffix : '';
                return `${this.firstName} ${middleInitial} ${this.lastName}${suffix}`;
            },
            getFullAddress: function () {
                return `${this.streetAddress}, ${this.brgy}, ${this.municipality}, ${this.province}, ${this.region}, Philippines`;
            }
        };

        console.log("meterNumber:", formInput.meterNumber);
        console.log("firstName:", formInput.firstName);
        console.log("middleName:", formInput.middleName);
        console.log("lastName:", formInput.lastName);
        console.log("nameSuffix:", formInput.nameSuffix);
        console.log("birthDate:", formInput.birthDate);
        console.log("age:", formInput.age);
        console.log("gender:", formInput.gender);
        console.log("phoneNumber:", formInput.phoneNumber);
        console.log("email:", formInput.email);
        console.log("propertyType:", formInput.propertyType);
        console.log("streetAddress:", formInput.streetAddress);
        console.log("brgy:", formInput.brgy);
        console.log("municipality:", formInput.municipality);
        console.log("province:", formInput.province);
        console.log("region:", formInput.region);
        console.log("validID:", formInput.validID);
        console.log("proofOfOwnership:", formInput.proofOfOwnership);
        console.log("deedOfSale:", formInput.deedOfSale);
        console.log("affidavit:", formInput.affidavit);
        console.log("getFullNameWithInitial:", formInput.getFullNameWithInitial());
        console.log("getFullAddress:", formInput.getFullAddress());


        $.ajax({
            url: "database_actions.php",
            type: "POST",
            dataType: "json",
            data: {
                action: "processClientApplication",
                formData: {
                    meterNumber: formInput.meterNumber,
                    firstName: formInput.firstName,
                    middleName: formInput.middleName,
                    lastName: formInput.lastName,
                    fullName: formInput.getFullNameWithInitial(),
                    nameSuffix: formInput.nameSuffix,
                    birthDate: formInput.birthDate,
                    age: formInput.age,
                    gender: formInput.gender,
                    phoneNumber: formInput.phoneNumber,
                    email: formInput.email,
                    propertyType: formInput.propertyType,
                    streetAddress: formInput.streetAddress,
                    brgy: formInput.brgy,
                    municipality: formInput.municipality,
                    province: formInput.province,
                    region: formInput.region,
                    fullAddress: formInput.getFullAddress(),
                    validID: formInput.validID,
                    proofOfOwnership: formInput.proofOfOwnership,
                    deedOfSale: formInput.deedOfSale,
                    affidavit: formInput.affidavit
                }
            },
            success: function (data) {
                responseData = data;
                console.log(data)

                if (responseData) {
                    if (responseData['status'] === 'error') {
                        alert(`${responseData['message']}`)
                    } else if ((responseData['status'] === 'success')) {
                        alert(`${responseData['applicant']}'s application has been added.`)
                        window.location.reload();
                        // setTimeout(function () {
                        //     window.location.reload();
                        // }, 1000)
                    }
                }
            },
            error: function (error) {
                console.log(error)
            }
        })

    };

    /**
     * TODO: Fix the date picker functionality
     * TODO: Manage the input validation -> submit form
     * ? Just include the form for review and apply, use only one form / div
     * * The age should be automatically calculated when date is set
     */

    birthDateInput.on("blur", function () {
        validateAndCalculateAge();
    });

    $('#birthdate').on("blur", function () {
        validateAndCalculateAge();
    });


    $('#birthdate').on("keyup", function (event) {
        if (event.key === 'Enter') {
            validateAndCalculateAge();
        }
    });

    function validateAndCalculateAge() {
        console.log("👩‍🎤");
        const dateText = $('#birthdate').val();
        const parts = dateText.split("/");

        if (parts.length === 3) {
            const birthdate = new Date(parts[2], parts[0] - 1, parts[1]);
            console.log(birthdate)
            const today = new Date();
            console.log(today)

            const age = today.getFullYear() - birthdate.getFullYear();
            console.log(age)

            if (parseInt(today.getMonth() < birthdate.getMonth() || (today.getMonth() === birthdate.getMonth() && today.getDate() < birthdate.getDate()))) {
                age--;
            }

            if (age < 18) {
                alert("You must be at least 18 years old.");
                $('#birthdate').val("");
                $("#age").val("");

            }
            else if (age > 100) {
                alert("Invalid age input.");
                $('#birthdate').val("");
                $("#age").val("");
            } else {
                $("#age").val(age + " years old");
            }
        } else {
            $("#age").html('<span style="color: red;">Invalid date</span>');
        }
    };
    /**
     * ! End of Date picker code
     */

    function handleSubmit(e) {
        e.preventDefault();

        processApplication();
    };

    applicationForm.on('submit', handleSubmit);


    function validateField(fieldName, fieldValue) {
        const validationRules = {
            meterNumber: {
                presence: {
                    allowEmpty: false,
                    message: "cannot be empty"
                },
                format: {
                    pattern: /^[Ww]-\d{5}$/,
                    message: "must be in the format 'W-12345' or 'w-12345'",
                },
            },
            firstName: {
                presence: {
                    allowEmpty: false,
                    message: "cannot be empty",
                },
                format: {
                    pattern: /^[a-zA-Z\s]+$/,
                    message: "can only contain letters (A-Z, a-z) and spaces"
                },
                length: {
                    minimum: 3,
                    tooShort: "should be at least %{count} characters or more"
                }
            },
            middleName: {
                presence: {
                    allowEmpty: false,
                    message: "cannot be empty",
                },
                format: {
                    pattern: /^[a-zA-Z\s]+$/,
                    message: "can only contain letters (A-Z, a-z) and spaces"
                },
                length: {
                    minimum: 3,
                    tooShort: "should be at least %{count} characters or more"
                }
            },
            lastName: {
                presence: {
                    allowEmpty: false,
                    message: "cannot be empty",
                },
                format: {
                    pattern: /^[a-zA-Z\s]+$/,
                    message: "can only contain letters (A-Z, a-z) and spaces"
                },
                length: {
                    minimum: 3,
                    tooShort: "should be at least %{count} characters or more"
                }
            },
            phoneNumber: {
                presence: {
                    allowEmpty: false,
                    message: "cannot be empty",
                },
                format: {
                    pattern: /^(09\d{9})$/,
                    message: "should start with '09' and have exactly 11 digits"
                },
                numericality: {
                    onlyInteger: true
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

        const fieldErrors = validate({ [fieldName]: fieldValue.trim() }, validationRules);
        return fieldErrors ? fieldErrors[fieldName] : null;
    }

    inputFields.on("input", function () {
        const fieldName = $(this).attr("name");
        const fieldValue = $(this).val();

        const errorMessage = validateField(fieldName, fieldValue);

        $(`div[data-validate-input="${fieldName}"]`).empty();
        $(this).siblings('span[data-input-state="success"]').remove();
        $(this).siblings('span[data-input-state="normal"]').show();


        if (errorMessage) {
            console.log(errorMessage)
            $(this).attr('data-input-track', 'error')


            console.log($(this).attr('data-input-state'));

            $('#submit-application')
                .text('Fill all fields')
                .prop('disabled', true)
                .attr('title', 'Complete the fields to unlock!')
                .removeClass(cssClasses.normalSubmitClass).addClass(cssClasses.errorSubmitClass);

            errorMessage.forEach((message) => {
                const errorHTML = `<div style="display: inline-flex; align-items: center; justify-content: start; width: 100%;">${elements.miniCautionElement} <p style="margin: 2px">${message}</p></div>`;
                $(`div[data-validate-input="${fieldName}"]`).append(errorHTML);
            });


            $(this).removeClass(cssClasses.successInputClass).addClass(cssClasses.errorInputClass);
            $(this).parent().siblings('label').removeClass(cssClasses.successLabelClass).addClass(cssClasses.errorLabelClass);

            $(this).parent().find('svg').remove();
            $(this).parent().append(elements.cautionElement);
        } else {
            $(this).attr('data-input-track', 'valid')


            if ($(this).attr('name') == 'phoneNumber' || $(this).attr('name') == 'meterNumber') {
                $(this).trigger('blur')
            }
            $(this).parent().find('svg').remove();


            const inputLabel = $(this).parent().siblings('label');
            const inputParent = $(this).parent();

            $(this).removeClass(cssClasses.errorInputClass).removeClass(cssClasses.normalInputClass).addClass(cssClasses.successInputClass);
            inputLabel.removeClass(cssClasses.errorLabelClass).removeClass(cssClasses.normalLabelClass).addClass(cssClasses.successLabelClass);

            inputParent.append(elements.checkElement);

            $(this).attr('data-input-state', 'success');
            $(this).parent().next().html(`<span style="display: inline-flex; align-items: center; justify-content: center; color: #16a34a;">${elements.miniCheckElement} <p style="margin: 2.5px; color: #16a34a;">Input is valid!</p><span>`);
        }

        let count = 0;
        $.each(inputs, function (index, item) {
            if (item.attr('data-input-track') === 'valid') {
                console.log('👌')
                count++
            }
            console.log(count)
            if (count === inputs.length) {
                console.log('🐓')
                $('#submit-application')
                    .text("Submit")
                    .prop('disabled', false)
                    .attr('title', 'You can now submit!')
                    .removeClass(cssClasses.errorSubmitClass).addClass(cssClasses.normalSubmitClass);
            }
        })


    })


    function navigateUsingArrowKey() {
        const inputs = document.querySelectorAll('input:not([type="checkbox"])');

        document.addEventListener('keydown', function (event) {
            if (event.key === 'ArrowRight') {
                event.preventDefault();
                focusNextEnabledInput();
            } else if (event.key === 'ArrowLeft') {
                event.preventDefault();
                focusPreviousEnabledInput();
            }
        });

        function focusNextEnabledInput() {
            const focusedInput = document.activeElement;
            const currentIndex = Array.from(inputs).indexOf(focusedInput);
            let nextIndex = (currentIndex + 1) % inputs.length;

            inputs[nextIndex].focus();
        }

        function focusPreviousEnabledInput() {
            const focusedInput = document.activeElement;
            const currentIndex = Array.from(inputs).indexOf(focusedInput);
            let previousIndex = (currentIndex - 1 + inputs.length) % inputs.length;

            inputs[previousIndex].focus();
        }
    }

    navigateUsingArrowKey();


});
