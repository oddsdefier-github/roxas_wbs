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
	<link href="./assets/css/main.css" rel="stylesheet" />
</head>

<style>
	/* * {
		outline: 1px solid red;
	} */

	.success {
		border-color: #06b6d4;
	}

	.input-group p {
		margin-top: 5px;
		margin-left: 5px;
		color: #f87171;
		line-height: 1rem;
		font-size: 0.75rem;
	}
</style>

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
			<form id="form-signin" class="ring-1 ring-red-300 w-full max-w-md bg-white px-7 py-6 shadow-xl rounded-md transition-all duration-150">
				<div class="my-5 text-left">
					<a href="./redirect_demo.php">
						<h1 class="block text-2xl font-bold text-gray-800" id="form-header">Sign in</h1>
						<h5>to start managing customer's data.</h5>
						<p id="signin-message" class="text-sm font-medium text-red-500"></p>
					</a>
				</div>
				<div class="my-4">
					<div class="grid gap-y-4">
						<div class="relative">
							<select name="user_role" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" id="designation-select">
								<option value="1">Admin</option>
								<option value="2">Cashier</option>
								<option value="3">Meter Reader</option>
							</select>
							<label class="absolute text-sm text-gray-500 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Designation</label>
						</div>
						<div class="input-group">
							<div class="relative">
								<input id="email" name="email" type="email" class="validate-input block px-2.5 py-3 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 appearance-none border-gray-300 focus:outline-none focus:ring-0 focus:border-indigo-600 peer" placeholder=" " />
								<label for="email" id="email_label" class="absolute text-sm text-gray-600 dark:text-indigo-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Email Address</label>
							</div>
							<p data-validate-input="email"></p>
						</div>

						<div class="input-group">
							<div class="relative">
								<input id="password" name="password" type="password" class="validate-input block px-2.5 py-3 w-full text-sm text-gray-800 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-indigo-600 peer" placeholder=" " />
								<label for="password" id="password_label" class="absolute text-sm text-gray-600 dark:text-indigo-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Password</label>

								<span class="absolute top-0 right-0 px-3 h-full grid place-items-center">
									<img id="eye-icon" src="assets/eye-close.svg" alt="eye-close" class="w-5 h-5">
								</span>
							</div>
							<p data-validate-input="password"></p>
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


	<script src="./assets/libs/jquery/jquery.min.js"></script>
	<script src="./assets/libs/validate.js/validate.min.js"></script>
	<!-- <script src="./assets/js/signin.js"></script> -->
	<script src="./assets/js/validate.js"></script>

</body>

</html>