<?php

if (isset($_POST['emailSend']) && isset($_POST['passSend']) && isset($_POST['designationSelectedSend'])) {
    $emailSEND = filter_var($_POST['emailSend'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['passSend'];
    $designationSelectedSEND = $_POST['designationSelectedSend'];


    if (empty($emailSEND) || empty($password)) {
        $emptyFields = array();

        if (empty($emailSEND)) {
            $emptyFields[] = "Email";
        }

        if (empty($password)) {
            $emptyFields[] = "Password";
        }
        $response = array(
            "valid" => false,
            "message" => "Please fill in the following fields: " . implode(', ', $emptyFields),
            "emptyFields" => $emptyFields
        );
    } else {

        include 'database/connection.php';
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


                    $activity = $admin_name . " ; Sign in";
                    $sign_in_log = "INSERT INTO `logs` (`id`, `user_activity`, `user_role`, `user_name`, `datetime`) VALUES (NULL, '$activity', '$role_db', '$admin_name',current_timestamp());";
                    $sign_in_result = mysqli_query($conn, $sign_in_log);


                    $response = array(
                        "valid" => true,
                        "message" => "User is valid.",
                        "admin_name" => $_SESSION['admin_name'],
                        "user_role" => $_SESSION['user_role']
                    );
                } else {
                    $response = array(
                        "valid" => false,
                        "message" => "Incorrect password or email.",
                        "emptyFields" => 0
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
