import { DataTableWithPagination } from './DataTableWithPagination.js';

const fullNameEl = $(".full_name");
const billingIDEl = $(".billing_id");
const meterNumberEl = $(".meter_number");
const clientIDEl = $(".client_id");
const propertyTypeEl = $(".property_type");

const consumptionEl = $(".consumption");
const ratesEl = $(".rates");
const penaltyEl = $(".penalty");
const taxEl = $(".tax");
const taxAmountEl = $(".tax_amount");
const subTotalBillEl = $(".subtotal_bill");
const totalBillEl = $(".total_bill");
const amountPaidEl = $("#amount_paid");
const remainingBalanceEl = $(".remaining_balance");
const amountDueEl = $(".amount_due");


const acceptBillingPaymentModal = $("#acceptBillingPaymentModal");
const amountPaidInput = $("#amount_paid_input");


const confirmBillPayment = $("#confirm-bill-payment");


function retrieveBillingRates() {
    $.ajax({
        url: "database_actions.php",
        type: "post",
        data: {
            action: "retrieveBillingRates",
        },
        success: function (data) {
            console.log(JSON.parse(data));
            const tax = JSON.parse(data).rates.tax;
            taxEl.attr('data-tax-rate', tax);
        }
    })
}

retrieveBillingRates();


function displayModal(el) {
    el.css({
        'display': 'grid',
        'place-items': 'center',
        'justify-content': 'center',
        'align-items': 'center'
    });
}


const formatNumber = (num) => {
    return num.toLocaleString('en-US', { style: 'currency', currency: 'PHP' });
};

function totalCalculationWithTax(billAmount, taxRate) {
    let numericBillAmount = parseFloat(billAmount);
    let numericTaxRate = parseFloat(taxRate);

    let taxAmount = numericBillAmount * (numericTaxRate / 100);

    let totalWithTax = (numericBillAmount + taxAmount).toFixed(2);
    return {
        taxAmount: parseFloat(taxAmount.toFixed(2)),
        totalWithTax: parseFloat(totalWithTax)
    };
}


function updateUI(dataObj) {
    fullNameEl.text(dataObj.full_name);
    billingIDEl.text(dataObj.billing_id);
    meterNumberEl.text(dataObj.meter_number);
    clientIDEl.text(dataObj.client_id);
    consumptionEl.text(dataObj.consumption);
    ratesEl.text(dataObj.rates);
    penaltyEl.text(dataObj.penalty);
    subTotalBillEl.text(dataObj.amount_due);
    taxEl.text(dataObj.tax);
    taxAmountEl.text(dataObj.taxAmount);
    totalBillEl.text(dataObj.totalBill);
    amountDueEl.text(dataObj.totalBill);
    propertyTypeEl.text(dataObj.property_type);
}



function acceptClientBillingPayment(jsonData) {
    clearInputsOrText([amountPaidInput, amountPaidEl, remainingBalanceEl]);
    amountDueEl.hide();
    setModalSettings();


    console.log(jsonData)
    const fullName = jsonData.full_name;
    const clientID = jsonData.client_id;
    const meterNumber = jsonData.meter_number;
    const propertyType = jsonData.property_type;
    const consumption = jsonData.consumption;
    const rates = jsonData.rates;
    const billingID = jsonData.billing_id;
    const billingAmount = jsonData.billing_amount;
    const penalty = jsonData.penalty;
    const dueDate = jsonData.due_date;
    const periodFrom = jsonData.period_from;
    const periodTo = jsonData.period_to;
    const billingAddress = jsonData.full_address;

    const tax = taxEl.attr('data-tax-rate');
    const taxPercentage = tax + "%";

    const billCalculation = totalCalculationWithTax(billingAmount, tax);
    const taxAmount = billCalculation.taxAmount;
    const totalBill = billCalculation.totalWithTax;

    window.totalBill = totalBill;

    console.log(totalBill)
    const UIElements = {
        consumption: consumption + " cu.m.",
        rates: formatNumber(parseFloat(rates)),
        penalty: formatNumber(parseFloat(penalty)),
        amount_due: formatNumber(parseFloat(billingAmount)),
        tax: taxPercentage,
        taxAmount: formatNumber(parseFloat(taxAmount)),
        totalBill: formatNumber(parseFloat(totalBill)),
        property_type: propertyType,
        full_name: fullName,
        billing_id: billingID,
        meter_number: meterNumber,
        client_id: clientID
    }
    updateUI(UIElements);

    displayModal($("#acceptBillingPaymentModal"));

    setConfirmPaymentButtonBehavior(totalBill);
    // $("#client_billing_payment_id").va)

}


amountPaidInput.attr('data-input-track', 'error');

function validateField(fieldName, fieldValue, totalBill) {
    totalBill = parseFloat(totalBill);
    const validationRules = {
        amount_paid_input: {
            presence: {
                allowEmpty: false,
                message: "cannot be empty"
            },
            numericality: {
                greaterThanOrEqualTo: totalBill,
                message: `must be greater than or equal to ${totalBill}`
            }
        }
    };

    const fieldErrors = validate({ [fieldName]: fieldValue.trim() }, validationRules);
    return fieldErrors ? fieldErrors[fieldName] : null;
}


amountPaidInput.on("input", function () {
    let rawInput = $(this).val();
    console.log(rawInput)
    let cleanedInput = rawInput.replace(/[^\d.]/g, '');
    let amountPaidInputVal = parseFloat(cleanedInput);

    if (isNaN(amountPaidInputVal)) {
        cleanedInput = "";
        amountPaidEl.text("");
        remainingBalanceEl.text("");
        amountDueEl.hide();
    } else {
        let remainingBalance = amountPaidInputVal - window.totalBill;

        remainingBalanceEl.text(formatNumber(remainingBalance));
        if (remainingBalance < 0) {
            remainingBalanceEl.removeClass("text-green-500").addClass("text-red-600");
            confirmBillPayment.prop("disabled", true);
        } else {
            remainingBalanceEl.removeClass("text-red-600").addClass("text-green-500");
            confirmBillPayment.prop("disabled", false);
        }

        amountPaidEl.text(formatNumber(amountPaidInputVal));
        amountDueEl.show();
    }

    $(this).val(cleanedInput);
    console.log('LOG')
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

function setModalSettings() {
    confirmBillPayment.html('Confirm');
    $("#close_modal").show();
    acceptBillingPaymentModal.css({
        'display': 'grid',
        'place-items': 'center',
        'justify-content': 'center',
        'align-items': 'center'
    });
    amountPaidInput.trigger("focus");
}

function setConfirmPaymentButtonBehavior(totalBill) {
    confirmBillPayment.off("click");
    confirmBillPayment.on("click", function (e) {
        e.preventDefault();
        handlePaymentConfirmation(totalBill);
    });
}


function handlePaymentConfirmation(totalBill) {
    $("#close_modal").hide();
    displayLoadingStatus(confirmBillPayment, 'Confirming...');

    const fieldName = amountPaidInput.attr("name");
    const fieldValue = amountPaidInput.val();
    const errorMessage = validateField(fieldName, fieldValue, totalBill);

    const remainingBalance = parseFloat(fieldValue) - totalBill;

    if (errorMessage) {
        console.log(errorMessage);
        return;
    }

    displayAmountDetails(totalBill, remainingBalance);
    sendPaymentConfirmationRequest(totalBill);
}

function displayAmountDetails(totalBill, remainingBalance) {
    $(".amount_due").text(formatNumber(totalBill));
    $(".remaining_balance").text(formatNumber(remainingBalance));
    amountDueEl.show();
}

function sendPaymentConfirmationRequest(totalBill) {
    // $.ajax({
    //     url: "database_actions.php",
    //     type: "post",
    //     data: {
    //         action: "confirmBillPayment",
    //         totalBill: totalBill
    //     },
    //     success: function (data) {
    //         setTimeout(function () {
    //             alert(JSON.parse(data).message);
    //             acceptBillingPaymentModal.hide();
    //             new DataTableWithPagination("client_application", '#displayClientAppBillingTable');
    //         }, 1000);
    //     }
    // });

    setTimeout(function () {
        acceptBillingPaymentModal.hide();
        new DataTableWithPagination("billing_data", '#displayBillingTable');
    }, 1000);
}



window.acceptClientBillingPayment = acceptClientBillingPayment