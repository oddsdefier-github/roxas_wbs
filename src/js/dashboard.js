const toggleButton = document.getElementById("toggle-button");
const sidebar = document.getElementById("sidebar");
const arrowRight = document.getElementById("arrow-right");
const arrowLeft = document.getElementById("arrow-left");
const arrowDown = document.getElementById("arrow-down");
const arrowUp = document.getElementById("arrow-up");
const tabMenu = document.getElementById("tab-menu");
const tabSubMenu = document.getElementById("tab-submenu");
const navContent = document.querySelector("nav > .nav-content");
const mainContent = document.querySelector("main");

toggleButton.addEventListener("click", () => {
    sidebar.classList.toggle("hidden");
    arrowLeft.classList.toggle("hidden");
    arrowRight.classList.toggle("hidden");
    navContent.classList.toggle("container");
    navContent.classList.toggle("mx-auto");
    navContent.classList.toggle("px-0");
    mainContent.classList.toggle("container");
    mainContent.classList.toggle("mx-auto");
    navContent.classList.toggle("px-0");
});
tabMenu.addEventListener("click", () => {
    event.preventDefault();
    tabSubMenu.classList.toggle("hidden");
    arrowDown.classList.toggle("hidden");
    arrowUp.classList.toggle("hidden");
});