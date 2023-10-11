const email = $('#email');
const password = $('#password');
function autoFill(role) {
    if (role == "Admin") {
        email.val('jeffrypaner@gmail.com');
        password.val('jeffry123');
    } else if (role == "Meter Reader") {
        email.val('meterreader@gmail.com');
        password.val('meterreader');
    } else {
        email.val('cashier@gmail.com');
        password.val('cashier123');
    }
}

email.val('jeffrypaner@gmail.com');
password.val('jeffry123');

$('#designation-select').on('change', function () {
    let selectedRole = $('#designation-select').find(':selected').text();
    autoFill(selectedRole);
})