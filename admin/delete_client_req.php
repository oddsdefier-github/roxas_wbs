<?php
include './database/connection.php';



if (isset($_POST['deleteSend'])) {

    $uniqueId = $_POST['deleteSend'];

    $select_client = "SELECT client_name FROM clients WHERE id = '$uniqueId'";
    $select_client_result = mysqli_query($conn, $select_client);

    if ($row = mysqli_fetch_assoc($select_client_result)) {
        $client = $row['client_name'];
    }

    $backup_client = "INSERT INTO clients_archive SELECT * FROM clients WHERE id = $uniqueId;";
    $backup_result = mysqli_query($conn, $backup_client);


    $sql = "DELETE FROM clients WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $uniqueId);

    if (mysqli_stmt_execute($stmt)) {


        session_start();

        $currentDateTime = date("YmdHis");

        $admin_name = $_SESSION['admin_name'];
        $role_db = $_SESSION['user_role'];

        $name = explode(" ", $admin_name);

        $initials_name = "";
        foreach ($name as $n) {
            $initials_name .= strtoupper(substr($n, 0, 1));
        }

        $role = $role_db[0];
        $initials_role_db = strtoupper(substr($role, 0, 1));

        $log_id = "D" . $initials_role_db . $initials_name . $currentDateTime;


        $delete_result = array(
            "del_client" => $client,
            "log_id" => $log_id
        );

        $activity = "Delete";
        $description = $client . " has been deleted.";

        $client = $_POST['deleteSend'];

        $delete_log = "INSERT INTO `logs` (`id`, `log_id`, `user_role`, `user_name`, `user_activity`, `client_id`, `description`, `date`, `time`, `datetime`) VALUES (NULL, '$log_id', '$role_db', '$admin_name', '$activity', '$client', '$description', CURRENT_DATE, CURRENT_TIME, CURRENT_TIMESTAMP);";

        $result = mysqli_query($conn, $delete_log);


        echo json_encode($delete_result);
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
