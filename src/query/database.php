<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "wbs_db";
$conn = null;

try {
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    if (!$conn) {
        throw new Exception(mysqli_connect_error());
    }
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}

echo "<span style=\"color: green;\">Database connected!</span> <br>";
