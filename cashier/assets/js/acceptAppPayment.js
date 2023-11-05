import { DataTableWithPagination } from './DataTableWithPagination.js';

const amountPaidInput = $("#amount_paid_input");
const amountPaid = $("#amount_paid");
const remainingBalanceEl = $(".remaining_balance");
const amountDueEl = $(".amount_due");

const acceptClientAppPaymentModal = $("#acceptAppPaymentModal");
const confirmAppPayment = $("#confirm-app-payment");

const formatNumber = (num) => {
    return num.toLocaleString('en-US', { style: 'currency', currency: 'PHP' });
};

function retrieveClientApplication(applicationID, callback) {
    $.ajax({
        url: "database_actions.php",
        type: "post",
        data: {
            action: "retrieveClientApplication",
            applicationID: applicationID
        },
        success: function (data) {
            console.log(JSON.parse(data));
            callback(data)
        }
    })

}

function retrieveApplicationFees(applicationID, callback) {
    console.log(applicationID)
    $.ajax({
        url: "database_actions.php",
        type: "post",
        data: {
            action: "retrieveClientApplicationFee",
        },
        success: function (data) {
            console.log(data);
            callback(data);
        }
    })
}

function setModalSettings() {
    clearInputsOrText([amountPaidInput, amountPaid, remainingBalanceEl]);
    amountDueEl.hide();
    confirmAppPayment.html('Confirm');
    $("#close_modal").show();

    acceptClientAppPaymentModal.css({
        'display': 'grid',
        'place-items': 'center',
        'justify-content': 'center',
        'align-items': 'center'
    });
    amountPaidInput.trigger("focus");
}

function appendPrimaryInfoToModal(applicationID) {
    retrieveClientApplication(applicationID, function (data) {
        const { client_application } = JSON.parse(data);
        const { application_id, property_type, full_name, meter_number } = client_application;
        $(".application_id").text(application_id);
        $(".property_type").text(property_type);
        $(".full_name").text(full_name);
        $(".meter_number").text(meter_number);
    })
}

function updateModalData(data) {
    setModalSettings();
    const { client_application_fees } = JSON.parse(data);
    const { application_fee, inspection_fee, registration_fee, connection_fee, installation_fee } = client_application_fees;
    const total_fee = parseFloat(application_fee) + parseFloat(inspection_fee) + parseFloat(registration_fee) + parseFloat(connection_fee) + parseFloat(installation_fee);

    $(".application-fee").text(formatNumber(parseFloat(application_fee)));
    $(".inspection-fee").text(formatNumber(parseFloat(inspection_fee)));
    $(".registration-fee").text(formatNumber(parseFloat(registration_fee)));
    $(".connection-fee").text(formatNumber(parseFloat(connection_fee)));
    $(".installation-fee").text(formatNumber(parseFloat(installation_fee)));
    $(".total_application_fee").text(formatNumber(parseFloat(total_fee)));
    amountDueEl.text(`-${formatNumber(total_fee)}`);
    return total_fee;
}


amountPaidInput.on("input", function () {
    let rawInput = $(this).val();

    let cleanedInput = rawInput.replace(/[^\d.]/g, '');
    let amountPaidInputVal = parseFloat(cleanedInput);

    if (isNaN(amountPaidInputVal)) {
        cleanedInput = "";
        amountPaid.text("");
        remainingBalanceEl.text("");
        amountDueEl.hide();
    } else {
        let remainingBalance = amountPaidInputVal - window.totalFee;

        remainingBalanceEl.text(formatNumber(remainingBalance));
        if (remainingBalance < 0) {
            remainingBalanceEl.removeClass("text-green-500").addClass("text-red-600");
            confirmAppPayment.prop("disabled", true);
        } else {
            remainingBalanceEl.removeClass("text-red-600").addClass("text-green-500");
            confirmAppPayment.prop("disabled", false);
        }

        amountPaid.text(formatNumber(amountPaidInputVal));
        amountDueEl.show();
    }

    $(this).val(cleanedInput);
});



function displayLoadingStatus(el, message) {
    let confirmStatus = $('<div role="status">' +
        '<svg aria-hidden="true" class="inline w-4 h-4 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-100" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">' +
        '<path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />' +
        '<path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />' +
        '</svg>' +
        '<span class="sr-only">Loading...</span>' +
        `<span>${message}</span>` +
        '</div>');

    el.html(confirmStatus);
}


function clearInputsOrText(el) {
    if (Array.isArray(el)) {
        el.forEach(function (input) {
            if (input.is("input")) {
                input.val("");
            } else {
                input.text("");
            }
        });
    } else {
        if (el.is("input")) {
            el.val("");
        } else {
            el.text("");
        }
    }
}

function handleSubmitEvent() {
    $("#close_modal").hide();
    displayLoadingStatus(confirmAppPayment, 'Confirming...');
}

function acceptClientAppPayment(applicationID) {
    appendPrimaryInfoToModal(applicationID);
    retrieveApplicationFees(applicationID, function (data) {
        const totalFee = updateModalData(data)
        window.totalFee = totalFee
        confirmAppPayment.off("click");
        confirmAppPayment.on("click", function (e) {
            e.preventDefault();

            handleSubmitEvent();

            if (validatePayment(totalFee)) {
                const data = {
                    applicationID: applicationID,
                    amountPaid: parseFloat(amountPaidInput.val())
                }
                sendPaymentConfirmationRequest(data);
            }
            return false;
        });
    });
}

function validatePayment(totalFee) {
    const fieldName = amountPaidInput.attr("name");
    const fieldValue = amountPaidInput.val();
    const errorMessage = validateField(fieldName, fieldValue, totalFee);

    const remainingBalance = parseFloat(fieldValue) - totalFee;

    if (errorMessage) {
        console.log(errorMessage);
        return false;
    }
    displayAmountDetails(totalFee, remainingBalance);
    return true;
}

function validateField(fieldName, fieldValue, totalFee) {
    totalFee = parseFloat(totalFee);
    const validationRules = {
        amount_paid_input: {
            presence: {
                allowEmpty: false,
                message: "cannot be empty"
            },
            numericality: {
                greaterThanOrEqualTo: totalFee,
                message: `must be greater than or equal to ${totalFee}`
            }
        }
    };
    const fieldErrors = validate({ [fieldName]: fieldValue.trim() }, validationRules);
    return fieldErrors ? fieldErrors[fieldName] : null;
}

function displayAmountDetails(totalFee, remainingBalance) {
    $(".amount_due").text(formatNumber(totalFee));
    $(".remaining_balance").text(formatNumber(remainingBalance));
    amountDueEl.show();
}


function sendPaymentConfirmationRequest(formData) {
    const { applicationID, amountPaid } = formData;
    $.ajax({
        url: "database_actions.php",
        type: "post",
        data: {
            action: "confirmAppPayment",
            formData: {
                applicationID: applicationID,
                amountPaid: amountPaid
            }
        },
        success: function (data) {
            setTimeout(function () {
                console.log(data)
                alert(JSON.parse(data).message);
                acceptClientAppPaymentModal.hide();
                new DataTableWithPagination("client_application", '#displayClientAppBillingTable');
            }, 1000);
        }
    });
}


window.acceptClientAppPayment = acceptClientAppPayment