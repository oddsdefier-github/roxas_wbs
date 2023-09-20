$(document).ready(function () {
    const toggleButton = $("#toggle-button");
    const sidebar = $("#sidebar");
    const arrowRight = $("#arrow-right");
    const arrowLeft = $("#arrow-left");
    const arrowDown = $("#arrow-down");
    const arrowUp = $("#arrow-up");
    const tabMenu = $("#tab-menu");
    const tabSubMenu = $("#tab-submenu");

    toggleButton.click(function () {
        sidebar.toggleClass("hidden");
        arrowLeft.toggleClass("hidden");
        arrowRight.toggleClass("hidden");
    });

    tabMenu.click(function (event) {
        event.preventDefault();
        tabSubMenu.toggleClass("hidden");
        arrowDown.toggleClass("hidden");
        arrowUp.toggleClass("hidden");
    });
});