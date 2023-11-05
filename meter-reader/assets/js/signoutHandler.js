class SignOutHandler {
    static signOut() {
        $.ajax({
            url: "signout.php",
            type: "post",
            success: function (data) {
                console.log(data)
                console.log(JSON.parse(data));
                console.log("SIGN OUT");
                SignOutHandler.hideSignOutModal();
            }
        });
    }


    static hideSignOutModal() {
        $('#signoutModal').hide();
        const signOutLoading = $(".signout-loader");
        signOutLoading.css({
            display: 'flex',
            flexDirection: 'column',
            justifyContent: 'center',
            alignItems: 'center'
        });
        signOutLoading.show();
        setTimeout(function () {
            signOutLoading.hide();
            window.location.href = '../index.php';
        }, 1000);
    }
}

function signOut() {
    localStorage.clear();
    SignOutHandler.signOut();
}
