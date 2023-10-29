<?php
include './database/connection.php';

session_start();
$currentDateTime = date("YmdHis");

$user_name = $_SESSION['user_name'];
$role_db = $_SESSION['user_role'];

$name = explode(" ", $user_name);

$initials_name = "";
foreach ($name as $n) {
    $initials_name .= strtoupper(substr($n, 0, 1));
}

$role = $role_db[0];
$initials_role_db = strtoupper(substr($role, 0, 1));

$log_id = "SO" . $initials_role_db . $initials_name . $currentDateTime;

$activity = "Sign out";
$description = $user_name . " has been signed out.";

$sign_out_log = "INSERT INTO `logs` (`id`, `log_id`, `user_role`, `user_name`, `user_activity`, `description`, `date`, `time`, `datetime`) VALUES (NULL, '$log_id', '$role_db', '$user_name', '$activity', '$description', CURRENT_DATE, CURRENT_TIME, CURRENT_TIMESTAMP);";

$result = $conn->query($sign_out_log);

$_SESSION = array();

$response = array(
    "message" => "Session Cleared.",
    "user" => $user_name
);

echo json_encode($response);

session_destroy();
exit();
