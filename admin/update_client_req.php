<?php
include './database/connection.php';

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
};


if (isset($_POST['updateID'])) {
    $requestID = $_POST['updateID'];

    $clientName = $_POST['updateClientName'];
    $clientAddress = $_POST['updateClientAddress'];
    $clientEmail = $_POST['updateClientEmail'];
    $clientPropertyType = $_POST['updatePropertyType'];
    $clientPhoneNum = $_POST['updateClientPhoneNum'];

    $query_old_data = "SELECT * FROM clients WHERE id = '$requestID'";
    $query_old_data_result = mysqli_query($conn, $query_old_data);

    $activity = "Updated ";


    if ($row = mysqli_fetch_assoc($query_old_data_result)) {
        $old_client_name = $row['client_name'];
        $old_client_address = $row['address'];
        $old_client_email = $row['email'];
        $old_client_property_type = $row['property_type'];
        $old_client_phone_num = $row['phone_number'];

        if ($clientName != $old_client_name) {
            $activity .= "client name";
        }
        if ($clientAddress != $old_client_address) {
            $activity .= "client address";
        }
        if ($clientEmail != $old_client_email) {
            $activity .= "client email";
        }
        if ($clientPropertyType != $old_client_property_type) {
            $activity .= "client property type";
        }
        if ($clientPhoneNum != $old_client_phone_num) {
            $activity .= "phone number";
        }


        // Check if any fields were updated
        if ($activity !== "Updated ") {
            $sql = "UPDATE clients SET client_name = '$clientName', address = '$clientAddress', email = '$clientEmail', property_type = '$clientPropertyType', phone_number = '$clientPhoneNum' WHERE id = '$requestID'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                session_start();
                $admin_name = $_SESSION['admin_name'];
                $role_db = $_SESSION['user_role'];

                $activity = $clientName . " ; " . $activity;

                // // Log the update activity
                // $update_log = "INSERT INTO `logs` (`id`, `user_activity`, `user_role`, `user_name`, `datetime`) VALUES (NULL, '$activity', '$role_db', '$admin_name', current_timestamp());";
                // $update_result = mysqli_query($conn, $update_log);

                if ($update_result) {
                    $response['success'] = true;
                    $response['message'] = "Record updated successfully.";
                } else {
                    $response['success'] = false;
                    $response['message'] = "Error updating log: " . mysqli_error($conn);
                }
            } else {
                $response['success'] = false;
                $response['message'] = "Error updating record: " . mysqli_error($conn);
            }
        } else {
            $response['success'] = false;
            $response['message'] = "No fields were updated.";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Record not found.";
    }

    // Send the response as JSON
    echo json_encode($response);
};
