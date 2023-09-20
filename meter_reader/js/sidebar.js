$(document).ready(function () {
    const toggleButton = $("#toggle-button");
    const sidebar = $("#sidebar");
    const arrowRight = $("#arrow-right");
    const arrowLeft = $("#arrow-left");

    toggleButton.click(function () {
        sidebar.toggleClass("hidden");
        arrowLeft.toggleClass("hidden");
        arrowRight.toggleClass("hidden");
    });

});