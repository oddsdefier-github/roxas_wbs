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

    const tabMenu = $(".tab-menu");

    let currentPath = window.location.pathname.split("/")[0];
    currentPath = location.pathname == "/" ? "index.php" : location.pathname.substring(1);
    currentPath = currentPath.substring(currentPath.lastIndexOf("/") + 1);

    $(".tab").each(function () {

        if (currentPath === "/") {
            currentPath = "index.php";
        }
        if ($(this).attr("href") === currentPath) {
            if ($(this).closest("ul").hasClass("submenu-container")) {
                $(this).closest(".submenu-container").siblings("a").addClass("bg-primary-600 shadow");
                $(this).closest("ul").toggleClass("open");
                $(this).addClass("text-primary-300");
                $(this).find("p").addClass("text-primary-300");

            } else {
                $(this).addClass("bg-primary-600 shadow");
                $(this).closest("ul").toggleClass("open");
            }
        }
    });

    const tabSubMenuContainer = $(".submenu-container");
    tabMenu.each(function () {
        $(this).on("click", function (event) {
            event.preventDefault();

            if ($(this).siblings("ul").hasClass('open')) {
                $(this).siblings("ul").removeClass("open").addClass("close");
            } else {
                $(this).siblings("ul").removeClass("close").addClass("open");
            }
        });
    })
})