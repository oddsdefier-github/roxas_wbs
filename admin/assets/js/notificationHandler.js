const notificationBtn = $("#dropdownNotificationButton");
const notificationContainer = $("#notification_container");
const viewAllBtn = $("#view_all_notifications");

// Initialize the state of the notification container
notificationContainer.data('state', 'limited');

notificationBtn.off("click");
notificationBtn.on("click", function () {
    loadNotifications(10);
});

viewAllBtn.on("click", function () {
    loadNotifications('all');
});

function loadNotifications(limit) {
    $.ajax({
        url: "database_actions.php",
        type: "post",
        data: {
            action: "loadNotification",
            limit: limit
        },
        success: function (html) {
            notificationContainer.html(html);
            if (limit === 'all') {
                notificationContainer.data('state', 'all');
            } else {
                notificationContainer.data('state', 'limited');
            }

            toggleViewAllButton();
        }
    });
}

function toggleViewAllButton() {
    if (notificationContainer.data('state') === 'all') {
        viewAllBtn.prop('disabled', true); // Disable the button
    } else {
        viewAllBtn.prop('disabled', false); // Enable the button
    }
}
