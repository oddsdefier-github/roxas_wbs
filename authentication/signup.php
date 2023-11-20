<?php
include 'database/connection.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Sign Up</title>
	<link href="../dist/style.css" rel="stylesheet" />
	<link href="../dist/helpers.css" rel="stylesheet" />
	<script defer src="./js/sign_up.js"></script>
</head>

<body class="flex min-h-screen flex-col bg-primary-600 font-sans">
	<main class="flex flex-1 items-center justify-center">
		<div class="flex w-full max-w-sm flex-col gap-7">
			<div class="flex w-full items-center justify-center">
				<img src="./assets/quality.png" alt="water-logo" class="aspect-square pointer-events-none w-14 select-none brightness-0 invert filter" />
			</div>
			<div class="shadow-lg">
				<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" class="w-full bg-white px-7 py-6">
					<div class="my-5 text-center">
						<h1 class="block text-3xl font-bold text-gray-800">Page Under Construction</h1>
						<p class="mt-3 text-sm text-gray-600">
							Don't have an account yet?
							<a class="font-medium text-blue-500 decoration-2 hover:underline" href="signin.php"> Sign in here </a>
						</p>
					</div>
					<div>
						<div class="grid gap-y-4 my-2">
							<div class="relative">
								<select class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
									<option selected class="text-gray-300">Choose your Designation</option>
									<option>Admin</option>
									<option>Cashier</option>
									<option>Meter Reader</option>
								</select>
								<label class="absolute text-sm text-gray-500 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Designation</label>
							</div>
							<div class="relative">
								<input type="text" name="personnel_name" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
								<label class="pointer-events-none absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Full Name</label>
							</div>
							<div class="relative">
								<input type="email" name="email" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
								<label class="pointer-events-none absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Email Address</label>
							</div>
							<div class="relative">
								<input type="password" name="password" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
								<label class="pointer-events-none absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Password</label>
								<span class="absolute top-0 right-0 px-3 h-full grid place-items-center">
									<img src="assets/eye-close.svg" alt="eye-close" class="eye-icon w-5 h-5">
								</span>
							</div>
							<div class="relative">
								<input type="password" name="confirm_password" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
								<label class="pointer-events-none absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Confirm Password</label>
								<span class="absolute top-0 right-0 px-3 h-full grid place-items-center">
									<img src="assets/eye-close.svg" alt="eye-close" class="eye-icon w-5 h-5">
								</span>
							</div>
							<div class="flex items-center">
								<div class="flex">
									<input id="remember-me" name="remember-me" type="checkbox" class="pointer-events-none mr-2 rounded border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" />
								</div>
								<div>
									<label for="remember-me" class="text-sm">I accept the <a class="font-medium text-blue-500 decoration-2 hover:underline" href="terms.html">Terms and Conditions</a></label>
								</div>
							</div>
							<input type="submit" name="submit" value="Sign in" class="inline-flex items-center justify-center gap-2 rounded border border-transparent bg-primary-500 px-3 py-2 text-sm font-semibold text-white transition-all hover:bg-primary-700 focus:outline-none focus:ring focus:ring-blue-400 focus:ring-offset-2">
						</div>
					</div>
				</form>
			</div>
		</div>
	</main>
	<script src="../js/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$(".eye-icon").each(function(index) {
				let passInput = $("input[type='password']").eq(index);
				let eyeIcon = $(this);

				$(this).click(function() {
					if (passInput.attr("type") === "password") {
						passInput.attr("type", "text");
						eyeIcon.attr("src", "./assets/eye-open.svg");
					} else {
						passInput.attr("type", "password");
						eyeIcon.attr("src", "./assets/eye-close.svg");
					}
					console.log("Click");
				});
			});

			$("select > option").addClass("py-5");
		});
	</script>
</body>

</html>