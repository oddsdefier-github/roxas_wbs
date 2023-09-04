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

<body class="flex h-screen w-screen overflow-hidden font-inter">
    <div class="profile-modal absolute h-screen w-screen grid place-items-center pointer-events-none">
        <?php include './components/profile_img_modal.php' ?>
    </div>
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

    <style>
        /* * {
            outline: 1px dashed green;
        } */

        .client-update-modal-container {
            width: 100vw;
            height: 100vh;
            position: absolute;
            display: none;
            top: 0;
            left: 0;
        }

        .client-update-modal {
            position: relative;
            z-index: 1;
        }

        .client-update-modal::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(5px);
            z-index: -1;
        }
    </style>
    <div id="updateClientModal" class="client-update-modal-container absolute top-0 left-0 grid place-items-center h-full w-full ">
        <div class="client-update-modal">
            <?php include './components/update_client_modal.php' ?>
        </div>
    </div>

    <?php include './scripts/toggle.php' ?>
    <?php include './scripts/tables.php' ?>
    <?php include './scripts/scripts.php' ?>
    <?php include './scripts/modal.php' ?>

</body>

</html>

<?php
mysqli_close($conn);
?>