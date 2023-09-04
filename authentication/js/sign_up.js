let showHideToggle = document.querySelectorAll(".show-toggle");
let passInputs = document.querySelectorAll("input[type='password']");

showHideToggle.forEach((toggle, index) => {

    let eyeOpen = toggle.querySelector(".eye-open");
    let eyeClose = toggle.querySelector(".eye-close");
    let passInput = passInputs[index];

    toggle.addEventListener("click", () => {
        eyeOpen.classList.toggle("hidden");
        eyeClose.classList.toggle("hidden");
        if (passInput.type === "password") {
            passInput.type = "text";
        } else {
            passInput.type = "password";
        }
        console.log("Click")
    });

})

let selectMenuOptions = document.querySelectorAll("select > option");
selectMenuOptions.forEach(option => {
    option.classList.add("py-5");
});