const notificationBtn = $("#dropdownNotificationButton");
const notificationContainer = $("#notification_container");
const notifCount = $('.notif-count');
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


function countUnreadNotifications() {
    $.ajax({
        url: "database_actions.php",
        type: "post",
        data: {
            action: "countUnreadNotifications"
        },
        success: function (data) {
            try {
                const response = JSON.parse(data);
                const status = response.status;
                const count = response.unread_count;

                if (status === 'success') {
                    notifCount.show();
                    notifCount.text(count);
                } else if (status === 'empty') {
                    notifCount.hide();
                }
            } catch (e) {
                console.error("Error parsing JSON response:", e);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX error:", textStatus, errorThrown);
        },
        complete: function () {
            setTimeout(countUnreadNotifications, 5000);
        }
    });
}

countUnreadNotifications();
