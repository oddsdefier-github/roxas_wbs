<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Home</title>
		<link href="../dist/style.css" rel="stylesheet" />
		<link href="../dist/helpers.css" rel="stylesheet" />
	</head>

	<body class="flex h-screen w-screen overflow-clip font-inter">
		<?php 
		include 'sidebar.php'
		?>
		<section class="flex min-h-screen grow flex-col" id="main-content">
			<header class="z-10">
				<nav class="flex h-16 items-center justify-between border-b border-gray-200 px-20">
					<div>
						<button id="toggle-button" class="appearance-none p-1 focus:outline-none">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="h-5 w-5 stroke-gray-800" id="arrow-left">
								<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
							</svg>
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="hidden h-5 w-5 stroke-gray-800" id="arrow-right">
								<path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
							</svg>
						</button>
					</div>
					<div class="flex h-full items-center justify-center gap-5">
						<div class="mr-3 flex h-full items-center justify-center gap-3">
							<div class="group flex h-full items-center justify-center hover:border-b-2 hover:border-primary-600">
								<a href="" class="font-medium group-hover:text-primary-600">About</a>
							</div>
							<div class="group flex h-full items-center justify-center hover:border-b-2 hover:border-primary-600">
								<a href="index.html" class="font-medium group-hover:text-primary-600">Home</a>
							</div>
						</div>
						<a href="signin.html" class="rounded-md border-2 border-primary-100 px-4 py-2 font-semibold text-primary-100 hover:border-primary-600 hover:text-primary-600">Sign In</a>
					</div>
				</nav>
			</header>

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
		<script>
			const toggleButton = document.getElementById("toggle-button");
			const sidebar = document.getElementById("sidebar");
			const arrowRight = document.getElementById("arrow-right");
			const arrowLeft = document.getElementById("arrow-left");
			const arrowDown = document.getElementById("arrow-down");
			const arrowUp = document.getElementById("arrow-up");
			const tabMenu = document.getElementById("tab-menu");
			const tabSubMenu = document.getElementById("tab-submenu");

			toggleButton.addEventListener("click", () => {
				sidebar.classList.toggle("hidden");
				arrowLeft.classList.toggle("hidden");
				arrowRight.classList.toggle("hidden");
			});
			tabMenu.addEventListener("click", () => {
				event.preventDefault();
				tabSubMenu.classList.toggle("hidden");
				arrowDown.classList.toggle("hidden");
				arrowUp.classList.toggle("hidden");
			});
		</script>
	</body>
</html>
