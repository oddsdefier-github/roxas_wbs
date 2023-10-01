$(document).ready(function () {
    id = $('#review-id-hidden').val();

    const meterNumberInput = $('input[name="meterNumber"]')
    const firstNameInput = $('input[name="firstName"]');
    const middleNameInput = $('input[name="middleName"]');
    const lastNameInput = $('input[name="lastName"]');
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
    const countryInput = $('input[name="country"]');
    const validIdCheck = $('input[name="validId"]');
    const proofOfOwnershipCheck = $('input[name="proofOfOwnership"]');
    const deedOfSaleCheck = $('input[name="deedOfSale"]');
    const affidavitCheck = $('input[name="affidavit"]');


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
                url: "fetch_address_data.php",
                type: "get",
                data: {
                    fetchAddress: true
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

    retrieveClientApplicationData(id, function (applicationData) {
        const meterNumber = applicationData.meter_number
        const firstName = applicationData.first_name
        const middleName = applicationData.middle_name
        const lastName = applicationData.last_name
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

        meterNumberInput.val(meterNumber);
        firstNameInput.val(firstName);
        middleNameInput.val(middleName);
        lastNameInput.val(lastName);
        ageInput.val(age);
        genderInput.find(':selected').text(gender)
        phoneNumberInput.val(phoneNumber);
        emailInput.val(email);
        propertyTypeInput.find(':selected').text(propertyType)
        streetAddressInput.val(streetAddress);

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
})