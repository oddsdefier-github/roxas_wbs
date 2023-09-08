<?php
include 'database/connection.php';

if (isset($_POST['emailData'])) {
    $email_data = $_POST['emailData'];

    $sql = "SELECT email, designation FROM admin WHERE email = '$email_data'";
    $result = mysqli_query($conn, $sql);

    $response = array();

    if ($result) {
        // Check if there are any rows returned
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $response = array(
                "emailData" => $row['email'],
                "designationData" => $row['designation']
            );
        } else {
            $response['error'] = "No data found for the provided email.";
        }
    } else {
        $response['error'] = "Database query failed: " . mysqli_error($conn);
    }

    // Send the JSON response
    echo json_encode($response);
}
