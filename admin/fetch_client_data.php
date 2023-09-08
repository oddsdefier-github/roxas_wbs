<?php
include './database/connection.php';

if (isset($_POST['clientId'])) {
    $client_id = $_POST['clientId'];
    $sql = "SELECT * FROM `clients` WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $client_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $response = array();
    while ($rows = mysqli_fetch_assoc($result)) {
        $response['clientDetails'] = $rows;
    }

    echo json_encode($response);
} else {
    echo json_encode(array('status' => 200, 'message' => 'Invalid or data not found'));
}
