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
			<form action="signin_process.php" method="POST" class="w-full max-w-sm bg-white px-7 py-6 shadow-lg">
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
							<select name="user_role" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">

								<option selected>Admin</option>
								<option>Cashier</option>
								<option>Meter Reader</option>
							</select>
							<label class="absolute text-sm text-gray-500 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Designation</label>
						</div>
						<div class="relative">
							<input type="text" name="email" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
							<label class="pointer-events-none absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Email Address</label>
						</div>
						<div class="relative">
							<input type="password" name="password" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="••••••••" />
							<label class="pointer-events-none absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Password</label>

							<span class="absolute top-0 right-0 px-3 h-full grid place-items-center">
								<img id="eye-icon" src="assets/eye-close.svg" alt="eye-close" class="w-5 h-5">
							</span>

						</div>
						<input type="submit" name="submit" value="Sign in" class="inline-flex items-center justify-center gap-2 rounded border border-transparent bg-primary-500 px-3 py-2 text-sm font-semibold text-white transition-all hover:bg-primary-700 focus:outline-none focus:ring focus:ring-blue-400 focus:ring-offset-2">

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
</body>

</html>