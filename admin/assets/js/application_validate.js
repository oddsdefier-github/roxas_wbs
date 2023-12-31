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


    const inputs = [
        meterNumberInput,
        firstNameInput,
        middleNameInput,
        lastNameInput,
        phoneNumberInput,
        emailInput,
        streetAddressInput
    ]

    function addTrackingAttr() {
        $.each(inputs, function (_, item) {
            item.attr('data-input-track', 'error')
        })
        return `tracking attribute added for the ${inputs.length} inputs`
    }

    addTrackingAttr()

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
            email: emailInput.val().toLowerCase(),
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

                if (responseData) {
                    if (responseData['status'] === 'error') {
                        alert(`${responseData['message']}`)
                    } else if ((responseData['status'] === 'success')) {
                        alert(`${responseData['message']}`)
                        window.location.href = "http://localhost/wbs_zero_php/admin/clients_application_table.php";
                    }
                }
            },
            error: function (error) {
                console.log(error)
            }
        })

    };

    function validateAndCalculateAge() {
        const dateText = birthDateInput.val();
        const parts = dateText.split("/");

        if (parts.length !== 3 || parts[0].length !== 2 || parts[1].length !== 2 || parts[2].length !== 4) {
            alert("Error: Invalid date format. Use mm/dd/yyyy.");
            return;
        }

        const birthdate = new Date(parts[2], parts[0] - 1, parts[1]);

        if (isNaN(birthdate)) {
            alert("Error: Invalid date input.");
            return;
        }

        const today = new Date();
        if (birthdate > today) {
            alert("Birthdate cannot be in the future.");
            return;
        }

        const ageDiff = today - birthdate;
        const ageDate = new Date(ageDiff);
        const age = Math.abs(ageDate.getUTCFullYear() - 1970);

        if (age < 18) {
            alert("You must be at least 18 years old.");
            return;
        }

        if (age > 100) {
            alert("Invalid age input.");
            return;
        }

        $('input[name="age"]').val(`${age} years old`);
        const formattedDate = birthdate.toLocaleString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
        $(".readable-date").text(formattedDate);
        $('select[name="gender"]').trigger('focus');
    }


    birthDateInput.on("blur", function () {
        setTimeout(() => {
            if ($('.datepicker-picker').is(':visible')) {
                return;
            }
            validateAndCalculateAge();
        }, 100)
        console.log($(this).val());
    });

    birthDateInput.on("keyup", function (event) {
        if (event.key === 'Enter') {
            validateAndCalculateAge();
            $(this).trigger('blur');
        }
    });

    let submitStatus = $('<div role="status">' +
        '<svg aria-hidden="true" class="inline w-4 h-4 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-100" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">' +
        '<path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />' +
        '<path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />' +
        '</svg>' +
        '<span class="sr-only">Loading...</span>' +
        '<span>Submitting..</span>' +
        '</div>');


    function handleSubmit(e) {
        $("#submit-application").html(submitStatus)
        $("#submit-application").prop('disabled', true);
        $("#submit-application").prev('button').prop('disabled', true);
        e.preventDefault();
        setTimeout(() => {
            processApplication()
        }, 1000);
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
                format: {
                    pattern: /^[^A-Z]*$/,
                    message: "should not contain uppercase letters"
                }
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


    $('select').on("change", function () {
        switch ($(this).attr('name')) {
            case 'propertyType':
                $('input[name="firstName"]').trigger('focus');
                break;
            case 'nameSuffix':
                $('input[name="birthdate"]').trigger('focus');
                break;
            case 'gender':
                $('input[name="phoneNumber"]').trigger('focus');
                break;
            case 'brgy':
                $('input[name="streetAddress"]').trigger('focus');
                break;
        }
    });
    inputFields.on("input", function () {
        const fieldName = $(this).attr("name");
        const fieldValue = $(this).val();
        const errorMessage = validateField(fieldName, fieldValue);


        let debounceTimeout;
        clearTimeout(debounceTimeout);

        debounceTimeout = setTimeout(() => {
            $(`div[data-validate-input="${fieldName}"]`).empty();
            $(this).siblings('span[data-input-state="success"]').remove();
            $(this).siblings('span[data-input-state="normal"]').show();

            if (errorMessage) {
                $(this).attr('data-input-track', 'error')


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


                switch ($(this).attr('name')) {
                    case 'meterNumber':
                        $(this).trigger('blur');
                        $('select[name="propertyType"]').trigger('focus');
                        break;
                    case 'phoneNumber':
                        $(this).trigger('blur');
                        $('input[name="email"]').trigger('focus');
                        break;
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
            $.each(inputs, function (_, item) {
                if (item.attr('data-input-track') === 'valid') {
                    count++
                }
                if (count === inputs.length) {
                    $('#submit-application')
                        .text("Submit")
                        .prop('disabled', false)
                        .attr('title', 'You can now submit!')
                        .removeClass(cssClasses.errorSubmitClass).addClass(cssClasses.normalSubmitClass);
                }
            })
        }, 100);

    })


    // function navigateUsingArrowKey() {
    //     const inputs = document.querySelectorAll('input:not([type="checkbox"]), select');

    //     document.addEventListener('keydown', function (event) {
    //         if (event.key === 'ArrowRight' || event.key === 'ArrowDown') {
    //             event.preventDefault();
    //             focusNextEnabledInput();
    //         } else if (event.key === 'ArrowLeft' || event.key === 'ArrowUp') {
    //             event.preventDefault();
    //             focusPreviousEnabledInput();
    //         }
    //     });

    //     function focusNextEnabledInput() {
    //         const focusedInput = document.activeElement;
    //         const currentIndex = Array.from(inputs).indexOf(focusedInput);
    //         let nextIndex = (currentIndex + 1) % inputs.length;

    //         inputs[nextIndex].focus();
    //     }

    //     function focusPreviousEnabledInput() {
    //         const focusedInput = document.activeElement;
    //         const currentIndex = Array.from(inputs).indexOf(focusedInput);
    //         let previousIndex = (currentIndex - 1 + inputs.length) % inputs.length;

    //         inputs[previousIndex].focus();
    //     }
    // }

    // navigateUsingArrowKey();


});

