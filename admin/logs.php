<?php
include './database/connection.php';

session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Logs</title>
    <?php include './components/links.php'; ?>
</head>

<body class="flex h-screen w-screen overflow-clip font-inter">
    <?php include './components/modal/modal.php'; ?>
    <?php include './components/signout_loader.php'; ?>
    <?php include './components/sidebar.php' ?>

    <section class="flex min-h-screen grow flex-col" id="main-content">
        <?php include './components/header.php' ?>
        <div>
            <style>
                ::-webkit-scrollbar {
                    width: 0.5em;
                    background-color: transparent;
                }

                /* Hide scrollbar track */
                ::-webkit-scrollbar-track {
                    background-color: transparent;
                }

                /* Hide scrollbar handle */
                ::-webkit-scrollbar-thumb {
                    background-color: transparent;
                    border: none;
                }
            </style>
            <nav class=" border-b border-gray-50  py-5 flex justify-center items-center ">
                <div class="container px-16">

                    <div class="flex justify-center">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="text" id="table-search" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for admin">
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <main class="relative isolate flex flex-1 flex-col items-center justify-start overflow-scroll">
            <div class="relative overflow-x-auto">
                <?php include './components/logs_main.php'; ?>
            </div>
        </main>

    </section>
    <script src="../js/jquery.min.js"></script>
    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>

    <script src="./js/sidebar.js"></script>
    <script src="./js/popup.js"></script>
</body>

</html>