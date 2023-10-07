<?php

include './database/connection.php';

include './auth_guard.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Clients Application</title>
    <?php include './layouts/links.php'; ?>
</head>

<body class="flex h-screen w-screen overflow-hidden font-inter bg-gray-50">
    <?php include './components/alerts.php'; ?>
    <?php include './components/notification.php'; ?>
    <?php include './components/modal/modal.php'; ?>
    <?php include './components/logout_loader.php'; ?>
    <?php include './layouts/sidebar.php'; ?>

    <section class="flex min-h-screen grow flex-col bg-white">

        <?php include './layouts/header.php'; ?>
        <?php include './components/subheader.php'; ?>
        <main class="relative flex flex-1 flex-col justify-start overflow-auto">
            <div class="flex flex-col gap-5">
                <?php include './components/clients_application_main.php'; ?>
            </div>
        </main>
    </section>

    <?php include './layouts/scripts.php'; ?>
    <script src="./assets/js/application_validate.js"></script>
    <script src="./assets/js/client_application.js"></script>
    <script>
        $("#subheader-title").text("Clients Application");
        $("#subheader-title").siblings("h5").text("Manage, Evaluate, Approve, or Decline Client Applications.")
        $("#subheader-title").parent("div").siblings("div").hide()
    </script>
</body>

</html>
<?php
$conn->close();
?>