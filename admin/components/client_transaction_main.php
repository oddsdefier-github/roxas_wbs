<?php include './layouts/client_profile_nav.php'; ?>


<div class="mt-5">
    <div class="mb-5">
        <?php include 'table_utilities.php' ?>
    </div>
    <div class="shadow">
        <div>
            <div id="displayClientTransactionTable"></div>
        </div>
        <?php include 'pagination.php' ?>
    </div>
</div>

<script type="module" src="./assets/js/clientTransactionHandler.js"></script>