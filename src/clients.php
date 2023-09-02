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
    <?php include './components/sidebar.php'; ?>
    <section class="flex min-h-screen grow flex-col" id="main-content">
        <?php include './components/header.php' ?>

        <main class="relative isolate flex flex-1 flex-col items-center justify-center overflow-auto mb-10">
            <div class="relative overflow-x-auto">

                <?php include './components/clients_table.php'; ?>

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