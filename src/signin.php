<?php
include 'database.php';

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
	<style>
		/* Add your custom styles here */
	</style>
</head>

<body class="flex min-h-screen flex-col bg-gray-200 font-inter">

	<main class="flex flex-1 items-center justify-center">
		<div class="flex w-full max-w-sm flex-col gap-7">
			<div class="flex w-full items-center justify-center">
				<img src="./assets/quality.png" alt="water-logo" class="aspect-square pointer-events-none w-14 select-none" />
			</div>
			<form action="signin.php" method="POST" class="w-full max-w-sm bg-white px-7 py-6">
				<div class="my-5 text-center">
					<h1 class="block text-3xl font-bold text-gray-800">Sign in</h1>
					<p class="mt-3 text-sm text-gray-600">
						Already have an account?
						<a class="font-medium text-blue-500 decoration-2 hover:underline" href="signup.php"> Sign up here </a>
					</p>
				</div>
				<div>
					<div class="grid gap-y-4">
						<div>
							<label for="name" class="mb-2 block text-sm text-gray-500">Email Address</label>
							<input type="text" name="email" class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:border-2 focus:border-indigo-500 focus:outline-none" />
						</div>
						<div>
							<label for="name" class="mb-2 block text-sm text-gray-500">Password</label>
							<input type="password" name="password" class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:border-2 focus:border-indigo-500 focus:outline-none" />
						</div>

						<input type="submit" name="submit" value="Sign in" class="inline-flex items-center justify-center gap-2 rounded border border-transparent bg-primary-50 px-3 py-2 text-sm font-semibold text-white transition-all hover:bg-primary-100 focus:outline-none focus:ring focus:ring-blue-400 focus:ring-offset-2">
					</div>
				</div>
			</form>
		</div>
	</main>
</body>

</html>
<?php
if (isset($_POST["submit"])) {
	$email = $_POST["email"];
	$password = $_POST["password"];

	$sql = "SELECT * FROM admin WHERE `email` = '$email'";
	$result = mysqli_query($conn, $sql);
	$rows = mysqli_fetch_assoc($result);
	$email_db = $rows["email"];
	$password_db = $rows["password"];

	if ($email == $email_db && $password == $password_db) {
		echo "<script>alert('Success')</script>";
		header("Location: dashboard.php");
	} else {
		echo "<script>alert('Invalid Credentials')</script>";
	}
}
?>