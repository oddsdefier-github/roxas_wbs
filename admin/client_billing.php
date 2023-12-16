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
    <title>Client Billing</title>
    <?php include './layouts/links.php'; ?>
</head>

<body class="flex h-screen w-screen overflow-hidden font-sans bg-gray-50">
    <?php include './components/modal/modal.php'; ?>
    <?php include './components/logout_loader.php'; ?>
    <?php include './layouts/sidebar.php'; ?>

    <section class="flex min-h-screen grow flex-col bg-gray-100">
        <?php include './components/alerts.php'; ?>
        <?php include './layouts/header.php'; ?>
        <div>
            <?php include './components/subheader.php'; ?>
        </div>
        <main class="relative flex flex-1 flex-col justify-start px-10 overflow-auto">
            <div class="flex flex-col gap-5 bg-white p-5 rounded-md shadow-md mb-10">
                <div>
                    <?php include './components/client_billing_main.php';?>
                </div>
            </div>
        </main>
    </section>

    <?php include './layouts/scripts.php'; ?>
    <?php include './layouts/date_range_scripts.php' ?>
    <script>
        $("#subheader-title").text("Clients Billing");
        $("#subheader-title").siblings("h5").text("View client billing history.")
        $("#subheader-title").parent("div").siblings("div").hide();
        const backEl = `<a href="billing.php" class="flex justify-start items-center gap-2 py-3">
        <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
        </svg></span> <span>Back</span></a>`;

        $("#subheader-title").siblings("h5").append(backEl);
    </script>
</body>

</html>
<?php
$conn->close();
?>