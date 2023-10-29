const applicationFeeForm = $("#application_fee_form");
const penaltyFeeForm = $("#penalty_fee_form");

const applicationFeeFormInputs = $(".validate-application-fee-input");
const penaltyFeeFormInputs = $(".validate-penalty-fee-input");
const applicationFeeSubmit = $("#applicationFeeSubmit");

const applicationFeeInput = $("#applicationFee");
const inspectionFeeInput = $("#inspectionFee");
const registrationFeeInput = $("#registrationFee");
const installationFeeInput = $("#installationFee");
const connectionFeeInput = $("#connectionFee");

const latePaymentFeeInput = $("#latePaymentFee");
const disconnectionFeeInput = $("#disconnectionFee");


function extractInputsVal(inputs) {
    const inputFieldsValues = {
        applicationFeeInputs: {
            applicationFee: applicationFeeInput.val(),
            inspectionFee: inspectionFeeInput.val(),
            registrationFee: registrationFeeInput.val(),
            installationFee: installationFeeInput.val(),
            connectionFee: connectionFeeInput.val()
        },
        penaltyInputs: {
            latePaymentFee: latePaymentFeeInput.val(),
            disconnectionFee: disconnectionFeeInput.val()
        }
    }

    if (inputFieldsValues.hasOwnProperty(inputs)) {
        return inputFieldsValues[inputs]
    } else {
        return null
    }
}

function submitFormData(action, inputs) {
    const formData = extractInputsVal(inputs);
    if (formData !==) {
        $.ajax({
            url: "database_actions.php",
            type: "post",
            data: {
                action: action,
                formData: JSON.stringify(formData)
            },
            success: function (response) {
                console.log(response)
            },
            error: function (xhr, status, error) {
                console.log("An error occurred.", error);
            }
        });
    } else {
        console.log("Invalid form data key.");
    }
}


$.each(applicationFeeFormInputs, function (_, element) {
    $(element).attr('data-input-track', 'error');
});

$.each(penaltyFeeFormInputs, function (_, element) {
    $(element).attr('data-input-track', 'error');
});

const cssClasses = {
    normalLabelClass: 'flex items-center text-sm font-medium leading-6 text-gray-600',
    errorLabelClass: 'flex items-center text-sm font-medium leading-6 text-red-600',

    normalInputClass: 'block w-full rounded-md border-0 py-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-400 placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6',
    errorInputClass: 'block w-full rounded-md border-0 py-4 text-red-900 shadow-sm ring-1 ring-inset ring-red-400 placeholder:text-red-500 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6',

    normalSubmitClass: 'rounded-md bg-indigo-700 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600',
    errorSubmitClass: 'rounded-md bg-red-700 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600',
};

const elements = {
    miniCautionElement: `<span data-input-state="error"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-red-600 w-3 h-3">
    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
    </svg></span>`,

    cautionElement: `<span data-input-state="error" class="absolute top-0 right-0 px-3 h-full grid place-items-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-red-600 w-5 h-5">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
    </svg></span>`
};


function validateField(fieldName, fieldValue) {
    const validationRules = {
        applicationFee: {
            presence: {
                allowEmpty: false,
                message: "cannot be empty"
            },
            numericality: {
                onlyInteger: true
            }
        },
        inspectionFee: {
            presence: {
                allowEmpty: false,
                message: "cannot be empty"
            },
            numericality: {
                onlyInteger: true
            }
        },
        registrationFee: {
            presence: {
                allowEmpty: false,
                message: "cannot be empty"
            },
            numericality: {
                onlyInteger: true
            }
        },
        connectionFee: {
            presence: {
                allowEmpty: false,
                message: "cannot be empty"
            },
            numericality: {
                onlyInteger: true
            }
        },
        installationFee: {
            presence: {
                allowEmpty: false,
                message: "cannot be empty"
            },
            numericality: {
                onlyInteger: true
            }
        },
        latePaymentFee: {
            presence: {
                allowEmpty: false,
                message: "cannot be empty"
            },
            numericality: {
                onlyInteger: true
            }
        },
        disconnectionFee: {
            presence: {
                allowEmpty: false,
                message: "cannot be empty"
            },
            numericality: {
                onlyInteger: true
            }
        },
    };

    const fieldErrors = validate({ [fieldName]: fieldValue.trim() }, validationRules);
    return fieldErrors ? fieldErrors[fieldName] : null;
}


applicationFeeFormInputs.on("input", function () {
    const fieldName = $(this).attr("name");
    const fieldValue = $(this).val();
    const errorMessage = validateField(fieldName, fieldValue);

    if (errorMessage) {
        console.log(errorMessage)
        $(this).attr('data-input-track', 'error');
    } else {
        console.log("NO Error")
        $(this).attr('data-input-track', 'valid');
    }
});
penaltyFeeFormInputs.on("input", function () {
    const fieldName = $(this).attr("name");
    const fieldValue = $(this).val();
    const errorMessage = validateField(fieldName, fieldValue);

    if (errorMessage) {
        console.log(errorMessage)
        $(this).attr('data-input-track', 'error');
    } else {
        console.log("NO Error")
        $(this).attr('data-input-track', 'valid');
    }
});


applicationFeeFormInputs.on("input", function () {
    console.log($(this).attr("name"))
})



applicationFeeForm.on("submit", function (e) {
    e.preventDefault()

    $.each(applicationFeeFormInputs, function () {
        const fieldName = $(this).attr("name");
        const fieldValue = $(this).val();
        const errorMessage = validateField(fieldName, fieldValue);

        $(`div[data-validate-input="${fieldName}"]`).empty();

        if (errorMessage) {
            console.log(errorMessage)
            $(this).attr('data-input-track', 'error');

            errorMessage.forEach((message) => {
                const errorHTML = `<div style="display: inline-flex; align-items: center; justify-content: start; width: 100%;">${elements.miniCautionElement} <p style="margin: 2px">${message}</p></div>`;
                $(`div[data-validate-input="${fieldName}"]`).append(errorHTML);
            });

        } else {
            $(this).attr('data-input-track', 'valid');

            let count = 0;
            $.each(applicationFeeFormInputs, function (_, element) {
                const item = $(element);
                if (item.attr('data-input-track') === 'valid') {
                    count++;
                }
                if (count === applicationFeeFormInputs.length) {
                    console.log("SUBMIT")
                }
            });
        }
    });
})


penaltyFeeForm.on("submit", function (e) {

    e.preventDefault()
    $.each(penaltyFeeFormInputs, function () {
        const fieldName = $(this).attr("name");
        const fieldValue = $(this).val();
        const errorMessage = validateField(fieldName, fieldValue);

        $(`div[data-validate-input="${fieldName}"]`).empty();

        if (errorMessage) {
            console.log(errorMessage)
            $(this).attr('data-input-track', 'error');

            errorMessage.forEach((message) => {
                const errorHTML = `<div style="display: inline-flex; align-items: center; justify-content: start; width: 100%;">${elements.miniCautionElement} <p style="margin: 2px">${message}</p></div>`;
                $(`div[data-validate-input="${fieldName}"]`).append(errorHTML);
            });

        } else {
            $(this).attr('data-input-track', 'valid');

            let count = 0;
            $.each(penaltyFeeFormInputs, function (_, element) {
                const item = $(element);
                if (item.attr('data-input-track') === 'valid') {
                    count++;
                }
                if (count === penaltyFeeFormInputs.length) {
                    console.log("SUBMIT")
                }
            });
        }
    });
})

