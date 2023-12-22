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

const cancelPayment = $("#cancel_payment");
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



function retrieveBillingData(clientID, callback) {
    $.ajax({
        url: "database_actions.php",
        type: "post",
        data: {
            action: "retrieveBillingData",
            clientID: clientID,
        },
        success: function (data) {


            const jsonData = JSON.parse(data).billingData
            console.log(jsonData)
            callback(jsonData)
        }
    })

}

retrieveBillingRates();

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

function acceptClientBillingPayment(clientID) {
    console.log(clientID)

    retrieveBillingData(clientID, function (jsonData) {
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

        const tax = taxEl.attr('data-tax-rate');
        const taxPercentage = tax + "%";

        const totalAmount = parseFloat(billingAmount) + parseFloat(penalty);
        const billCalculation = totalCalculationWithTax(totalAmount, tax);
        const taxAmount = billCalculation.taxAmount;
        const totalBill = billCalculation.totalWithTax;

        billingIDEl.text(billingID);
        clientIDEl.text(clientID);
        meterNumberEl.text(meterNumber);
        fullNameEl.text(fullName);
        propertyTypeEl.text(propertyType);
        taxEl.text(taxPercentage);
        consumptionEl.text(consumption + " cu.m.");
        ratesEl.text(formatNumber(parseFloat(rates)));
        penaltyEl.text(formatNumber(parseFloat(penalty)));
        subTotalBillEl.text(formatNumber(parseFloat(billingAmount)));
        taxAmountEl.text(formatNumber(parseFloat(taxAmount)));
        totalBillEl.text(formatNumber(parseFloat(totalBill)));
        amountDueEl.text(formatNumber(parseFloat(totalBill)));

        window.totalBill = totalBill;
    })
    amountDueEl.hide();
    setModalSettings();
    clearInputsOrText([amountPaidInput, amountPaidEl, remainingBalanceEl]);

    confirmBillPayment.off("click");
    confirmBillPayment.on("click", function (e) {
        e.preventDefault();
        $("#cancel_payment").hide();
        displayLoadingStatus(confirmBillPayment, 'Confirming...');
        handleValidationOnSubmit(window.totalBill, clientID);
    });
}


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


amountPaidInput.on("input", function () {
    let rawInput = $(this).val();
    let cleanedInput = rawInput.replace(/[^\d.]/g, '');
    let amountPaidInputVal = parseFloat(cleanedInput);

    if (isNaN(amountPaidInputVal)) {
        cleanedInput = "";
        amountPaidEl.text("");
        remainingBalanceEl.text("");
        amountDueEl.hide();
    } else {
        const totalBill = window.totalBill;
        let remainingBalance = amountPaidInputVal - totalBill;

        remainingBalanceEl.text(formatNumber(remainingBalance));
        if (remainingBalance < 0) {
            remainingBalanceEl.removeClass("text-green-500").addClass("text-red-600");
            confirmBillPayment.prop("disabled", true);
        } else {
            amountDueEl.text(formatNumber(totalBill));
            remainingBalanceEl.text(formatNumber(remainingBalance));
            amountDueEl.show();

            remainingBalanceEl.removeClass("text-red-600").addClass("text-green-500");
            confirmBillPayment.prop("disabled", false);
        }

        amountPaidEl.text(formatNumber(amountPaidInputVal));
        amountDueEl.show();
    }

    $(this).val(cleanedInput);
});

function handleValidationOnSubmit(totalBill, clientID) {
    const fieldName = amountPaidInput.attr("name");
    const fieldValue = amountPaidInput.val();
    const errorMessage = validateField(fieldName, fieldValue, totalBill);
    if (errorMessage) {
        console.log(errorMessage);
        return;
    }
    sendPaymentConfirmationRequest(totalBill, clientID);
}



function sendPaymentConfirmationRequest(totalBill, clientID) {
    let amountPaid = amountPaidInput.val();
    let remainingBalance = parseFloat(totalBill - amountPaid).toFixed(2);
    $.ajax({
        url: "database_actions.php",
        type: "post",
        data: {
            action: "confirmBillingPayment",
            formData: {
                clientID: clientID,
                amountPaid: amountPaid,
                remainingBalance: remainingBalance
            }
        },
        success: function (data) {
            console.log(data)
            alert(JSON.parse(data).message)
            acceptBillingPaymentModal.hide();
            new DataTableWithPagination("billing_data", '#displayBillingTable');

            setTimeout(function () {
                const responseData = JSON.parse(data);
                if (responseData.status === 'success') {
                    var pdfPath = responseData.filepath;
                    var dynamicFilename = responseData.filename;
                    downloadPDF(pdfPath, dynamicFilename);
                } else {
                    console.error("Error in report generation:", responseData.error);
                }
            }, 100);
        }
    });
}



window.acceptClientBillingPayment = acceptClientBillingPayment

function downloadPDF(pdfPath, dynamicFilename) {
    var link = document.createElement("a");
    link.href = pdfPath;
    link.download = dynamicFilename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}


const qrScan = $("#qrBilling");
const qrBillPaymentModal = $("#qrBillPaymentModal");

let permissionGranted = false;

qrScan.on('click', async function () {
    if (!permissionGranted) {
        try {
            await navigator.mediaDevices.getUserMedia({ video: true });
            permissionGranted = true;
        } catch (error) {
            console.error("Error getting camera permission:", error);
            return;
        }
    }

    qrBillPaymentModal.css({
        'display': 'grid',
        'place-items': 'center',
        'justify-content': 'center',
        'align-items': 'center'
    });

    function checkClientIDExistence(decodedText) {
        $.ajax({
            url: "database_actions.php",
            type: "post",
            data: {
                action: "checkClientIDExistence",
                clientID: decodedText
            },
            success: function (data) {
                console.log(data)
                const isClientIDExist = JSON.parse(data).is_exist;
                if (isClientIDExist) {
                    acceptClientBillingPayment(decodedText);
                    console.log("Payment accepted successfully.");
                } else {
                    alert("Invalid QR data.");
                }
            }
        });
    }

    function onScanSuccess(decodedText, decodedResult) {
        console.log("Decoded Result:", decodedResult);
        console.log("Decoded Text:", decodedText);

        try {
            qrBillPaymentModal.hide();
            checkClientIDExistence(decodedText);
        } catch (error) {
            console.error("Error in acceptClientBillingPayment:", error);
        }

        html5QrcodeScanner.clear();
    }


    let qrboxFunction = function (viewfinderWidth, viewfinderHeight) {
        let minEdgePercentage = 0.5; // 70%
        let minEdgeSize = Math.min(viewfinderWidth, viewfinderHeight);
        let qrboxSize = Math.floor(minEdgeSize * minEdgePercentage);
        return {
            width: qrboxSize,
            height: qrboxSize,
        };
    };

    let html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: qrboxFunction, rememberLastUsedCamera: true });
    html5QrcodeScanner.render(onScanSuccess);
});
