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