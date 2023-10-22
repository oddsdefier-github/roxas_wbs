<?php
// $db_server = "localhost";
// $db_user = "root";
// $db_pass = "";
// $db_name = "wbs_db";
// $conn = null;

// try {
//     $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
//     if (!$conn) {
//         throw new Exception(mysqli_connect_error());
//     }
// } catch (Exception $e) {
//     die("Connection failed: " . $e->getMessage());
// }

use Admin\Database\DatabaseConnection;

include 'config.php';
include 'Database.php';
$conn = new DatabaseConnection($host1, $username1, $password1, $database1);
$db2 = new DatabaseConnection($host2, $username2, $password2, $database2);
