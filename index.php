<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Home</title>
	<link href="./dist/style.css" rel="stylesheet" />
	<link href="./dist/helpers.css" rel="stylesheet" />
</head>

<body class="relative flex min-h-screen flex-col overflow-clip bg-gray-50 font-inter">
	<style>
		/* * {
			outline: 1px solid red;
		} */
	</style>
	<section class="flex min-h-screen flex-col items-center justify-center bg-gray-50" id="main-content">

		<header class="container z-10">
			<nav class="flex h-16 items-center justify-between border-b border-gray-200">
				<div class="flex gap-3">
					<img src="./assets/quality.png" alt="water-logo" class="aspect-square pointer-events-none w-8 select-none" />
					<h1 class="font-semibold text-gray-600 text-2xl">wbs.</h1>
				</div>
				<div class="flex h-full items-center justify-center gap-5">
					<!-- <div class="mr-3 flex h-full items-center justify-center gap-3">
						<div class="group flex h-full items-center justify-center hover:border-b-2 hover:border-primary-600">
							<a href="" class="font-medium group-hover:text-primary-600">About</a>
						</div>
						<div class="group flex h-full items-center justify-center hover:border-b-2 hover:border-primary-600">
							<a href="" class="font-medium group-hover:text-primary-600">Profile</a>
						</div>
					</div> -->
					<a href="./authentication/signin.php" class="rounded-md border-2 border-primary-400 px-4 py-2 font-semibold text-primary-400 hover:border-primary-600 hover:text-primary-600 text-sm">Sign In</a>
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
							<h1 class="mb-3 font-bold text-primary-600 text-6xl flex">Water Billing System <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 animate-spin">
										<path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
										<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
									</svg>
								</span></h1>
							<p class="text-gray-400 text-lg">Track your customer's data at ease.</p>
						</div>
						<div class="my-auto flex cursor-pointer text-white">
							<a href="./authentication/signin.php" class="rounded-md bg-primary-700 px-4 py-3 font-medium hover:bg-primary-400 focus:ring-2 focus:ring-primary-50">Track Now!</a>
						</div>
					</div>
				</div>
			</div>
		</main>

	</section>
	<div class="absolute w-screen h-screen z-50 pointer-events-none flex justify-start items-end">
		<div class="max-w-sm absolute -bottom-16 -right-10">
			<img src="./water-utility.png" alt="water-utility">
		</div>
	</div>
	<!-- <div class="pointer-events-none absolute -bottom-20 -right-10 opacity-30">
		<img src="./assets/refreshing.svg" alt="svg" />
	</div> -->

</body>

</html>