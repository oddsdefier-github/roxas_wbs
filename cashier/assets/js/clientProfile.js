function openViewClientModal(clientID) {

    $("#clientProfileModal").css({
        'display': 'grid',
        'place-items': 'center',
        'justify-content': 'center',
        'align-items': 'center'
    })
    console.log(clientID)
    $.ajax({
        url: "database_actions.php",
        type: "post",
        data: {
            action: "retrieveClientData",
            clientID: clientID
        },
        dataType: "json",
        success: function (data) {
            var clientObject = data.client_data[0];
            console.log(clientObject)

            let content = JSON.stringify(clientObject);
            $('.content').html(content)
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Error: " + errorThrown);
        }
    })
}
window.openViewClientModal = openViewClientModal;