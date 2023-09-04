<?php
include './query/database.php';

if (isset($_POST['updateId'])) {
    $client_id = $_POST['updateId'];
    $sql = "SELECT * FROM `clients` WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $client_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $response = array();
    while ($rows = mysqli_fetch_assoc($result)) {
        $response['clientData'] = $rows;
    }

    $address = "SELECT * FROM `address` ";
    $address_data = mysqli_query($conn, $address);
    $address_array = array();
    while ($address_rows = mysqli_fetch_assoc($address_data)) {
        $address_array[] = $address_rows;
    }

    $response['addressData'] = $address_array;

    echo json_encode($response);
} else {
    echo json_encode(array('status' => 200, 'message' => 'Invalid or data not found'));
}
