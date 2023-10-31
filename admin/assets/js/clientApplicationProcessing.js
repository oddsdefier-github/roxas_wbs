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

    const folderName = 'wbs_zero_php';

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
        const billingStatus = applicationData.billing_status

        $('.name-title').text(applicationData.full_name)
        $('.address-subtitle').text(applicationData.full_address)

        const badgeElements = {
            approved: `<span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">
            <span class="w-2 h-2 mr-1 bg-green-500 rounded-full"></span>
            Approved </span>`,
            unconfirmed: `<span class="inline-flex items-center bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">
            <span class="w-2 h-2 mr-1 bg-yellow-500 rounded-full"></span>
            Unconfirmed </span>`,
            confirmed: `<span class="inline-flex items-center bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">
            <span class="w-2 h-2 mr-1 bg-blue-500 rounded-full"></span>
            Confirmed </span>`,
            paid: `<span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">
            <span class="w-2 h-2 mr-1 bg-green-500 rounded-full"></span>
            Paid </span>`,
            unpaid: `<span class="inline-flex items-center bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">
            <span class="w-2 h-2 mr-1 bg-yellow-500 rounded-full"></span>
            Unpaid </span>`,
        };
        function disableInput(elementsArray) {
            elementsArray.forEach((el) => {
                el.prop("disabled", true)
            });
        }
        const inputs = $('input');
        const selects = $('select');
        function enableInput(elementsArray) {
            elementsArray.forEach((el) => {
                el.prop("disabled", false)
            });
        }
        if (status === 'confirmed') {
            disableInput([inputs, selects])

            $('.status_badge').html(badgeElements.confirmed);
            $('#review_confirm')
                .prop('disabled', true)
                .hide();
            $("#approved_client").show();
            $("#review-submit")
                .prop("disabled", false)
            if (billingStatus === 'unpaid') {
                $('.billing_status_badge').html(badgeElements.unpaid);
                $("#review-submit")
                    .prop("disabled", true)
                $(".review-submit-text").text("Waiting for Payment");
                $(".btn-status-spinner").removeClass('hidden')
            } else if (billingStatus === 'paid') {
                $('.billing_status_badge').html(badgeElements.paid);
                $("#review-submit")
                    .show()
                $(".review-submit-text").text("Waiting for Approval");
                $(".btn-status-spinner").removeClass('hidden')
                enableInput([inputs, selects])
            } else {
                $('.billing_status_badge').html('');
                $("#review-submit").hide()
            }

        } else if (status === 'unconfirmed') {
            $('.status_badge').html(badgeElements.unconfirmed);
            $('#review_confirm')
                .show();
            $("#approved_client").hide();
            $("#review-submit").prop("disabled", false);
        } else {
            $('.status_badge').html(badgeElements.approved);
            $("#review-submit")
                .prop("disabled", true)
                .text("Already Approved");
            $('#review_confirm')
                .prop('disabled', true)
                .hide()
            $("#approved_client").hide();
            disableInput([inputs, selects])
        }



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

        function formatDate(dateString) {
            const [month, day, year] = dateString.split('/');
            const date = new Date(`${year}-${month}-${day}`);
            const formattedDate = date.toLocaleString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
            return formattedDate;
        }

        $(".readable-date").text(formatDate(birthDate))

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
     * Validates the birth date input and calculates the age of the client.
     * Displays error messages if the input is invalid or the client is under 18 or over 100 years old.
     * If the input is valid, displays the age and the birth date in a readable format and focuses on the gender input.
     */
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
                    const clientID = responseData['client_id']; //for printing its not the id in the url

                    if (responseData['status'] === 'error') {
                        alert(`${responseData['message']}`)
                    } else if ((responseData['status'] === 'success')) {

                        alert(`${responseData['message']}`)

                        // window.location.href = `http://localhost/${folderName}/admin/clients_application_table.php`;
                        window.location.reload();
                        window.open(`http://localhost/${folderName}/admin/print.php?id=${clientID}`, '_blank');
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
    const inputs = [
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

        let debounceTimeout;
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
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
        }, 100);
    })

    reviewForm.on('submit', function (e) {
        e.preventDefault();
        const validID = $('#validId');
        const proofOfOwnership = $('#proofOfOwnership');
        const deedOfSale = $('#deedOfSale');
        const affidavit = $('#affidavit'); // optional
        const reviewConfirmationModal = $('#reviewConfirmationModal');
        const confirmReviewCheck = $('#confirm_review_check');

        /**
         * Checks if the validID, proofOfOwnership, and deedOfSale checkboxes are all checked.
         * @returns {boolean} Returns true if all checkboxes are checked, false otherwise.
         */

        let isChecked = validID.prop('checked') && proofOfOwnership.prop('checked') && deedOfSale.prop('checked');
        if (!isChecked) {
            alert('Please upload valid documents!');
            return;
        }

        reviewConfirmationModal.css({
            'display': 'grid',
            'place-items': 'center',
            'justify-content': 'center',
            'align-items': 'center'
        });

        confirmReviewCheck.on('change', function () {
            const isConfirmed = confirmReviewCheck.prop('checked');

            const approvedClient = $('#approved_client');
            const reviewConfirm = $('#review_confirm');

            approvedClient.prop('disabled', !isConfirmed);
            reviewConfirm.prop('disabled', !isConfirmed);
            approvedClient.off('click');

            if (isConfirmed) {
                confirmUpdateApplication();
                approvedClient.on('click', function () {
                    processApplication();
                    reviewConfirmationModal.hide();
                });
            }
        });
    });

    function confirmUpdateApplication() {
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

        $("#review_confirm").on("click", function () {
            $.ajax({
                url: "database_actions.php",
                type: "post",
                dataType: "json",
                data: {
                    action: "updatedClientAppStatus",
                    applicantID: applicantID,
                    documentsData: {
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
                    $('#reviewConfirmationModal').hide();

                    console.log(data);
                    alert(data.message);
                    window.location.reload();
                }
            })
        });
    };


    function navigateUsingArrowKey() {
        const inputs = document.querySelectorAll('input:not([type="checkbox"]), select');

        document.addEventListener('keydown', function (event) {
            if (event.key === 'ArrowRight' || event.key === 'ArrowDown') {
                event.preventDefault();
                focusNextEnabledInput();
            } else if (event.key === 'ArrowLeft' || event.key === 'ArrowUp') {
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




