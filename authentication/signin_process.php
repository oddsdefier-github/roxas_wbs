<?php

include 'connection/database.php';

if (isset($_POST['emailSend']) && isset($_POST['passSend']) && isset($_POST['designationSelectedSend'])) {
    $emailSEND = $_POST['emailSend'];
    $password = $_POST['passSend'];
    $designationSelectedSEND = $_POST['designationSelectedSend'];

    $sql = "SELECT * FROM admin WHERE email = '$emailSEND'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $pass_db = $row["password"];
        $admin_name = $row["admin_name"];
        $email_db = $row["email"];
        $role_db = $row["designation"];

        if ($password == $pass_db && $emailSEND == $email_db && $designationSelectedSEND == $role_db) {
            session_start();

            $_SESSION['loggedin'] = true;
            $_SESSION['admin_name'] = $admin_name;
            $_SESSION['user_role'] = $role_db;


            $response = array(
                "valid" => true,
                "message" => "User is valid. Login successful.",
                "admin_name" => $_SESSION['admin_name'],
                "user_role" => $_SESSION['user_role']
            );
        } else {
            $response = array(
                "valid" => false,
                "message" => "Incorrect password or email."
            );
        }
    } else {
        $response = array(
            "valid" => false,
            "message" => "User not found."
        );
    }

    echo json_encode($response);
    exit;
}
