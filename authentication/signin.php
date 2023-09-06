<?php

include 'connection/database.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Sign In</title>
	<link href="../dist/style.css" rel="stylesheet" />
	<link href="../dist/helpers.css" rel="stylesheet" />
</head>

<body class="flex min-h-screen flex-col bg-gray-200 font-inter">

	<main class="flex flex-1 items-center justify-center">
		<div class="flex w-full max-w-sm flex-col gap-7">
			<div class="flex w-full items-center justify-center">
				<img src="./assets/quality.png" alt="water-logo" class="aspect-square pointer-events-none w-14 select-none" />
			</div>
			<form id="form-signin" class=" w-full max-w-sm bg-white px-7 py-6 shadow-lg" action="#">
				<div class="my-5 text-center">
					<h1 class="block text-3xl font-bold text-gray-800">Sign in</h1>
					<p class="mt-3 text-sm text-gray-600">
						Already have an account?
						<a class="font-medium text-blue-500 decoration-2 hover:underline" href="signup.php"> Sign up here </a>
					</p>
				</div>
				<div>
					<div class="grid gap-y-4 my-2">
						<div class="relative">
							<select name="user_role" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" id="designation-select">
								<option value="1">Admin</option>
								<option value="2">Cashier</option>
								<option value="3">Meter Reader</option>
							</select>
							<label class="absolute text-sm text-gray-500 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Designation</label>
						</div>
						<!-- <div class="relative">
							<input type="text" name="email" placeholder=" " id="testemail" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
							<label class="pointer-events-none absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 
							peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Email Address</label>

						</div> -->

						<!-- sample -->
						<div>
							<div class="relative">
								<input name="email" type="email" id="email" aria-describedby="success_message" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 appearance-none dark:text-white dark:border-indigo-500 border-gray-300 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-600 peer" placeholder=" " />
								<label for="email" id="email_label" class="absolute text-sm text-gray-600 dark:text-indigo-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Email Address</label>
								<span class="absolute top-0 right-0 px-3 h-full grid place-items-center">
									<img id="check-icon" src="assets/check.svg" alt="check" class="hidden w-5 h-5">
								</span>
							</div>
							<p id="success_message" class="hidden mt-2 text-xs text-green-600 dark:text-green-400"><span class="font-medium">Well done!</span> Email valid.</p>
							<p id="error_message" class="hidden mt-2 text-xs text-red-600 dark:text-red-400">Please avoid using <span class="font-medium">uppercase</span> letters!</p>
						</div>

						<div>
							<div class="relative">
								<input name="password" type="password" id="password" aria-describedby="success_message" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 appearance-none dark:text-white dark:border-indigo-500 border-gray-300 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-600 peer" placeholder=" " />
								<label for="password" id="password_label" class="absolute text-sm text-gray-600 dark:text-indigo-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Password</label>

								<span class="absolute top-0 right-0 px-3 h-full grid place-items-center">
									<img id="eye-icon" src="assets/eye-close.svg" alt="eye-close" class="w-5 h-5">
								</span>
							</div>
							<!-- <p id="success_message" class="hidden mt-2 text-xs text-green-600 dark:text-green-400"><span class="font-medium">Well done!</span> Looks Correct.</p>
							<p id="error_message" class="hidden mt-2 text-xs text-red-600 dark:text-red-400">Please avoid using <span class="font-medium">uppercase</span> letters!</p> -->
						</div>


						<!-- <div class="relative">
							<input type="password" name="password" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="••••••••" />
							<label class="pointer-events-none absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1" id="filled_success" aria-describedby="filled_success_help">Password</label>

						</div> -->


						<!-- <div>
							<div class="relative">
								<input type="text" aria-describedby="outlined_error_help" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 appearance-none dark:text-white dark:border-red-500 border-red-600 dark:focus:border-red-500 focus:outline-none focus:ring-0 focus:border-red-600 peer" placeholder=" " />
								<label for="" class="absolute text-sm text-red-600 dark:text-red-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Outlined error</label>
							</div>
							<p id="outlined_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">Oh, snapp!</span> Some error message.</p>
						</div> -->

						<!-- sample -->

						<div class="text-sm text-gray-500">
							Password Validation message area!
						</div>

						<button id="submit-btn" type="submit" class="inline-flex items-center justify-center gap-2 rounded border border-transparent bg-primary-500 px-3 py-2 text-sm font-semibold text-white transition-all hover:bg-primary-700 focus:outline-none focus:ring focus:ring-blue-400 focus:ring-offset-2">Sign in </button>
						<div class="text-sm text-red-500">
							Sign in error messages!
						</div>
					</div>
				</div>
			</form>

		</div>
	</main>
	<script src="../js/jquery.min.js"></script>

	<script>
		$(document).ready(function() {
			let eyeIcon = $("#eye-icon")
			let passInput = $("input[type='password']");

			eyeIcon.on("click", function() {
				if (passInput.attr("type") === "password") {
					passInput.attr("type", "text");
					eyeIcon.attr("src", "assets/eye-open.svg");
				} else {
					passInput.attr("type", "password");
					eyeIcon.attr("src", "assets/eye-close.svg");
				}
			});
			$("select > option").addClass("py-5");
		});
	</script>

	<script>
		let submitBtn = $("#submit-btn");
		let successClassInput = "block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 border-green-600 appearance-none dark:text-white dark:border-green-500 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer";

		let errorClassInput = "block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 appearance-none dark:text-white dark:border-red-500 border-red-600 dark:focus:border-red-500 focus:outline-none focus:ring-0 focus:border-red-600 peer";

		let normalClassInput = "block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 appearance-none dark:text-white dark:border-indigo-500 border-gray-300 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-600 peer";


		let successClassLabel = "absolute text-sm text-green-600 dark:text-green-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1";

		let errorClassLabel = "absolute text-sm text-red-600 dark:text-red-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1";

		let normalClassLabel = "absolute text-sm text-gray-600 dark:text-indigo-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1";

		function liveValidateEmail() {
			$(document).ready(function() {
				let emailInput = $("#email");
				let emailLabel = $("#email_label");
				let successInput = $("#success_message");
				let errorInput = $("#error_message");
				let submitBtn = $("#submit_button");

				emailInput.on("input", function() {
					let inputValue = $(this).val().trim();
					let specialCharRegex = /[^a-zA-Z0-9@_.-]/;

					let uppercaseDetected = false;
					let specialCharDetected = false;

					for (let i = 0; i < inputValue.length; i++) {
						let character = inputValue[i];
						console.log(character)
						if (
							(character == "@") ||
							(character == "_") ||
							(character == ".") ||
							(!isNaN(Number(character))) ||
							(character !== character.toUpperCase())
						) {

							if (inputValue !== '') {
								$.ajax({
									url: "input_validate.php",
									type: "post",
									data: {
										emailData: inputValue
									},
									success: function(data, status) {
										let response = JSON.parse(data);
										let emailData = response.emailResponseData;
										$.each(emailData, function(index, item) {
											if (item === inputValue) {
												if (emailInput.hasClass(normalClassInput) && emailLabel.hasClass(normalClassLabel)) {
													emailInput.removeClass(normalClassInput);
													emailInput.addClass(successClassInput);

													emailLabel.removeClass(normalClassLabel);
													emailLabel.addClass(successClassLabel);

													successInput.show();
													$("#check-icon").show();
												}
												emailInput.prop("disabled", true);
											}
										})
									}
								})
							}
						} else {
							uppercaseDetected = true;
							break;
						}

					}
					if (specialCharRegex.test(inputValue)) {
						specialCharDetected = true;
					}

					if (uppercaseDetected || specialCharDetected) {
						submitBtn.prop("disabled", true);
						if (emailInput.hasClass(normalClassInput) && emailLabel.hasClass(normalClassLabel)) {
							emailInput.removeClass(normalClassInput);
							emailInput.addClass(errorClassInput);

							emailLabel.removeClass(normalClassLabel);
							emailLabel.addClass(errorClassLabel);

							if (specialCharDetected) {
								errorInput.text("Invalid email: Contains special characters");
							} else {
								errorInput.text("Invalid email: Contains uppercase letters");
							}

							errorInput.show();
						}
					} else {
						submitBtn.prop("disabled", false);
						if (emailInput.hasClass(errorClassInput) && emailLabel.hasClass(errorClassLabel)) {
							emailInput.removeClass(errorClassInput);
							emailInput.addClass(normalClassInput);

							emailLabel.removeClass(errorClassLabel);
							emailLabel.addClass(normalClassLabel);

							errorInput.hide();
						}
					}
				});
			});
		}
		liveValidateEmail()

		function signIn() {
			$(document).ready(function() {
				let designationSelected = $("#designation-select").find(":selected").text();
				$("#designation-select").on("change", function() {
					designationSelected = $(this).find(":selected").text();
				});

				$("#form-signin").on("submit", function(e) {
					e.preventDefault();
					console.log("submit");

					let emailInput = $("#email").val();
					let passInput = $("#password").val();

					$.ajax({
						url: "input_validate.php",
						type: "post",
						data: {
							emailSend: emailInput,
						},
						success: function(data, status) {
							let responseData = JSON.parse(data);
							console.log(responseData);
						}
					});
				});
			});

		}
		signIn()
	</script>
</body>

</html>