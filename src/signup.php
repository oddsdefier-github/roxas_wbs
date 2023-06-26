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
						<div class="grid gap-y-4">
							<div>
								<label for="name" class="mb-2 block text-sm text-gray-500">Full Name</label>
								<input type="text" name="admin_name" class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:border-2 focus:border-indigo-500 focus:outline-none" />
							</div>
							<!-- <div>
									<label class="mb-2 block text-sm text-gray-500">Address</label>
									<select class="w-full rounded border border-gray-300 bg-gray-50 px-3 py-3 text-sm focus:border-2 focus:border-indigo-500 focus:outline-none">
										<option selected class="text-gray-600">Choose your address</option>
										<option>San Aquilino</option>
										<option>Odiong</option>
										<option>San Mariano</option>
										<option>Victoria</option>
										<option>Victoria</option>
										<option>Victoria</option>
										<option>Victoria</option>
										<option>Victoria</option>
										<option>Victoria</option>
										<option>Victoria</option>
										<option>Victoria</option>
										<option>Victoria</option>
										<option>Victoria</option>
									</select>
								</div> -->

							<div>
								<label for="name" class="mb-2 block text-sm text-gray-500">Email Address</label>
								<input type="text" name="email" class="w-full rounded-sm border border-gray-300 focus:border-2 focus:border-indigo-500 focus:outline-none" />
							</div>
							<div>
								<label for="name" class="mb-2 block text-sm text-gray-500">Password</label>
								<input type="password" name="password" class="w-full rounded-sm border border-gray-300 focus:border-2 focus:border-indigo-500 focus:outline-none" />
							</div>
							<div>
								<label for="name" class="mb-2 block text-sm text-gray-500">Confirm Password</label>
								<input type="password" name="confirm_password" class="w-full rounded-sm border border-gray-300 focus:border-2 focus:border-indigo-500 focus:outline-none" />
							</div>
							<div class="flex items-center">
								<div class="flex">
									<input id="remember-me" name="remember-me" type="checkbox" class="pointer-events-none mr-2 rounded border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" />
								</div>
								<div>
									<label for="remember-me" class="text-sm">I accept the <a class="font-medium text-blue-500 decoration-2 hover:underline" href="terms.html">Terms and Conditions</a></label>
								</div>
							</div>

							<input type="submit" name="submit" value="Sign up" class="inline-flex items-center justify-center gap-2 rounded border border-transparent bg-primary-50 px-3 py-2 text-sm font-semibold text-white transition-all hover:bg-primary-100 focus:outline-none focus:ring focus:ring-blue-400 focus:ring-offset-2">
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