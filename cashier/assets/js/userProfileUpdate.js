const userProfileForm = $('#userProfileForm');
const designationSelect = $('select[name="designation"]');
const userIdInput = $('input[name="userId"]');
const emailInput = $('input[name="email"]');
const fullNameInput = $('input[name="fullName"]');
const passwordInput = $('input[name="password"]');
const confirmPasswordInput = $('input[name="confirmPassword"]');
const inputFields = $('.validate-input');
const userID = $('#user_id_hidden').val();
console.log(userID);

function retrieveUserData(userID) {
    $.ajax({
        url: "database_actions.php",
        type: "POST",
        data: {
            action: "retrieveUserData",
            userID: userID
        },
        success: function (userData) {
            updateUI(userData);
            console.log(userData);
        }
    })
}
retrieveUserData(userID)


function updateUI(userData) {
    let { user_data } = JSON.parse(userData);
    user_data = user_data[0];
    console.log(user_data);

    designationSelect.val(user_data.designation);
    userIdInput.val(user_data.user_id);
    emailInput.val(user_data.email);
    fullNameInput.val(user_data.user_name);
}


// const cssClasses = {
//     normalLabelClass: 'block text-sm font-medium leading-6 text-gray-600',
//     errorLabelClass: 'block text-sm font-medium leading-6 text-red-600',
//     successLabelClass: 'block text-sm font-medium leading-6 text-green-600',
//     normalInputClass: 'block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6',
//     errorInputClass: 'block w-full rounded-md border-0 py-3 text-red-900 shadow-sm ring-1 ring-inset ring-red-400 placeholder:text-red-400 focus:ring-2 focus:ring-inset focus:ring-red-500 sm:text-sm sm:leading-6',
//     successInputClass: 'block w-full rounded-md border-0 py-3 text-green-900 shadow-sm ring-1 ring-inset ring-green-400 placeholder:text-green-400 focus:ring-2 focus:ring-inset focus:ring-green-500 sm:text-sm sm:leading-6',

//     normalSubmitClass: 'rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600',
//     errorSubmitClass: 'rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600',
// };

// const elements = {
//     miniCheckElement: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
//     <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
//     </svg>`,

//     checkElement: `<span data-input-state="success" class="absolute top-0 right-0 px-3 h-full grid place-items-center">
//     <img id="check-icon" src="assets/check.svg" alt="check" class="w-5 h-5">
//     </span>`,

//     miniCautionElement: `<span data-input-state="error"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-red-600 w-3 h-3">
//     <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
//     </svg></span>`,

//     cautionElement: `<span data-input-state="error" class="absolute top-0 right-0 px-3 h-full grid place-items-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-red-600 w-5 h-5">
//     <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
//     </svg></span>`
// };

function checkPassword() {
    const password = passwordInput.val();
    const confirmPassword = confirmPasswordInput.val();

    if (password !== confirmPassword) {
        return false;
    }
    return true;
}

userProfileForm.on("submit", function (e) {
    e.preventDefault();
    if (!checkPassword()) {
        alert("Passwords do not match");
        return;
    }
    updateUserProfile();
});

function updateUserProfile() {
    let isPasswordMatch = checkPassword();
    if (!isPasswordMatch) {
        alert("Passwords do not match");
        return;
    }
    $.ajax({
        url: "database_actions.php",
        type: "POST",
        data: {
            action: "updateUserProfile",
            formData: {
                userID: userID,
                fullName: fullNameInput.val(),
                email: emailInput.val(),
                password: passwordInput.val(),
            }
        },
        success: function (data) {
            console.log(data)
            const { status, message } = data;
            if (status === 'success') {
                alert(message);
                window.location.reload();
            } else {
                alert(message);
            }

        },
        error: function (error) {
            console.log(error)
        }
    })

}