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
    <title>Payments</title>
    <?php include './layouts/links.php'; ?>
</head>

<body class="flex h-screen w-screen overflow-hidden font-inter bg-gray-50">
    <?php include './components/alerts.php'; ?>
    <?php include './components/modal/acceptBillingPaymentModal.php'; ?>
    <?php include './components/modal/qrBillPaymentModal.php'; ?>
    <?php include './components/modal/signOutModal.php'; ?>
    <?php include './components/logout_loader.php'; ?>
    <?php include './layouts/sidebar.php'; ?>

    <section class="flex min-h-screen grow flex-col bg-white">
        <?php include './layouts/header.php'; ?>
        <?php include './components/subheader.php'; ?>
        <main class="relative flex flex-1 flex-col justify-start overflow-auto">
            <div class="flex flex-col gap-5">
                <?php include './components/billing_payments_main.php'; ?>
            </div>
        </main>
    </section>
    <?php include './layouts/scripts.php'; ?>

    <script src="./assets/libs/html5-qrcode/html5-qrcode.min.js"></script>
    <script type="module" src="./assets/js/acceptBillingPayment.js"></script>
    <script>
        $("#subheader-title").text("Payments");
        $("#subheader-title").siblings("h5").text("View, and Manage Payments.")
    </script>
</body>

</html>
<?php
$conn->close();
?>