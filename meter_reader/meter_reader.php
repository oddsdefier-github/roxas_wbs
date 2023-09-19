<?php
session_start();


if (!isset($_SESSION['loggedin'])) {

    echo '<script>alert("Please log in first!");</script>';
    echo '<script>window.location.href = "../authentication/signin.php";</script>';
    exit;
}

if ($_SESSION['user_role'] != "Meter Reader") {
    echo '<script>alert("You\'re not allowed here!");</script>';
    $_SESSION = array();
    session_unset();
    session_destroy();
    echo '<script>window.location.href = "../authentication/signin.php";</script>';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Meter Reader</title>
    <?php include './components/links.php'; ?>

</head>
<!-- <style>
    * {
        outline: 1px solid green;
    }

    main>* div {
        outline: 1px solid red;
    }
</style> -->

<body class="flex min-h-screen font-inter bg-gray-50">

    <?php include './components/modal/signout_modal.php'; ?>
    <?php include './components/signout_loader.php'; ?>
    <?php include './components/sidebar.php'; ?>

    <main class="flex-grow flex-1 mb-10 ">
        <header class="px-5 mx-auto">
            <?php include './components/header.php'; ?>
            <?php include './components/subheader.php'; ?>
        </header>

        <div class="px-5 mx-auto overflow-auto">
            <section class="bg-white p-5 rounded-md shadow-md">
                <?php include './components/meter_table_utilities.php'; ?>
                <?php include './components/meter_reader_main.php'; ?>
            </section>
        </div>
    </main>

    <script src="../js/jquery.min.js"></script>
    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>

    <script src="./js/popup.js"></script>
    <script src="./js/sidebar.js"></script>
</body>