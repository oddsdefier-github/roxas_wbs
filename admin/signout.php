<?php
include './database/connection.php';

session_start();

$admin_name = $_SESSION['admin_name'];
$role_db = $_SESSION['user_role'];

$activity = $admin_name . " ; Sign out";
$sign_out_log = "INSERT INTO `logs` (`id`, `user_activity`, `user_role`, `user_name`,`datetime`) VALUES (NULL, '$activity', '$role_db', '$admin_name',current_timestamp());";
$result = mysqli_query($conn, $sign_out_log);


$_SESSION = array();

session_destroy();


$response = array(
    "message" => "Session Cleared.",
);

echo json_encode($response);
exit();
