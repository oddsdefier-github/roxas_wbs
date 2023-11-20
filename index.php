<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Home</title>
	<link href="./assets/css/style.css" rel="stylesheet" />
</head>

<body class="relative flex min-h-screen flex-col overflow-clip bg-gray-50 font-sans">
	<style>
		/* * {
			outline: 1px solid red;
		} */
	</style>
	<section class="flex min-h-screen flex-col items-center justify-center bg-gray-50" id="main-content">

		<header class="container z-10">
			<nav class="flex h-16 items-center justify-between border-b border-gray-200">
				<div class="flex gap-2">
					<img src="./assets/quality.png" alt="water-logo" class="aspect-square pointer-events-none w-8 select-none" />
					<h1 class="font-semibold text-gray-600 text-2xl">wbs.</h1>
				</div>
				<div class="flex h-full items-center justify-center gap-5">
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
							<style>
								.continue_btn {
									cursor: pointer;
									font-weight: 600;
									transition: all .2s;
									padding: 10px 20px;
									border-radius: 100px;
									background: #4338ca;
									border: 1px solid transparent;
									display: flex;
									align-items: center;
									font-size: 15px;
								}

								.continue_btn:hover {
									background: #818cf8;
								}

								.continue_btn>svg {
									width: 34px;
									margin-left: 10px;
									transition: transform .3s ease-in-out;
								}

								.continue_btn:hover svg {
									transform: translateX(5px);
								}

								.continue_btn:active {
									transform: scale(0.95);
								}
							</style>
							<a href="./authentication/signin.php" class="continue_btn">
								<span>Continue</span>
								<svg width="34" height="34" viewBox="0 0 74 74" fill="none" xmlns="http://www.w3.org/2000/svg">
									<circle cx="37" cy="37" r="35.5" stroke="white" stroke-width="3"></circle>
									<path d="M25 35.5C24.1716 35.5 23.5 36.1716 23.5 37C23.5 37.8284 24.1716 38.5 25 38.5V35.5ZM49.0607 38.0607C49.6464 37.4749 49.6464 36.5251 49.0607 35.9393L39.5147 26.3934C38.9289 25.8076 37.9792 25.8076 37.3934 26.3934C36.8076 26.9792 36.8076 27.9289 37.3934 28.5147L45.8787 37L37.3934 45.4853C36.8076 46.0711 36.8076 47.0208 37.3934 47.6066C37.9792 48.1924 38.9289 48.1924 39.5147 47.6066L49.0607 38.0607ZM25 38.5L48 38.5V35.5L25 35.5V38.5Z" fill="white"></path>
								</svg>
							</a>


							<!-- <a href="./authentication/signin.php" class="rounded-md bg-primary-700 px-4 py-3 font-medium hover:bg-primary-400 focus:ring-2 focus:ring-primary-50">Track Now!</a> -->
						</div>
					</div>
				</div>
			</div>
		</main>

	</section>
	<div class="absolute w-screen h-screen z-50 pointer-events-none flex justify-start items-end">
		<div class="max-w-sm absolute -bottom-16 -right-10">
			<img src="./water-utility.png" alt="water-utility" loading="lazy">
		</div>
	</div>
	<!-- <div class="pointer-events-none absolute -bottom-20 -right-10 opacity-30">
		<img src="./assets/refreshing.svg" alt="svg" />
	</div> -->

</body>

</html>