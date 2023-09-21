<?php

include 'database/connection.php';

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

<body class="flex min-h-screen flex-col bg-primary-100 font-inter">
	<div class="absolute inset-x-0 -top-40 -z-40 transform-gpu overflow-hidden blur-3xl">
		<div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[35deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
	</div>
	<?php include 'loader.php' ?>
	<main class="flex flex-1 items-center justify-center">
		<div class="flex w-full max-w-sm flex-col gap-5">
			<div class="flex w-full items-center justify-center">
				<div id="logo"> <img src="./assets/quality.png" alt="water-logo" class="aspect-square pointer-events-none w-14 select-none" />
				</div>
				<!-- <div class="hidden absolute cursor-grab" id="cat">
					<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script><lottie-player src="https://lottie.host/8c2976a1-843f-4829-a62b-89f62d1c17b8/8HjjcW05ZO.json" background="transparent" speed="1" style="width: 300px; height: 300px" direction="1" mode="normal" loop autoplay hover></lottie-player>
				</div> -->
			</div>
			<form id="form-signin" class=" w-full max-w-sm bg-white px-7 py-6 shadow-xl rounded-md transition-all duration-150">
				<div class="my-5 text-left">
					<a href="./redirect_demo.php">
						<h1 class="block text-2xl font-bold text-gray-800" id="form-header">Sign in</h1>
						<p id="signin-message" class="text-sm font-medium text-red-500"></p>
					</a>
				</div>
				<div class="my-4">
					<div class="grid gap-y-4 my-2">
						<div class="relative">
							<select name="user_role" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" id="designation-select">
								<option value="1">Admin</option>
								<option value="2">Cashier</option>
								<option value="3">Meter Reader</option>
							</select>
							<label class="absolute text-sm text-gray-500 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Designation</label>
						</div>
						<div>
							<div class="relative">
								<input id="email" name="email" type="email" aria-describedby="success_message" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 appearance-none dark:text-white dark:border-indigo-500 border-gray-300 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-600 peer" placeholder=" " />
								<label for="email" id="email_label" class="absolute text-sm text-gray-600 dark:text-indigo-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Email Address</label>
								<span class="absolute top-0 right-0 px-3 h-full grid place-items-center">
									<img id="check-icon" src="assets/check.svg" alt="check" class="hidden w-5 h-5">
								</span>
							</div>
							<p id="email_success" class="hidden mt-2 text-xs text-green-600 dark:text-green-400">
								<span class="flex justify-start items-center space-x-2">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
										<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
									</svg>

									<span class="font-medium">Email input is valid.</span>
								</span>
							</p>
							<p id="email_error" class="hidden mt-2 text-xs text-red-600 dark:text-red-400">
								<span class="flex justify-start space-x-2 items-center">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
										<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
									</svg>
									<span class="font-medium">Empty: Please type your email.</span>
								</span>
							</p>
						</div>

						<div>
							<div class="relative">
								<input id="password" name="password" type="password" aria-describedby="success_message" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 appearance-none dark:text-white dark:border-indigo-500 border-gray-300 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-600 peer" placeholder=" " />
								<label for="password" id="password_label" class="absolute text-sm text-gray-600 dark:text-indigo-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Password</label>

								<span class="absolute top-0 right-0 px-3 h-full grid place-items-center">
									<img id="eye-icon" src="assets/eye-close.svg" alt="eye-close" class="w-5 h-5">
								</span>
							</div>
							<p id="pass_error" class="hidden mt-2 text-xs text-red-600 dark:text-red-400">
								<span class="flex justify-start space-x-2 items-center">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
										<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
									</svg>
									<span class="font-medium">Empty: Please type your password.</span>
								</span>
							</p>
						</div>

						<button id="submit-btn" type="submit" name="submit" class="inline-flex items-center justify-center gap-2 rounded border border-transparent bg-primary-500 px-3 py-2 text-sm font-semibold text-white transition-all hover:bg-primary-700 focus:outline-none focus:ring focus:ring-blue-400 focus:ring-offset-2">Sign in </button>

						<p class="text-sm text-gray-600">
							Not registered?
							<a class="font-medium text-blue-700 decoration-2 hover:underline" href="signup.php"> Create account </a>
						</p>
					</div>

				</div>
			</form>

		</div>

	</main>


	<script src="../js/jquery.min.js"></script>

	<script>
		$(document).ready(function() {

			// $("#logo").click(function() {
			// 	$("#cat").show()
			// 	$("#logo").hide()
			// 	console.log("click")
			// });
			// $("#cat").click(function() {
			// 	$("#logo").show()
			// 	$("#cat").hide()
			// });



			let eyeIcon = $("#eye-icon")

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


			const emailInput = $("#email");
			const passInput = $("#password");
			const emailLabel = $("#email_label");
			const passLabel = $("#password_label");
			const emailSuccess = $("#email_success");
			const emailError = $("#email_error");
			const passError = $("#pass_error");
			const checkIcon = $("#check-icon");


			const loader = $(".loader");
			const formSignIn = $("#form-signin");
			const submitBtn = $("#submit-btn");

			const formHeader = $("#form-header")
			const signInMessage = $("#signin-message");

			const loadingMessage = $("#loading-message")

			formSignIn.animate({
				left: '250px'
			});


			let successClassInput = "block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 border-green-600 appearance-none dark:text-white dark:border-green-500 dark:focus:border-green-500 focus:outline-none focus:ring-0 focus:border-green-600 peer";

			let errorClassInput = "block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 appearance-none dark:text-white dark:border-red-500 border-red-600 dark:focus:border-red-500 focus:outline-none focus:ring-0 focus:border-red-600 peer";

			let normalClassInput = "block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 appearance-none dark:text-white dark:border-indigo-500 border-gray-300 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-600 peer";


			let successClassLabel = "absolute text-sm text-green-600 dark:text-green-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1";

			let errorClassLabel = "absolute text-sm text-red-600 dark:text-red-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1";

			let normalClassLabel = "absolute text-sm text-gray-600 dark:text-indigo-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1";


			let errorEmailContainsSpecialChars = `
			<span class="flex justify-start space-x-2 items-center">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
					<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
				</svg>
				<span class="font-medium">Invalid email: Contains special characters.</span>
			</span>
			`;

			let errorEmailContainsUpperCase = `
			<span class="flex justify-start space-x-2 items-center">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
					<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
				</svg>
				<span class="font-medium">Invalid email: Contains uppercase characters.</span>
			</span>
			`;
			// function resetInput() {
			// 	emailLabel.addClass(normalClassLabel);
			// 	emailSuccess.hide();
			// 	emailError.hide();
			// 	checkIcon.hide();
			// 	emailInput.val("")

			// 	if (emailInput.hasClass(successClassInput) || emailLabel.hasClass(successClassInput)) {
			// 		emailInput.removeClass(successClassInput);
			// 		emailInput.addClass(normalClassInput);

			// 		emailLabel.removeClass(successClassLabel);
			// 		emailLabel.addClass(normalClassLabel);

			// 	}
			// 	if (emailInput.hasClass(errorClassInput) || emailLabel.hasClass(errorClassInput)) {
			// 		emailInput.removeClass(errorClassInput);
			// 		emailInput.addClass(normalClassInput);

			// 		emailLabel.removeClass(errorClassLabel);

			// 	}
			// }

			function refreshPage() {
				location.reload();
			}

			function liveValidateEmail() {
				$(document).ready(function() {
					emailInput.on("input", function() {

						let designationSelected = $("#designation-select").find(":selected").text();
						$("#designation-select").on("change", function() {
							designationSelected = $(this).find(":selected").text();
							refreshPage();
							emailInput.prop("disabled", false);
						});

						let inputValue = $(this).val().trim();
						let specialCharRegex = /[^a-zA-Z0-9@_.-]/;

						let uppercaseDetected = false;
						let specialCharDetected = false;


						if (inputValue !== '') {
							const lastCharacter = inputValue[inputValue.length - 1];
							if (
								(lastCharacter == "@") ||
								(lastCharacter == "_") ||
								(lastCharacter == ".") ||
								(!isNaN(Number(lastCharacter))) ||
								(lastCharacter != lastCharacter.toUpperCase())
							) {
								$.ajax({
									url: "input_validate.php",
									type: "post",
									data: {
										emailData: inputValue
									},
									success: function(data, status) {
										let response = JSON.parse(data);
										console.log(response)


										let email = response.emailData;
										let designation = response.designationData;

										console.log(email)

										if (email === inputValue && designationSelected === designation) {
											if (emailInput.hasClass(normalClassInput) && emailLabel.hasClass(normalClassLabel)) {
												emailInput.removeClass(normalClassInput);
												emailInput.addClass(successClassInput);

												emailLabel.removeClass(normalClassLabel);
												emailLabel.addClass(successClassLabel);

												emailSuccess.show();
												checkIcon.show();
											}
											emailInput.prop("disabled", true);
										}
									}
								})


							} else {
								uppercaseDetected = true;
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
									emailError.html(errorEmailContainsSpecialChars)
								} else {
									emailError.html(errorEmailContainsUpperCase)
								}

								emailError.show();
								emailError.html(errorMessageIcon)
							}
						} else {
							submitBtn.prop("disabled", false);
							if (emailInput.hasClass(errorClassInput) && emailLabel.hasClass(errorClassLabel)) {
								emailInput.removeClass(errorClassInput);
								emailInput.addClass(normalClassInput);

								emailLabel.removeClass(errorClassLabel);
								emailLabel.addClass(normalClassLabel);

								emailError.hide();

							}
						}
					});
				});
			}
			liveValidateEmail()

			function liveValidatePass() {
				passInput.on("input", function() {
					if (passInput.hasClass(errorClassInput) && passLabel.hasClass(errorClassLabel)) {
						passInput.removeClass(errorClassInput);
						passInput.addClass(normalClassInput);

						passLabel.removeClass(errorClassLabel);
						passLabel.addClass(normalClassLabel);

						passError.hide();
					}
				})
			}
			liveValidatePass()

			function signIn() {
				let designationSelected = $("#designation-select").find(":selected").text();
				$("#designation-select").on("change", function() {
					designationSelected = $(this).find(":selected").text();
				});

				$("#form-signin").on("submit", function(e) {
					e.preventDefault();
					let emailInputVal = $("#email").val();
					let passInputVal = $("#password").val();

					$.ajax({
						url: "signin_process.php",
						type: "post",
						data: {
							emailSend: emailInputVal,
							passSend: passInputVal,
							designationSelectedSend: designationSelected
						},
						success: function(response) {
							var responseData = JSON.parse(response);

							console.log(responseData)

							if (responseData.valid) {
								console.log("User is valid");
								console.log("Admin Name: " + responseData.admin_name);
								console.log("User Role: " + responseData.user_role);

								if (responseData.user_role === "Admin") {

									signInMessage.text(responseData.message);
									signInMessage.removeClass("text-red-500");
									signInMessage.addClass("text-green-500");

									formSignIn.removeClass("ring ring-red-200")
									formSignIn.addClass("ring ring-green-200")

									formHeader.removeClass("text-red-500");
									formHeader.addClass("text-green-500");

									formHeader.text("Signing in!")

									loader.css({
										'display': 'flex',
										'flex-direction': 'column',
										'justify-content': 'center',
										'align-items': 'center'

									});
									loader.show()
									setTimeout(function() {
										loader.hide()
										window.location.href = "../admin/index.php";
									}, 1000)

								} else if (responseData.user_role === "Cashier") {
									window.location.href = "../cashier/index.php";
								} else if (responseData.user_role === "Meter Reader") {
									window.location.href = "../meter_reader/index.php";
								} else {}

							} else {
								console.log("User is not valid");
								signInMessage.text(responseData.message);
								formSignIn.addClass("ring ring-red-200");
								formHeader.addClass("text-red-500");
								formHeader.text("Can't Sign in!")
								console.log(responseData.emptyFields.length)

								if (responseData.emptyFields.length === 2) {
									console.log("Both email and password are empty");

									if (emailInput.hasClass(normalClassInput) && emailLabel.hasClass(normalClassLabel)) {
										emailInput.removeClass(normalClassInput);
										emailInput.addClass(errorClassInput);

										emailLabel.removeClass(normalClassLabel);
										emailLabel.addClass(errorClassLabel);

										emailError.show();

									}
									if (passInput.hasClass(normalClassInput) && passLabel.hasClass(normalClassLabel)) {
										passInput.removeClass(normalClassInput);
										passInput.addClass(errorClassInput);

										passLabel.removeClass(normalClassLabel);
										passLabel.addClass(errorClassLabel);

										passError.show();
									}



								} else if (responseData.emptyFields[0] == "Email") {
									console.log("email is empty")
									submitBtn.prop("disabled", true);


									if (emailInput.hasClass(normalClassInput) && emailLabel.hasClass(normalClassLabel)) {
										emailInput.removeClass(normalClassInput);
										emailInput.addClass(errorClassInput);

										emailLabel.removeClass(normalClassLabel);
										emailLabel.addClass(errorClassLabel);

										emailError.show();

									}


								} else if (responseData.emptyFields[0] == "Password") {

									if (passInput.hasClass(normalClassInput) && passLabel.hasClass(normalClassLabel)) {
										passInput.removeClass(normalClassInput);
										passInput.addClass(errorClassInput);

										passLabel.removeClass(normalClassLabel);
										passLabel.addClass(errorClassLabel);

										passError.show();
									}

								}
							}
						},
						error: function(xhr, textStatus, errorThrown) {
							console.error("Error:", errorThrown);
						},
					});

				})

			}
			signIn()



			$("#designation-select").on("change", function() {
				if ($("#designation-select").find(":selected").text() === "Meter Reader") {
					emailInput.val("rogenevito@gmail.com");
					passInput.val("rogene123");
				} else if ($("#designation-select").find(":selected").text() === "Cashier") {
					emailInput.val("anthonygalang@gmail.com");
					passInput.val("anthony");
				} else {
					emailInput.val("jeffrypaner@gmail.com");
					passInput.val("jeffry123");
				}
			});
		});
	</script>
</body>

</html>