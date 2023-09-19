$(document).ready(function () {
    // signout-modal
    let $signoutModal = $('#signoutModal');
    let $signoutBtn = $('.signout');
    let $closeModal = $('#close-signout-modal');
    let $cancelSignout = $("#cancel-signout")

    $closeModal.click(function () {
        $signoutModal.toggle();
    })

    $cancelSignout.click(function () {
        $signoutModal.hide();
    })
    $signoutBtn.click(function () {
        $signoutModal.removeClass("hidden").addClass("flex justify-center items-center");
        $signoutModal.show();
        console.log("check")
    })

});