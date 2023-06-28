let showHideToggle = document.getElementById("show-toggle");
let eyeOpen = document.getElementById("eye-open");
let eyeClose = document.getElementById("eye-close");
let passInput = document.querySelector("input[type='password']");

showHideToggle.addEventListener("click", () => {
    eyeOpen.classList.toggle("hidden");
    eyeClose.classList.toggle("hidden");
    if (passInput.type === "password") {
        passInput.type = "text";
    } else {
        passInput.type = "password";
    }
    console.log("Click")
});