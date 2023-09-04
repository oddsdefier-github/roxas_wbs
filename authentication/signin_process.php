<?php
session_start();

include 'connection/database.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];
    $selectedRole = $_POST['user_role'];

    $sql = "SELECT * FROM admin WHERE email = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {

        $pass_db = $row["password"];
        $admin_name = $row["admin_name"];
        $email_db = $row["email"];
        $role_db = $row["designation"];

        if ($password == $pass_db && $email == $email_db) {
            if ($selectedRole == $role_db) {

                $_SESSION['loggedin'] = true;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_role'] = $role_db;

                if ($role_db == "Admin") {
                    header("Location: ../admin/index.php");
                } elseif ($role_db == "Cashier") {
                    header("Location: ../cashier/index.php");
                } elseif ($role_db == "Meter Reader") {
                    header("Location: ../meter_reader/index.php");
                }
            } else {
                echo "Role mismatch.";
            }
        } else {
            echo "Incorrect password or email.";
        }
    } else {
        echo "User not found.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
