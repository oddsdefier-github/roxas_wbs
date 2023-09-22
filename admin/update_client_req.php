<?php
include './database/connection.php';


if (isset($_POST['updateID'])) {
    $requestID = $_POST['updateID'];

    $clientName = $_POST['updateClientName'];
    $clientAddress = $_POST['updateClientAddress'];
    $clientEmail = $_POST['updateClientEmail'];
    $clientPropertyType = $_POST['updatePropertyType'];
    $clientPhoneNum = $_POST['updateClientPhoneNum'];

    $query_old_data = "SELECT * FROM clients WHERE id = '$requestID'";
    $query_old_data_result = mysqli_query($conn, $query_old_data);

    $update_description = "Updated ";
    $field_changes = array();

    if ($row = mysqli_fetch_assoc($query_old_data_result)) {
        $old_client_name = $row['client_name'];
        $old_client_address = $row['address'];
        $old_client_email = $row['email'];
        $old_client_property_type = $row['property_type'];
        $old_client_phone_num = $row['phone_number'];

        if ($clientName != $old_client_name) {
            $field_changes[] = "name: " . $old_client_name . " to " . $clientName;
        }
        if ($clientAddress != $old_client_address) {
            $field_changes[] = "address: " . $old_client_address . " to " . $clientAddress;
        }
        if ($clientEmail != $old_client_email) {
            $field_changes[] = "email: " . $old_client_email . " to " . $clientEmail;
        }
        if ($clientPropertyType != $old_client_property_type) {
            $field_changes[] = "property type: " . $old_client_property_type . " to " . $clientPropertyType;
        }
        if ($clientPhoneNum != $old_client_phone_num) {
            $field_changes[] = "phone number: " . $old_client_phone_num . " to " . $clientPhoneNum;
        }

        // Check if any fields were updated
        if (!empty($field_changes)) {
            $update_description .= implode(", ", $field_changes);

            $sql = "UPDATE clients SET client_name = '$clientName', address = '$clientAddress', email = '$clientEmail', property_type = '$clientPropertyType', phone_number = '$clientPhoneNum' WHERE id = '$requestID'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                session_start();

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

                $log_id = "U" . $initials_role_db . $initials_name . $currentDateTime;

                $activity = "Update";
                $description = $update_description;

                $client = $_POST['updateID'];

                $update_log = "INSERT INTO `logs` (`id`, `log_id`, `user_role`, `user_name`, `user_activity`, `client_id`, `description`, `date`, `time`, `datetime`) VALUES (NULL, '$log_id', '$role_db', '$admin_name', '$activity', '$client', '$description', CURRENT_DATE, CURRENT_TIME, CURRENT_TIMESTAMP);";

                $result = mysqli_query($conn, $update_log);

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
