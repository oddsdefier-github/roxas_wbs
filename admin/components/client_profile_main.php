<?php

if (isset($_GET['client_id'])) {
    $client_id = $_GET['client_id'];

    $data = array();

    // Fetch client data
    $sql = "SELECT * FROM clients WHERE client_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $client_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            $data['client_data'] = $row;
        } else {
            echo "Client not found.";
        }
        mysqli_free_result($result);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);

    // Fetch client ID
    $find_id = "SELECT id FROM clients WHERE client_id = ?";
    $stmt_find_id = mysqli_prepare($conn, $find_id);
    mysqli_stmt_bind_param($stmt_find_id, "s", $client_id);
    mysqli_stmt_execute($stmt_find_id);
    $found_id_result = mysqli_stmt_get_result($stmt_find_id);
    $found_id_row = mysqli_fetch_assoc($found_id_result);
    $found_id = $found_id_row['id'];
    mysqli_free_result($found_id_result);
    mysqli_stmt_close($stmt_find_id);

    // Fetch client logs
    $query_logs = "SELECT * FROM logs WHERE client_id = ?";
    $stmt_query_logs = mysqli_prepare($conn, $query_logs);
    mysqli_stmt_bind_param($stmt_query_logs, "i", $found_id);
    mysqli_stmt_execute($stmt_query_logs);
    $query_logs_result = mysqli_stmt_get_result($stmt_query_logs);

    if ($query_logs_result) {
        $client_logs = array();

        while ($query_logs_row = mysqli_fetch_assoc($query_logs_result)) {
            $client_logs[] = $query_logs_row;
        }

        if (!empty($client_logs)) {
            $data['client_logs'] = $client_logs;
        } else {
            echo "No client logs found.";
        }
        mysqli_free_result($query_logs_result);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt_query_logs);

    print_r($data);
} else {
    echo "Invalid or missing client_id parameter.";
}
