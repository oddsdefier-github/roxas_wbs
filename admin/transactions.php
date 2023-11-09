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
    <title>Transaction</title>
    <?php include './layouts/links.php'; ?>
</head>

<body class="flex h-screen w-screen overflow-hidden font-inter bg-gray-50">
    <?php include './components/alerts.php'; ?>
    <?php include './components/modal/modal.php'; ?>
    <?php include './components/logout_loader.php'; ?>
    <?php include './layouts/sidebar.php'; ?>

    <section class="flex min-h-screen grow flex-col bg-white">
        <?php include './layouts/header.php'; ?>
        <?php include './components/subheader.php'; ?>
        <main class="relative flex flex-1 flex-col justify-start overflow-auto">
            <div class="flex flex-col gap-5">
                <?php include './components/transactions_main.php'; ?>
            </div>
        </main>
        <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
        </div>

    </section>
    <?php include './layouts/scripts.php'; ?>
    <?php include './layouts/date_range_scripts.php' ?>

    <script>
        $("#subheader-title").text("Transaction");
        $("#subheader-title").siblings("h5").text("Manage, Update, or Delete Client.");
    </script>
</body>

</html>
<?php
$conn->close();
?>