<?php
include './connection/database.php';

if (isset($_POST['deleteSend'])) {
    $uniqueId = $_POST['deleteSend'];

    $sql = "DELETE FROM clients WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $uniqueId);

    if (mysqli_stmt_execute($stmt)) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
