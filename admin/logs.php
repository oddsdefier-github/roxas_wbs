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

<body class="flex h-screen w-screen overflow-clip font-inter bg-gray-100">
    <?php include './components/modal/modal.php'; ?>
    <?php include './components/signout_loader.php'; ?>
    <?php include './components/sidebar.php' ?>

    <section class="flex min-h-screen grow flex-col" id="main-content">
        <?php include './components/header.php' ?>
        <?php include './components/subheader.php'; ?>
        <main class="mt-5 relative flex flex-1 flex-col justify-start px-10 overflow-auto">
            <div class="flex flex-col gap-5 bg-white p-5 rounded-md shadow-md mb-10">
                <?php include './components/logs_table_utilities.php'; ?>
                <?php include './components/logs_main.php'; ?>
            </div>
        </main>

    </section>
    <script src="../js/jquery.min.js"></script>
    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>

    <script src="./js/sidebar.js"></script>
    <script src="./js/popup.js"></script>

    <script>
        $("#subheader-title").text("Logs")
    </script>
</body>

</html>