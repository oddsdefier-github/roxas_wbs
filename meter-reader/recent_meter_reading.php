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
    <title>Recent Meter Reading</title>
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
                <?php include './components/recent_meter_reading_main.php'; ?>
            </div>
        </main>
    </section>


    <?php include './layouts/scripts.php'; ?>
    <script>
        $("#subheader-title").text("Recent Meter Reading Data");
        $("#subheader-title").siblings("h5").text("Handle, Assess, or View Recent Meter Reading Data.")
        $("#subheader-title").parent("div").siblings("div").hide()
    </script>
</body>

</html>
<?php
$conn->close();
?>