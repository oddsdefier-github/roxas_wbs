import { DataTableWithPagination } from './DataTableWithPagination.js';

const applicationFeeTable = "client_application_fees";
const penaltyTable = "penalty_fees";



function retrieveApplicationFees(id, table) {
    $.ajax({
        url: "database_actions.php",
        type: "post",
        data: {
            action: "retrieveChargingFees",
            id: id,
            type: table
        },
        success: function (data) {
            /**
             * Appends data to modal.
             * @param {string} data - The data to be appended to the modal.
             */
            function appendDataToModal(data) {
                const { fees } = JSON.parse(data);
                const { application_fee, inspection_fee, registration_fee, connection_fee, installation_fee } = fees;

                const total_fee = parseFloat(application_fee) + parseFloat(inspection_fee) + parseFloat(registration_fee) + parseFloat(connection_fee) + parseFloat(installation_fee);

                const formatNumber = (num) => {
                    return num.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ".00";
                };
                $(".application-fee").text("₱" + formatNumber(application_fee));
                $(".inspection-fee").text("₱" + formatNumber(inspection_fee));
                $(".registration-fee").text("₱" + formatNumber(registration_fee));
                $(".connection-fee").text("₱" + formatNumber(connection_fee));
                $(".installation-fee").text("₱" + formatNumber(installation_fee));
                $(".total-fee").text("₱" + formatNumber(total_fee));

                window.total_fee = total_fee;
            }

            appendDataToModal(data);
        }
    })
}

/**
 * Accepts payment for a client application.
 * @param {number} id - The ID of the client application.
 */
function acceptClientAppPayment(id) {
    retrieveApplicationFees(id, applicationFeeTable);
    const acceptClientAppPayment = $("#acceptAppPaymentModal");
    const confirmAppPayment = $("#confirm-app-payment");
    console.log(id)
    acceptClientAppPayment.css({
        'display': 'grid',
        'place-items': 'center',
        'justify-content': 'center',
        'align-items': 'center'
    });
    confirmAppPayment.off("click");
    confirmAppPayment.on("click", function (e) {
        e.preventDefault()
        // $.ajax({
        //     url: "database_actions.php",
        //     type: "post",
        //     data: {
        //         action: "confirmAppPayment",
        //         id: id,
        //         total_fee: window.total_fee 
        //     },
        //     success: function (data) {
        //         console.log(data)
        //         alert(JSON.parse(data).message)
        //         const clientAppBillingTable = new DataTableWithPagination("client_application", '#displayClientAppBillingTable');
        //         acceptClientAppPayment.hide();
        //     }
        // })
    })
}



function acceptClientBillingPayment(id) {
    const feeSDescContainer = $(".penalty-fees-desc");
    retrieveChargingFees(penaltyTable, feeSDescContainer);
    console.log(id)
    $("#client_billing_payment_id").val(id)
    $("#acceptBillingPaymentModal").css({
        'display': 'grid',
        'place-items': 'center',
        'justify-content': 'center',
        'align-items': 'center'
    });

    // $("#confirm-billing-payment").on("click", function () {
    //     $.ajax({
    //         url: "database_actions.php",
    //         type: "post",
    //         data: {
    //             action: "confirmBillPayment",
    //             id: id
    //         },
    //         success: function (data) {
    //             console.log(data)
    //             alert(JSON.parse(data).message)
    //             const clientAppBillingTable = new DataTableWithPagination("billing_data", '#displayClientAppBillingTable');
    //             $("#acceptPaymentModal").hide();
    //         }
    //     })
    // })
}

window.acceptClientBillingPayment = acceptClientBillingPayment
window.acceptClientAppPayment = acceptClientAppPayment