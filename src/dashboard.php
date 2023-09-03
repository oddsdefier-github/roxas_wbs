<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Home</title>
	<?php include './components/links.php'; ?>
</head>

<body class="flex h-screen w-screen overflow-clip font-inter">
	<?php include './components/sidebar.php' ?>
	<section class="flex min-h-screen grow flex-col" id="main-content">
		<?php include './components/header.php' ?>

		<main class="relative isolate flex flex-1 flex-col items-center justify-center">
			<div class="absolute inset-x-0 -top-40 -z-40 transform-gpu overflow-hidden blur-3xl">
				<div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[35deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
			</div>
			<div class="flex max-w-5xl p-5">
				<div class="flex items-center justify-center">
					<div class="flex flex-col items-center justify-center">
						<div class="mb-5 text-center">
							<h1 class="mb-3 font-bold text-6xl">Water Billing System</h1>
							<p class="text-gray-400 text-lg">Track your customer's data at ease.</p>
						</div>
						<div class="my-auto flex cursor-pointer text-white">
							<a href="signup.html" class="rounded-md bg-primary-600 px-4 py-3 font-medium hover:bg-primary-100 focus:ring-2 focus:ring-primary-50">Track Now!</a>
						</div>
					</div>
				</div>
			</div>
		</main>

	</section>
	<div class="pointer-events-none absolute -bottom-20 -right-10 opacity-30">
		<img src="./assets/refreshing.svg" alt="svg" />
	</div>
	<?php include './scripts/toggle.php' ?>
</body>

</html>