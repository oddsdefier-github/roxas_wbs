import { DataTableWithPagination } from './DataTableWithPagination.js';


function retrieveChargingFees() {
    const feesDescription = $(".fees-desc");
    $.ajax({
        url: "database_actions.php",
        type: "post",
        data: {
            action: "retrieveChargingFees",
            type: "client_application_fees"
        },
        success: function (data) {
            feesDescription.html(data)
        }
    })

}
function acceptClientAppPayment(id) {
    const acceptClientAppPayment = $("#acceptAppPaymentModal");
    const confirmAppPayment = $("#confirm-app-payment");
    console.log(id)
    $("#client_app_payment_id").val(id)
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