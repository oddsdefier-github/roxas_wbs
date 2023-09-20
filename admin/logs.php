<?php
include './database/connection.php';

session_start();
if (!isset($_SESSION['loggedin'])) {

    echo '<script>alert("Please log in first!");</script>';
    echo '<script>window.location.href = "../authentication/signin.php";</script>';
    exit;
}

if ($_SESSION['user_role'] != "Admin") {
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
    <title>Logs</title>
    <?php include './layouts/links.php'; ?>
</head>

<body class="flex h-screen w-screen overflow-hidden font-inter bg-gray-50">
    <?php include './components/modal/modal.php'; ?>
    <?php include './components/signout_loader.php'; ?>
    <?php include './layouts/sidebar.php'; ?>

    <section class="flex min-h-screen grow flex-col bg-gray-100">
        <?php include './layouts/header.php'; ?>
        <div>
            <?php include './components/subheader.php'; ?>
        </div>
        <main class="relative flex flex-1 flex-col justify-start px-10 overflow-auto">
            <div class="flex flex-col gap-5 bg-white p-5 rounded-md shadow-md mb-10">
                <?php include './components/logs_table_utilities.php'; ?>
                <?php include './components/logs_main.php'; ?>
            </div>
        </main>
    </section>

    <?php include './layouts/scripts.php'; ?>
    <script>
        $("#subheader-title").text("Logs")
    </script>
</body>

</html>