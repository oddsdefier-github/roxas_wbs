import { DataTableWithPagination } from './DataTableWithPagination.js';

const applicationFeeTable = "client_application_fees";
const penaltyTable = "penalty_fees";

function retrieveApplicationFees(id, table, htmlContainer) {
    $.ajax({
        url: "database_actions.php",
        type: "post",
        data: {
            action: "retrieveChargingFees",
            id: id,
            type: table
        },
        success: function (data) {
            console.log(data)
            htmlContainer.html(data)
        }
    })
}


function acceptClientAppPayment(id) {
    const feeSDescContainer = $(".application-fees-desc");
    retrieveApplicationFees(id, applicationFeeTable, feeSDescContainer);
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
        $.ajax({
            url: "database_actions.php",
            type: "post",
            data: {
                action: "confirmAppPayment",
                id: id
            },
            success: function (data) {
                console.log(data)
                alert(JSON.parse(data).message)
                const clientAppBillingTable = new DataTableWithPagination("client_application", '#displayClientAppBillingTable');
                acceptClientAppPayment.hide();
            }
        })
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