<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


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
        include './database/connection.php';
        $sql = "SELECT * FROM admin WHERE email = ?";
        $stmt = $conn->prepareStatement($sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $emailSEND);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                $pass_db = $row["password"];
                $admin_id = $row["admin_id"];
                $admin_name = $row["admin_name"];
                $email_db = $row["email"];
                $role_db = $row["designation"];

                if ($password == $pass_db && $emailSEND == $email_db && $designationSelectedSEND == $role_db) {

                    session_start();

                    $_SESSION['loggedin'] = true;
                    $_SESSION['admin_id'] = $admin_id;
                    $_SESSION['admin_name'] = $admin_name;
                    $_SESSION['user_role'] = $role_db;


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

                    $log_id = "SI" . $initials_role_db . $initials_name . $currentDateTime;

                    $activity = "Sign in";
                    $description = $admin_name . " has been signed in.";

                    $sign_in_log = "INSERT INTO `logs` (`id`, `log_id`, `user_role`, `user_name`, `user_activity`, `description`, `date`, `time`, `datetime`) VALUES (NULL, '$log_id', '$role_db', '$admin_name', '$activity', '$description', CURRENT_DATE, CURRENT_TIME, CURRENT_TIMESTAMP);";

                    $result = $conn->query($sign_in_log);

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
        $conn->close();
    }

    echo json_encode($response);
    exit;
}
