const clientIDHidden = $("#client_id_hidden");
const clientActionsModal = $("#clientActionsModal");

function clientActions(clientID) {
    $('#clientActionsModal').css({
        'display': 'grid',
        'place-items': 'center',
        'justify-content': 'center',
        'align-items': 'center'
    })
    clientIDHidden.val(clientID);
}

$(document).on("click", '[data-button-generate="true"]', function (event) {
    console.log(event.currentTarget.id)
    let clientID = clientIDHidden.val();
    switch (event.currentTarget.id) {
        case 'gen_reg_cert':
            // window.open(`print.php?id=${clientID}&type=reg_cert`, '_blank');
            window.open(`print.php?id=${clientID}`, '_blank');
    }
    setTimeout(function () {
        clientActionsModal.hide();
    }, 500)
})