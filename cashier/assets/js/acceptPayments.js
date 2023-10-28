import { DataTableWithPagination } from './DataTableWithPagination.js';


function retrieveChargingFees() {
    return {}
}
function acceptClientAppPayment(id) {
    console.log(id)
    $("#client_app_payment_id").val(id)
    $("#acceptAppPaymentModal").css({
        'display': 'grid',
        'place-items': 'center',
        'justify-content': 'center',
        'align-items': 'center'
    });
    $("#confirm-app-payment").off("click");
    $("#confirm-app-payment").on("click", function (e) {
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
                $("#acceptAppPaymentModal").hide();
            }
        })
    })
}

function acceptClientBillingPayment(id) {
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