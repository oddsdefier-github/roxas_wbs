let toggleButton = document.getElementById("toggle-button");
let sidebar = document.getElementById("sidebar");
let arrowRight = document.getElementById("arrow-right");
let arrowLeft = document.getElementById("arrow-left");
let arrowDown = document.getElementById("arrow-down");
let arrowUp = document.getElementById("arrow-up");
let tabMenu = document.getElementById("tab-menu");
let tabSubMenu = document.getElementById("tab-submenu");
let navContent = document.querySelector("nav > .nav-content");
let mainContent = document.querySelector("main");

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