<?php
include './database/connection.php';

if (isset($_POST['deleteSend'])) {
    $uniqueId = $_POST['deleteSend'];


    $select_client = "SELECT client_name FROM clients WHERE id = '$uniqueId'";
    $select_client_result = mysqli_query($conn, $select_client);

    if ($row = mysqli_fetch_assoc($select_client_result)) {
        $client = $row['client_name'];
    }

    $sql = "DELETE FROM clients WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $uniqueId);

    if (mysqli_stmt_execute($stmt)) {
        echo "Record deleted successfully.";
        session_start();

        $admin_name = $_SESSION['admin_name'];
        $role_db = $_SESSION['user_role'];

        $activity = "Deleted " . $client;
        $delete_client_log = "INSERT INTO `logs` (`id`, `user_activity`, `user_role`, `user_name`,`datetime`) VALUES (NULL, '$activity', '$role_db', '$admin_name',current_timestamp());";
        $update_result = mysqli_query($conn, $delete_client_log);
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
