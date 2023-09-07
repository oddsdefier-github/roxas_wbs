<?php
include './connection/database.php';
include './connection/query_all.php';

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
    <?php include './components/links.php' ?>

</head>

<body class="flex h-screen w-screen overflow-hidden font-inter">
    <?php include './components/modal/signout_modal.php' ?>
    <?php include './components/modal/delete_client_modal.php' ?>
    <?php include './components/modal/profile_img_modal.php' ?>
    <?php include './components/sidebar.php'; ?>

    <section class="flex min-h-screen grow flex-col" id="main-content">
        <?php include './components/alerts.php'; ?>
        <?php include './components/header.php' ?>
        <?php include './components/table_search.php' ?>
        <main class="relative isolate flex flex-1 flex-col items-center justify-start overflow-auto mb-10">
            <div class="relative overflow-x-auto">
                <?php include './components/clients_view.php' ?>
            </div>
        </main>
    </section>

    <?php include './components/modal/update_client_modal.php' ?>
    <?php include './components/modal/add_client_modal.php' ?>
    <?php include './scripts/toggle.php' ?>
    <?php include './scripts/modal.php' ?>
    <?php include './scripts/scripts.php' ?>

    <script src="../js/jquery.min.js"></script>
</body>

</html>
<?php
mysqli_close($conn);
?>