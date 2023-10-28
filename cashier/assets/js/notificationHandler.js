const notificationBtn = $("#dropdownNotificationButton")
const notificationContainer = $("#notification_container");

notificationBtn.off("click");
notificationBtn.on("click", function () {
    console.log("CLICK")
    $.ajax({
        url: "database_actions.php",
        type: "post",
        data: {
            action: "loadNotification"
        },
        success: function (html) {
            console.log(html)
            console.log(html)
        }
    })
})