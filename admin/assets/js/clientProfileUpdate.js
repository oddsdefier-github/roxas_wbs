const clientProfileForm = $('#clientProfileForm');
const statusInput = $('#status');
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


const clientID = localStorage.getItem('clientID');
console.log(`CLIENT ID: ${clientID}`);

function retrieveClientData(clientID) {
    $.ajax({
        url: "database_actions.php",
        type: "POST",
        data: {
            action: "retrieveClientData",
            clientID: clientID
        },
        success: function (clientData) {
            updateUI(clientData);
        }
    })
}
retrieveClientData(clientID)


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


function updateUI(clientData) {
    let { client_data } = JSON.parse(clientData);
    client_data = client_data[0];
    console.log(client_data);

    const { meter_number, full_name, full_address, status, first_name, middle_name, last_name, name_suffix, birthdate, age, gender, phone_number, email, property_type, brgy, street } = client_data;


    const clientProfileForm = $('#clientProfileForm');
    const statusInput = $('select[name="status"]');
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
    const nameTitle = $('.name-title');
    const addressSubtitle = $('.address-subtitle');

    const inputFields = $('.validate-input');


    statusInput.val(status);
    meterNumberInput.val(meter_number);
    nameTitle.text(full_name);
    addressSubtitle.text(full_address);
    firstNameInput.val(first_name);
    middleNameInput.val(middle_name);
    lastNameInput.val(last_name);
    nameSuffixInput.val(name_suffix);
    birthDateInput.val(birthdate);
    ageInput.val(`${age} years old`);
    genderInput.val(gender);
    phoneNumberInput.val(phone_number);
    emailInput.val(email);
    propertyTypeInput.val(property_type);
    streetAddressInput.val(street);
    brgyInput.val(brgy);

    fetchAddressData()
        .then((addressData) => {
            $('.applicant-address').each(function () {
                let selectElement = $(this);
                selectElement.empty();
                $.each(addressData, function (_, item) {
                    let option = $('<option>', {
                        value: item.id,
                        text: item.brgy
                    });
                    item.brgy === brgy ? option.prop('selected', true) : option.prop('selected', false);
                    selectElement.append(option);
                });
            });
        })
        .catch((error) => {
            console.error(error);
        });
}



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

function getSelectedItemValue(selectEl) {
    let value = selectEl.find(':selected').val();

    selectEl.on('change', function () {
        value = $(this).find(':selected').val();
        console.log("Selected Value: " + value);
    });

    return value;
}
function updateClientProfile() {
    function getSelectedStatusValue(selectEl) {
        let value = selectEl.find(':selected').val();
        selectEl.on('change', function () {
            value = $(this).find(':selected').val();
            console.log("Selected Value: " + value);
        });
        return value;
    }
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
        status: getSelectedStatusValue(statusInput),
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
        getFullNameWithInitial: function () {
            const middleInitial = this.middleName.length > 0 ? this.middleName.charAt(0) + '.' : '';
            const suffix = this.nameSuffix ? ' ' + this.nameSuffix : '';
            return `${this.firstName} ${middleInitial} ${this.lastName}${suffix}`;
        },
        getFullAddress: function () {
            return `${this.streetAddress}, ${this.brgy}, ${this.municipality}, ${this.province}, ${this.region}, Philippines`;
        }
    };

    console.log(formInput);

    $.ajax({
        url: "database_actions.php",
        type: "POST",
        dataType: "json",
        data: {
            action: "updateClientProfile",
            formData: {
                clientID: clientID,
                status: formInput.status,
                meterNumber: formInput.meterNumber,
                firstName: formInput.firstName,
                middleName: formInput.middleName,
                lastName: formInput.lastName,
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
                fullName: formInput.getFullNameWithInitial(),
                fullAddress: formInput.getFullAddress()
            }
        },
        success: function (data) {
            console.log(data)
            const { status, message } = data;
            if (status === 'success') {
                alert(message);
                window.location.reload();
            } else {
                alert(message);
            }

        },
        error: function (error) {
            console.log(error)
        }
    })
};

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

            $('#submit-update').prop('disabled', true);
            $(this).attr('data-input-track', 'error')

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

            $('#submit-update').prop('disabled', false);

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
    }, 100);
})

clientProfileForm.on("submit", function (e) {
    e.preventDefault();
    updateClientProfile();
});