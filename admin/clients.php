<?php
include './connection/database.php';
include './connection/query_all.php';

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
<style>

</style>

<body class="flex h-screen w-screen overflow-hidden font-inter">

    <?php include './components/modal/signout_modal.php' ?>
    <?php include './components/modal/delete_client_modal.php' ?>
    <?php include './components/modal/profile_img_modal.php' ?>
    <?php include './components/sidebar.php'; ?>

    <section class="flex min-h-screen grow flex-col" id="main-content">
        <?php include './components/header.php' ?>
        <main class="relative isolate flex flex-1 flex-col items-center justify-center overflow-auto mb-10">
            <div class="relative overflow-x-auto">

                <div>
                    <?php include './components/clients_table.php' ?>
                </div>
            </div>
        </main>
    </section>


    <?php include './components/modal/update_client_modal.php' ?>
    <?php include './scripts/toggle.php' ?>
    <?php include './scripts/tables.php' ?>
    <?php include './scripts/modal.php' ?>
    <?php include './scripts/scripts.php' ?>


</body>

</html>
<?php
mysqli_close($conn);
?>