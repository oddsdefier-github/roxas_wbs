<?php

if (isset($_POST['emailSend']) && isset($_POST['passSend']) && isset($_POST['designationSelectedSend'])) {
    $emailSEND = filter_var($_POST['emailSend'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['passSend'];
    $designationSelectedSEND = $_POST['designationSelectedSend'];


    if (empty($emailSEND) || empty($password) || empty($designationSelectedSEND)) {
        $response = array(
            "valid" => false,
            "message" => "Please fill in all fields."
        );
    } else {

        include 'connection/database.php';
        $sql = "SELECT * FROM admin WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $emailSEND);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

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
                        "message" => "User is valid.",
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

            mysqli_stmt_close($stmt);
        } else {
            $response = array(
                "valid" => false,
                "message" => "Database error."
            );
        }

        mysqli_close($conn);
    }

    echo json_encode($response);
    exit;
}
