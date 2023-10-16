$(document).ready(function () {


    const reviewForm = $('.review-form');
    const meterNumberInput = $('input[name="meterNumber"]');
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


    function retrieveClientApplicationData(applicantId, callback) {
        $.ajax({
            url: "database_actions.php",
            type: "POST",
            data: {
                action: "getClientApplicationData",
                id: applicantId,
            },
            success: function (data) {
                var applicationData = JSON.parse(data).applicationData;
                console.log(applicationData);
                callback(applicationData); // Call the callback function with the data
            },
            error: function (error) {
                console.log(error)
            }
        });
    }

    function fetchAddressData() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "database_actions.php",
                type: "post",
                dataType: "json",
                data: {
                    action: "getAddressData"
                },
                dataType: "json",
                success: function (data) {
                    if (data && data.address) {
                        resolve(data.address);
                    } else {
                        reject("Invalid or missing 'address' data in the response.");
                    }
                },
                error: function (xhr, status, error) {
                    reject("AJAX request failed with status: " + status);
                }
            });
        });
    }

    applicantID = $('#review-id-hidden').val();
    retrieveClientApplicationData(applicantID, function (applicationData) {
        const status = applicationData.status;
        const meterNumber = applicationData.meter_number
        const firstName = applicationData.first_name
        const middleName = applicationData.middle_name
        const lastName = applicationData.last_name
        const nameSuffix = applicationData.name_suffix
        const birthDate = applicationData.birthdate
        const age = applicationData.age
        const gender = applicationData.gender
        const phoneNumber = applicationData.phone_number
        const email = applicationData.email
        const propertyType = applicationData.property_type
        const streetAddress = applicationData.street
        const brgy = applicationData.brgy
        const validID = applicationData.valid_id
        const proofOfOwnership = applicationData.proof_of_ownership
        const deedOfSale = applicationData.deed_of_sale
        const affidavit = applicationData.affidavit


        $('.name-title').text(applicationData.full_name)
        $('.address-subtitle').text(applicationData.full_address)

        const badgeElements = {
            approved: `<span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
            <span class="w-2 h-2 mr-1 bg-green-500 rounded-full"></span>
            Approved </span>`,
            pending: `<span class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
            <span class="w-2 h-2 mr-1 bg-red-500 rounded-full"></span>
            Pending </span>`
        };

        status === 'approved' ? $('.status_badge').html(badgeElements.approved) : $('.status_badge').html(badgeElements.pending)
        status === 'pending' ? $('#review-submit').prop('disabled', false) : $('#review-submit').prop('disabled', true);
        meterNumberInput.val(meterNumber);
        firstNameInput.val(firstName);
        middleNameInput.val(middleName);
        lastNameInput.val(lastName);
        nameSuffixInput.val(nameSuffix);
        birthDateInput.val(birthDate);
        ageInput.val(age + (parseInt(age) > 1 ? ' years old' : ' year old'));
        genderInput.val(gender);
        phoneNumberInput.val(phoneNumber);
        emailInput.val(email);
        propertyTypeInput.val(propertyType);
        streetAddressInput.val(streetAddress);

        $("#application-id-hidden").val(applicationData.application_id)

        if (validID == 'Yes') {
            validIdCheck.prop('checked', true)
        }
        if (proofOfOwnership == 'Yes') {
            proofOfOwnershipCheck.prop('checked', true)
        }
        if (deedOfSale == 'Yes') {
            deedOfSaleCheck.prop('checked', true)
        }
        if (affidavit == 'Yes') {
            affidavitCheck.prop('checked', true)
        }

        fetchAddressData()
            .then((addressData) => {
                $('.applicant-address').each(function () {
                    let selectElement = $(this);
                    selectElement.empty();
                    $.each(addressData, function (index, item) {
                        let option = $('<option>', {
                            value: item.id,
                            text: item.barangay
                        });

                        if (item.barangay === brgy) {
                            option.prop('selected', true);
                        }
                        selectElement.append(option);

                    });
                });
            })
            .catch((error) => {
                console.error(error);
            });

    });


    /**
         * TODO: Fix the date picker functionality
         * TODO: Manage the input validation -> submit form
         * ? Just include the form for review and apply, use only one form / div
         * * The age should be automatically calculated when date is set
         */

    birthDateInput.on("blur", function () {
        validateAndCalculateAge();
    });


    birthDateInput.on("keyup", function (event) {
        if (event.key === 'Enter') {
            validateAndCalculateAge();
            $(this).trigger('blur')
        }
    });

    function validateAndCalculateAge() {
        const dateText = birthDateInput.val();
        const parts = dateText.split("/");

        if (parts.length === 3) {
            const birthdate = new Date(parts[2], parts[0] - 1, parts[1]);
            const today = new Date();

            const age = today.getFullYear() - birthdate.getFullYear();

            if (parseInt(today.getMonth() < birthdate.getMonth() || (today.getMonth() === birthdate.getMonth() && today.getDate() < birthdate.getDate()))) {
                age--;
            }

            if (age < 18) {
                alert("You must be at least 18 years old.");
                birthDateInput.val("");
                $('input[name="age"]').val("");
            }
            else if (age > 100) {
                alert("Invalid age input.");
                birthDateInput.val("");
                $('input[name="age"]').val("");
            } else {
                $('input[name="age"]').val(age + " years old");
            }
        } else {
            $('input[name="age"]').html('<span style="color: red;">Invalid date</span>');
        }
    };
    /**
     * ! End of Date picker code
     */

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
            applicationID: $("#application-id-hidden").val(),
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
                action: "approveClientApplication",
                formData: {
                    applicationID: formInput.applicationID,
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
                    const regID = responseData['registration_id'];

                    if (responseData['status'] === 'error') {
                        alert(`${responseData['message']}`)
                    } else if ((responseData['status'] === 'success')) {

                        alert(`${responseData['message']}`)

                        function setInitialBillingValue() {
                            $.ajax({
                                url: 'database_actions.php',
                                type: "post",
                                data: {
                                    action: "setInitialBillingData",
                                    regID: regID,
                                },
                                success: function (data) {
                                    console.log('Initial billing value set:', data);
                                    window.location.href = 'http://localhost/wbs_zero_php/admin/clients_application.php';
                                },
                                error: function (err) {
                                    console.log('Error setting initial billing value:', err);
                                }
                            });
                        }


                        window.open(`./print.php?id=${regID}`, '_blank');
                        setInitialBillingValue();

                    }
                }
            },
            error: function (error) {
                console.log(error)
            }
        })

    };



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
            age: {
                presence: {
                    allowEmpty: false,
                    message: "cannot be empty",
                },
                numericality: {
                    onlyInteger: true,
                    greaterThanOrEqualTo: 18,
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


    /**
     * ? Initialize the input to all have a data-input-track = "valid"
     * * 
     */
    inputs = [
        meterNumberInput,
        firstNameInput,
        middleNameInput,
        lastNameInput,
        ageInput,
        phoneNumberInput,
        emailInput,
        streetAddressInput
    ]

    function addTrackingAttr() {
        $.each(inputs, function (index, item) {
            item.attr('data-input-track', 'valid')
        })
        return `tracking valid attribute added for the ${inputs.length} inputs`
    }

    addTrackingAttr()
    console.log(addTrackingAttr())

    let count = inputs.length;
    console.log(`Count: ${count}`)

    //add tracking data attr


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

            console.log(`Count of valid: ${count}`)

            console.log($(this).attr('data-input-state'));

            console.log($('#review-submit').prop('disabled'))


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

            if ($(this).attr('name') == 'phoneNumber') {
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
    })


    reviewForm.on('submit', function (e) {
        e.preventDefault();

        if ($('#validId').prop('checked') === false) {
            alert('Please upload a Valid ID!')
        } else {
            console.log('SUBMITTED!!!!')
            // processApplication();

            $('#reviewConfirmationModal').css({
                'display': 'grid',
                'place-items': 'center',
                'justify-content': 'center',
                'align-items': 'center'
            })

            $('#review_confirm').off('click')
            $('#confirm_review_check').on('change', function () {
                if ($('#confirm_review_check').prop('checked') === true) {
                    $('#review_confirm').prop('disabled', false)
                } else {
                    $('#review_confirm').prop('disabled', true)
                }
                $('#review_confirm').on("click", function () {
                    processApplication();
                    $('#reviewConfirmationModal').hide();
                })
            })


        }
    });



});




