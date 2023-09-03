<?php
include './query/database.php';
include './query/query_all.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <?php include './components/links.php'; ?>
</head>

<body class="flex h-screen w-screen overflow-clip font-inter">
    <div class="absolute h-screen w-screen grid place-items-center pointer-events-none">
        <?php include './components/profile_img_modal.php' ?>
    </div>
    <?php include './components/sidebar.php'; ?>
    <section class="flex min-h-screen grow flex-col" id="main-content">
        <?php include './components/header.php' ?>
        <main class="relative isolate flex flex-1 flex-col items-center justify-center overflow-auto mb-10">
            <div class="relative overflow-x-auto">

                <?php include './components/clients_table.php' ?>
                <div class="absolute top-0 left-0 right-0 inset-0">
                    <?php include './components/update_client_modal.php' ?>
                </div>
            </div>
        </main>
    </section>

    <?php include './scripts/toggle.php' ?>
    <?php include './scripts/tables.php' ?>
    <?php include './scripts/scripts.php' ?>

</body>

</html>

<?php
mysqli_close($conn);
?>