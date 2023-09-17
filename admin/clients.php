<?php
include './database/connection.php';
include './database/query_all.php';

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
    <title>Clients</title>
    <?php include './components/links.php'; ?>

</head>
<style>
    /* * {
        outline: 1px solid green;
    }

    main>* div {
        outline: 1px solid red;
    } */
</style>

<body class="flex h-screen w-screen overflow-hidden font-inter bg-gray-50">
    <?php include './components/modal/modal.php'; ?>
    <?php include './components/signout_loader.php'; ?>
    <?php include './components/sidebar.php'; ?>

    <section class="flex min-h-screen grow flex-col bg-gray-100" id="main-content">
        <?php include './components/alerts.php'; ?>
        <?php include './components/header.php'; ?>
        <div>
            <?php include './components/subheader.php'; ?>
            <?php include './components/table_search.php'; ?>
        </div>
        <main class="relative flex flex-1 flex-col justify-start px-10 overflow-auto">
            <div class="flex flex-col gap-5 bg-white p-5 rounded-md shadow-md mb-10">
                <?php include './components/clients_table_utilities.php'; ?>
                <?php include './components/clients_main.php'; ?>
            </div>
        </main>
    </section>

    <?php include './components/modal/update_client_modal.php'; ?>
    <?php include './components/modal/add_client_modal.php'; ?>


    <script src="../js/jquery.min.js"></script>
    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
    <script src="../node_modules/flowbite/dist/datepicker.js"></script>

    <script src="./js/sidebar.js"></script>
    <script src="./js/popup.js"></script>
</body>

</html>
<?php
mysqli_close($conn);
?>