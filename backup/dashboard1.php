<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Home</title>
		<link href="../dist/style.css" rel="stylesheet" />
		<link href="../dist/helpers.css" rel="stylesheet" />
		<style>
			/* Add your custom styles here */
		</style>
	</head>

	<body class="flex h-screen w-screen overflow-clip bg-gray-200 font-inter">
		<!-- <div>
			<div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 transform">
				<div class="aspect-square w-96 bg-slate-800"></div>
			</div>
		</div> -->
		<?php
		include 'sidebar.php';
		?>
		<section class="flex min-h-screen grow flex-col" id="main-content">
			<header class="z-10">
				<nav class="border-b border-gray-300">
					<div class="nav-content flex h-16 items-center justify-between px-8">
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
					</div>
				</nav>
			</header>

			<main class="no-scrollbar flex-1 overflow-y-scroll px-8">
				<div class="page-header block justify-between py-5 sm:flex">
					<div>
						<h3 class="font-medium text-gray-800 text-xl hover:text-gray-900">Dashboard</h3>
					</div>
					<ol class="flex min-w-0 items-center whitespace-nowrap">
						<li class="flex text-sm">
							<a class="flex items-center truncate font-semibold text-indigo-400" href="javascript:void(0);"> Main </a>
							<svg aria-hidden="true" class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
							</svg>
						</li>
						<li class="hover:text-primary text-gray-500 text-sm" aria-current="page">Dashboard</li>
					</ol>
				</div>
				<div class="grid grid-cols-12 flex-wrap gap-7">
					<div class="col-span-3 rounded bg-white py-2 shadow-md">
						<div class="h-24">Total Clients</div>
					</div>
					<div class="col-span-3 rounded bg-white py-2 shadow-md">
						<div class="h-24">Total Consumption</div>
					</div>
					<div class="col-span-3 rounded bg-white py-2 shadow-md">
						<div class="h-24">Total Revenue</div>
					</div>
					<div class="col-span-3 rounded bg-white py-2 shadow-md">
						<div class="h-24">Average Usage Clients</div>
					</div>
				</div>
				<div class="my-5 grid h-96 grid-cols-12 gap-7">
					<div class="col-span-3 rounded bg-white py-2 shadow-md"></div>
					<div class="col-span-6 rounded-md bg-white py-2 shadow-md"></div>
					<div class="col-span-3 rounded bg-white py-2 shadow-md"></div>
				</div>
				<div class="my-5 grid h-96 grid-cols-12 gap-7">
					<div class="col-span-12 rounded-md bg-white py-2 shadow-md"></div>
				</div>
			</main>
		</section>
		<script src="./js/dashboard.js"></script>
		<script></script>
	</body>
</html>
