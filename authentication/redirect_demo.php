<?php

include 'database/connection.php';

session_start();

$_SESSION['loggedin'] = true;
$_SESSION['user_role'] = "Admin";
$_SESSION['admin_name'] = "ADMIN_NO_LOGIN";

echo '<script>window.location.href = "../admin/index.php";</script>';
