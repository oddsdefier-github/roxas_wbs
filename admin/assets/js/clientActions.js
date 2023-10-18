function clientActions(clientID) {
    console.log(clientID)
    $('#clientActionsModal').css({
        'display': 'grid',
        'place-items': 'center',
        'justify-content': 'center',
        'align-items': 'center'
    })
    $.ajax({
        url: "database_actions.php",
        type: "post",
        data: {
            clientID: clientID,
        },
        success: function (data) {
            // console.log(data)
        }
    })
}