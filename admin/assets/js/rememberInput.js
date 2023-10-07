// document.addEventListener("DOMContentLoaded", function () {

//     // 1. Load values from local storage on page load
//     const formInputs = document.querySelectorAll('#application_form input, #application_form select');
//     formInputs.forEach(input => {
//         const storedValue = localStorage.getItem(input.name);
//         if (storedValue) {
//             input.value = storedValue;
//         }
//     });

//     // 2. Store values in local storage when they change
//     formInputs.forEach(input => {
//         input.addEventListener('input', function () {
//             localStorage.setItem(input.name, input.value);
//         });
//     });

//     // 3. Clear local storage data after submitting
//     document.querySelector("#application_form").addEventListener('submit', function () {
//         formInputs.forEach(input => {
//             localStorage.removeItem(input.name);
//         });
//     });
// });