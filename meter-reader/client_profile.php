<?php

require './database/connection.php';
include './auth_guard.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $name = "";

    $sql = "SELECT * FROM client_data WHERE client_id = ?";
    $stmt = $conn->prepareStatement($sql);
    mysqli_stmt_bind_param($stmt, 's', $id);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $name = $row['full_name'];
        }
    } else {
        echo "There was an error executing the statement.";
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid or missing id parameter.";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name ?></title>
</head>

<body>
    <?php echo $name ?>
</body>

</html>