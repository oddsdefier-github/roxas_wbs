
function flagClient(clientID) {
    console.log(clientID);
    $("#flagClientModal").css({
        'display': 'grid',
        'place-items': 'center',
        'justify-content': 'center',
        'align-items': 'center'
    });
}

$(".submit_report").on('click', function (e) {
    e.preventDefault();
    const formData = new FormData($('.meter_report_form')[0]);
    // Log each key-value pair in the formData object
    formData.forEach((value, key) => {
        console.log(key, value);
        console.log(key)
        console.log(value.name)
    });
});