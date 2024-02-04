const generatedBillingLogsBtn = $('#resetGeneratedBillingLogs');

generatedBillingLogsBtn.on('click', function () {
    $.ajax({
        url: "database_actions.php",
        type: "POST",
        data: {
            action: "resetGeneratedBillingLogs"
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            const { status, message } = data;
            if (status === 'success') {
                alert(message);
                window.location.reload();
            } else {
                alert(message);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
});
