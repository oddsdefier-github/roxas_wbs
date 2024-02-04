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
    <title>Verify</title>
    <?php include './layouts/links.php'; ?>
</head>

<body class="flex h-screen w-screen overflow-hidden font-sans bg-gray-50">
    <?php include './components/alerts.php'; ?>
    <?php include './components/modal/modal.php'; ?>
    <?php include './components/logout_loader.php'; ?>
    <?php include './layouts/sidebar.php'; ?>

    <section class="flex min-h-screen grow flex-col bg-white">
        <?php include './layouts/header.php'; ?>
        <?php include './components/subheader.php'; ?>
        <main class="relative flex flex-1 flex-col justify-start overflow-auto">
            <div class="flex flex-col gap-5">
                <?php include './components/verify_meter_reading_main.php'; ?>
            </div>
        </main>
    </section>


    <?php include './components/modal/sending_email_modal.php'; ?>
    <?php include './components/modal/verify_reading_data_modal.php'; ?>

    <?php include './layouts/scripts.php'; ?>
    <script type="module" src="./assets/js/VerifyHandler.js"></script>
    <script type="module" src="./assets/js/resetGeneratedBillingLogs.js"></script>
    <script>
        $("#subheader-title").text("Verify Billing Data");
        $("#subheader-title").siblings("h5").text("Handle, Assess, or Verify Billing Data.")
        $("#subheader-title").parent("div").siblings("div").hide()
    </script>
</body>

</html>
<?php
$conn->close();
?>