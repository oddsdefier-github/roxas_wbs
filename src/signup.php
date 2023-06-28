<?php
include 'database.php';

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
	<style>
		/* Add your custom styles here */
	</style>
</head>

<body class="flex min-h-screen flex-col bg-primary-600 font-inter">
	<!-- <header class="h-16">
			<nav class="flex h-full items-center justify-between">
				<div>Logo</div>
				<div>
					<a href=""></a>
					<a href=""></a>
					<a href=""></a>
				</div>
			</nav>
		</header> -->

	<main class="flex flex-1 items-center justify-center">
		<div class="flex w-full max-w-sm flex-col gap-7">
			<div class="flex w-full items-center justify-center">
				<img src="./assets/quality.png" alt="water-logo" class="aspect-square pointer-events-none w-14 select-none brightness-0 invert filter" />
			</div>
			<div class="shadow-lg">
				<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" class="w-full bg-white px-7 py-6">
					<div class="my-5 text-center">
						<h1 class="block text-3xl font-bold text-gray-800">Sign up</h1>
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
								<span class="show-toggle absolute top-0 grid place-items-center right-2 h-full appearance-none focus:outline-none group">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-gray-500 w-5 h-5 group-hover:stroke-primary-100 eye-open">
										<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
										<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
									</svg>
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-gray-500 hidden w-5 h-5 group-hover:stroke-primary-100 eye-close">
										<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
									</svg>
								</span>
							</div>
							<div class="relative">
								<input type="password" name="confirm_password" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
								<label class="pointer-events-none absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Confirm Password</label>
								<span class="show-toggle absolute top-0 grid place-items-center right-2 h-full appearance-none focus:outline-none group">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-gray-500 w-5 h-5 group-hover:stroke-primary-100 eye-open">
										<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
										<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
									</svg>
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-gray-500 hidden w-5 h-5 group-hover:stroke-primary-100 eye-close">
										<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
									</svg>
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
							<input type="submit" name="submit" value="Sign in" class="inline-flex items-center justify-center gap-2 rounded border border-transparent bg-primary-50 px-3 py-2 text-sm font-semibold text-white transition-all hover:bg-primary-100 focus:outline-none focus:ring focus:ring-blue-400 focus:ring-offset-2">
						</div>
					</div>
				</form>
			</div>
		</div>
	</main>
</body>

</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["submit"])) {
		$admin_name = $_POST["admin_name"];
		$email = $_POST["email"];
		$password = $_POST["password"];
		$confirm_password = $_POST["confirm_password"];
		var_dump($confirm_password);
		if ($password == $confirm_password) {

			try {
				mysqli_query($conn, $sql);
				echo "<script>alert('Admin Registration Successful!')</script>";
			} catch (mysqli_sql_exception $e) {
				echo "Exception occurred: " . $e->getMessage();
			}
		}
	}
}
mysqli_close($conn);
?>