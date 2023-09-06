<?php
include 'connection/database.php';

if (isset($_POST['emailData'])) {
    $email_data = $_POST['emailData'];

    $sql = "SELECT email FROM admin WHERE email = '$email_data'";
    $result = mysqli_query($conn, $sql);

    $response = array();
    while ($rows = mysqli_fetch_assoc($result)) {
        $response['emailResponseData'] = $rows;
    }
    echo json_encode($response);
}

if (isset($_POST['emailSend'])) {
    $emailSEND = $_POST['emailSend'];

    $sql = "SELECT * FROM admin WHERE email = '$emailSEND'";
    $result = mysqli_query($conn, $sql);
    $adminData = array();

    while ($rows = mysqli_fetch_assoc($result)) {
        $adminData['admin_data'] = $rows;
    }

    echo json_encode($adminData);
}
