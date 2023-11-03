<?php

use Admin\Database\DatabaseConnection;

require 'database/connection.php';

class BaseQuery
{
    protected $conn;

    public function __construct(DatabaseConnection $databaseConnection)
    {
        $this->conn = $databaseConnection;
    }
}

class DatabaseQueries extends BaseQuery
{
    public function retrieveClientData($clientID)
    {
        $response = array();
        $sql = "SELECT * FROM client_data WHERE client_id = ?";
        $stmt = $this->conn->prepareStatement($sql);
        mysqli_stmt_bind_param($stmt, "s", $clientID);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $client_data_array = array();

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($client_data_array, $row);
                }
                $response['client_data'] = $client_data_array;
            } else {
                $response['error'] = "No client found with the provided ID.";
            }
        } else {
            $response['error'] = "There was an error executing the statement.";
        }

        mysqli_stmt_close($stmt);

        return $response;
    }

    public function markNotificationAsRead($applicationID)
    {
        $sqlSelect = "SELECT id FROM client_application WHERE application_id = ?";
        $stmtSelect = $this->conn->prepareStatement($sqlSelect);
        $stmtSelect->bind_param("s", $applicationID);

        if ($stmtSelect->execute()) {
            $result = $stmtSelect->get_result();
            $row = $result->fetch_assoc();
            $id = $row['id'];

            $sqlUpdate = "UPDATE notifications SET status = 'read' WHERE reference_id = ?";
            $stmtUpdate = $this->conn->prepareStatement($sqlUpdate);
            $stmtUpdate->bind_param("i", $id);

            if ($stmtUpdate->execute()) {
                return true;
            } else {
                return "Error: " . $this->conn->getErrorMessage();
            }
        } else {
            return "Error: " . $this->conn->getErrorMessage();
        }
    }

    public function insertIntoClientApplication($formData)
    {
        $meterNumber = htmlspecialchars($formData['meterNumber'], ENT_QUOTES, 'UTF-8');
        $firstName = htmlspecialchars($formData['firstName'], ENT_QUOTES, 'UTF-8');
        $middleName = htmlspecialchars($formData['middleName'], ENT_QUOTES, 'UTF-8');
        $lastName = htmlspecialchars($formData['lastName'], ENT_QUOTES, 'UTF-8');
        $fullName = htmlspecialchars($formData['fullName'], ENT_QUOTES, 'UTF-8');
        $nameSuffix = htmlspecialchars($formData['nameSuffix'], ENT_QUOTES, 'UTF-8');
        $birthDate = htmlspecialchars($formData['birthDate'], ENT_QUOTES, 'UTF-8');
        $age = htmlspecialchars($formData['age'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($formData['email'], ENT_QUOTES, 'UTF-8');
        $gender = htmlspecialchars($formData['gender'], ENT_QUOTES, 'UTF-8');
        $phoneNumber = htmlspecialchars($formData['phoneNumber'], ENT_QUOTES, 'UTF-8');
        $propertyType = htmlspecialchars($formData['propertyType'], ENT_QUOTES, 'UTF-8');
        $streetAddress = htmlspecialchars($formData['streetAddress'], ENT_QUOTES, 'UTF-8');
        $brgy = htmlspecialchars($formData['brgy'], ENT_QUOTES, 'UTF-8');
        $municipality = htmlspecialchars($formData['municipality'], ENT_QUOTES, 'UTF-8');
        $province = htmlspecialchars($formData['province'], ENT_QUOTES, 'UTF-8');
        $region = htmlspecialchars($formData['region'], ENT_QUOTES, 'UTF-8');
        $fullAddress = htmlspecialchars($formData['fullAddress'], ENT_QUOTES, 'UTF-8');
        $validID = htmlspecialchars($formData['validID'], ENT_QUOTES, 'UTF-8');
        $proofOfOwnership = htmlspecialchars($formData['proofOfOwnership'], ENT_QUOTES, 'UTF-8');
        $deedOfSale = htmlspecialchars($formData['deedOfSale'], ENT_QUOTES, 'UTF-8');
        $affidavit = htmlspecialchars($formData['affidavit'], ENT_QUOTES, 'UTF-8');

        $status = 'unconfirmed';
        $billingStatus = 'unpaid';

        $applicationID = 'A' . date("YmdHis");
        $sql = "INSERT INTO client_application (meter_number, first_name, middle_name, last_name, name_suffix, full_name, email, phone_number, birthdate, age, gender, property_type, street, brgy, municipality, province, region, full_address, valid_id, proof_of_ownership, deed_of_sale, affidavit, billing_status, status, application_id, time, date, timestamp ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";

        $stmt = $this->conn->prepareStatement($sql);

        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt,
                "sssssssssssssssssssssssss",
                $meterNumber,
                $firstName,
                $middleName,
                $lastName,
                $nameSuffix,
                $fullName,
                $email,
                $phoneNumber,
                $birthDate,
                $age,
                $gender,
                $propertyType,
                $streetAddress,
                $brgy,
                $municipality,
                $province,
                $region,
                $fullAddress,
                $validID,
                $proofOfOwnership,
                $deedOfSale,
                $affidavit,
                $billingStatus,
                $status,
                $applicationID
            );

            if (mysqli_stmt_execute($stmt)) {
                return true;
            } else {
                return "Error: " . mysqli_stmt_error($stmt);
            }
        } else {
            return "Error: " . $this->conn->getErrorMessage();
        }
    }

    public function checkDuplicate($items, $values, $table)
    {
        $checkDuplicate = "SELECT $items FROM $table WHERE $items = ?";
        $stmt = $this->conn->prepareStatement($checkDuplicate);
        mysqli_stmt_bind_param($stmt, "s", $values);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                return true;
            }
        }
        return false;
    }

    public function processClientApplication($formData)
    {
        $table = "client_application";
        $meterNumber = htmlspecialchars($formData['meterNumber'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($formData['email'], ENT_QUOTES, 'UTF-8');
        $fullName = htmlspecialchars($formData['fullName'], ENT_QUOTES, 'UTF-8');

        if ($this->checkDuplicate("meter_number", $meterNumber, $table)) {
            $response = array(
                "status" => "error",
                "message" => "Meter No: " . $meterNumber . " already exists in the database."
            );
            return $response;
        }

        if ($this->checkDuplicate("email", $email, $table)) {
            $response = array(
                "status" => "error",
                "message" => "Email: " . $email . " already exists in the database."
            );
            return $response;
        }

        if ($this->checkDuplicate("full_name", $fullName, $table)) {
            $response = array(
                "status" => "error",
                "message" => $fullName . " already exists."
            );
            return $response;
        }

        $insertResult = $this->insertIntoClientApplication($formData);
        if ($insertResult === true) {
            $response = array(
                "status" => "success",
                "message" => $fullName . "'s application has successfully processed.",
            );
            return $response;
        } else {
            $response = array(
                "status" => "error",
                "message" => $insertResult
            );
            return $response;
        }
    }

    public function fetchAddressData()
    {
        $sql = "SELECT * FROM `address`";
        $result = $this->conn->query($sql);

        $address_array = array();
        while ($rows = mysqli_fetch_assoc($result)) {
            $address_array[] = $rows;
        }
        $response['address'] = $address_array;

        return $response;
    }
    public function insertIntoClientData($formData, $clientID)
    {
        $applicationID = htmlspecialchars($formData['applicationID'], ENT_QUOTES, 'UTF-8');
        $meterNumber = htmlspecialchars($formData['meterNumber'], ENT_QUOTES, 'UTF-8');
        $fullName = htmlspecialchars($formData['fullName'], ENT_QUOTES, 'UTF-8');
        $birthDate = htmlspecialchars($formData['birthDate'], ENT_QUOTES, 'UTF-8');
        $age = htmlspecialchars($formData['age'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($formData['email'], ENT_QUOTES, 'UTF-8');
        $phoneNumber = htmlspecialchars($formData['phoneNumber'], ENT_QUOTES, 'UTF-8');
        $propertyType = htmlspecialchars($formData['propertyType'], ENT_QUOTES, 'UTF-8');
        $streetAddress = htmlspecialchars($formData['streetAddress'], ENT_QUOTES, 'UTF-8');
        $brgy = htmlspecialchars($formData['brgy'], ENT_QUOTES, 'UTF-8');
        $fullAddress = htmlspecialchars($formData['fullAddress'], ENT_QUOTES, 'UTF-8');

        $status = "active";
        $readingStatus = "pending";

        $registrationId = 'R' . date("YmdHis");

        $sql = "INSERT INTO client_data (client_id, reg_id, meter_number, full_name, email, phone_number, birthdate, age, property_type, street, brgy, full_address, status, reading_status, application_id, time, date, timestamp ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";

        $stmt = $this->conn->prepareStatement($sql);
        mysqli_stmt_bind_param(
            $stmt,
            "sssssssssssssss",
            $clientID,
            $registrationId,
            $meterNumber,
            $fullName,
            $email,
            $phoneNumber,
            $birthDate,
            $age,
            $propertyType,
            $streetAddress,
            $brgy,
            $fullAddress,
            $status,
            $readingStatus,
            $applicationID
        );

        if (mysqli_stmt_execute($stmt)) {

            $markNotificationAsRead =  $this->markNotificationAsRead($applicationID);
            if (!$markNotificationAsRead) {
                return "Error: " . $markNotificationAsRead;
            }

            $insertIntoClientSecondaryData =  $this->insertIntoClientSecondaryData($formData, $clientID);
            if (!$insertIntoClientSecondaryData) {
                return "Error: " . $insertIntoClientSecondaryData;
            }

            $insertIntoBillingData = $this->insertIntoBillingData($formData, $registrationId, $clientID);
            if (!$insertIntoBillingData) {
                return "Error: " . $insertIntoBillingData;
            }

            return true;
        } else {
            return "Error: " . $this->conn->getErrorMessage();
        }
    }

    public function insertIntoClientSecondaryData($formData, $clientID)
    {
        $applicationID = htmlspecialchars($formData['applicationID'], ENT_QUOTES, 'UTF-8');
        $firstName = htmlspecialchars($formData['firstName'], ENT_QUOTES, 'UTF-8');
        $middleName = htmlspecialchars($formData['middleName'], ENT_QUOTES, 'UTF-8');
        $lastName = htmlspecialchars($formData['lastName'], ENT_QUOTES, 'UTF-8');
        $nameSuffix = htmlspecialchars($formData['nameSuffix'], ENT_QUOTES, 'UTF-8');
        $gender = htmlspecialchars($formData['gender'], ENT_QUOTES, 'UTF-8');
        $propertyType = htmlspecialchars($formData['propertyType'], ENT_QUOTES, 'UTF-8');
        $streetAddress = htmlspecialchars($formData['streetAddress'], ENT_QUOTES, 'UTF-8');
        $brgy = htmlspecialchars($formData['brgy'], ENT_QUOTES, 'UTF-8');
        $municipality = htmlspecialchars($formData['municipality'], ENT_QUOTES, 'UTF-8');
        $province = htmlspecialchars($formData['province'], ENT_QUOTES, 'UTF-8');
        $region = htmlspecialchars($formData['region'], ENT_QUOTES, 'UTF-8');
        $validID = htmlspecialchars($formData['validID'], ENT_QUOTES, 'UTF-8');
        $proofOfOwnership = htmlspecialchars($formData['proofOfOwnership'], ENT_QUOTES, 'UTF-8');
        $deedOfSale = htmlspecialchars($formData['deedOfSale'], ENT_QUOTES, 'UTF-8');
        $affidavit = htmlspecialchars($formData['affidavit'], ENT_QUOTES, 'UTF-8');

        $status = 'approved';
        $sql = "UPDATE client_application SET status = ? WHERE application_id = ?";
        $updateStmt = $this->conn->prepareStatement($sql);
        $updateStmt->bind_param("ss", $status, $applicationID);

        if (mysqli_stmt_execute($updateStmt)) {
            $insert_sec_data = "INSERT INTO client_secondary_data (client_id, first_name, middle_name, last_name, name_suffix, property_type, gender, street, brgy, municipality, province, region, valid_id, proof_of_ownership, deed_of_sale, affidavit, time, date, timestamp) VALUES (?, ?, ?, ?, ?, ?, ?,?, ?, ?,?, ?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";
            $stmt = $this->conn->prepareStatement($insert_sec_data);

            mysqli_stmt_bind_param(
                $stmt,
                "ssssssssssssssss",
                $clientID,
                $firstName,
                $middleName,
                $lastName,
                $nameSuffix,
                $propertyType,
                $gender,
                $streetAddress,
                $brgy,
                $municipality,
                $province,
                $region,
                $validID,
                $proofOfOwnership,
                $deedOfSale,
                $affidavit,
            );
            if (mysqli_stmt_execute($stmt)) {
                return true;
            } else {
                return "Error: " . $this->conn->getErrorMessage();
            }
        }
    }

    public function insertIntoBillingData($formData, $clientID)
    {
        $meterNumber = htmlspecialchars($formData['meterNumber'], ENT_QUOTES, 'UTF-8');

        session_start();

        $encoder = $_SESSION['user_name'];

        $initialReading = 0;
        $prevReading = 0;

        $billingID = "B" . time();
        $billingID = "B-" . $meterNumber . "-" . time();
        $readingType = 'current';

        $dueDate = NULL;
        $disconnectionDate = NULL;

        $currentDate = new DateTime();
        $currentDate->setTime(0, 0, 0);
        $periodTo = clone $currentDate;
        $periodTo->modify('last day of this month');
        $periodTo = $periodTo->format('Y-m-d');

        $periodFrom = date("Y-m-d");

        $billingStatus = NULL;
        $billingType = 'initial';
        $consumption = 0;
        $rates = 0;
        $billingAmount = 0;

        $currentDate = new DateTime();
        $billingMonthAndYear = $currentDate->format('F Y');

        $sql_billing = "INSERT INTO billing_data (billing_id, client_id, prev_reading, curr_reading, reading_type, consumption, rates, billing_amount, billing_status, billing_type, billing_month, due_date, disconnection_date, period_to, period_from, encoder, time, date, timestamp ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";
        $stmt_billing = $this->conn->prepareStatement($sql_billing);
        mysqli_stmt_bind_param(
            $stmt_billing,
            "ssddsssdssssssss",
            $billingID,
            $clientID,
            $prevReading,
            $initialReading,
            $readingType,
            $consumption,
            $rates,
            $billingAmount,
            $billingStatus,
            $billingType,
            $billingMonthAndYear,
            $dueDate,
            $disconnectionDate,
            $periodFrom,
            $periodFrom,
            $encoder
        );

        if (mysqli_stmt_execute($stmt_billing)) {
            return true;
        } else {
            return "Error: " . $this->conn->getErrorMessage();
        }
    }

    public function approveClientApplication($formData)
    {
        $response = array();
        $table = "client_data";
        $firstName = htmlspecialchars($formData['firstName'], ENT_QUOTES, 'UTF-8');
        $middleName = htmlspecialchars($formData['middleName'], ENT_QUOTES, 'UTF-8');
        $lastName = htmlspecialchars($formData['lastName'], ENT_QUOTES, 'UTF-8');
        $fullName = htmlspecialchars($formData['fullName'], ENT_QUOTES, 'UTF-8');
        $meterNumber = htmlspecialchars($formData['meterNumber'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($formData['email'], ENT_QUOTES, 'UTF-8');

        $totalClient = "SELECT COUNT(*) as total_clients FROM client_data";

        $query = $this->conn->query($totalClient);
        $result = mysqli_fetch_assoc($query);
        if ($result) {
            $total = $result['total_clients'];
            $total = $total + 1;
            $paddedTotal = str_pad($total, 3, '0', STR_PAD_LEFT);
        }

        $initials = $firstName[0] . $middleName[0] . $lastName[0];
        $currDate = date('mdy');
        $clientID = "WBS-" . $initials . "-" . $paddedTotal . $currDate;


        if ($this->checkDuplicate("meter_number", $meterNumber, $table)) {
            $response = array(
                "status" => "error",
                "message" => "Meter No: " . $meterNumber . " already exists."
            );
            return $response;
        };

        if ($this->checkDuplicate("email", $email, $table)) {
            $response = array(
                "status" => "error",
                "message" => $email . " already exists."
            );
            return $response;
        };

        $insertIntoClientData = $this->insertIntoClientData($formData, $clientID);
        if ($insertIntoClientData === true) {
            $response = array(
                "status" => "success",
                "client_id" => $clientID,
                "message" => $fullName . "'s application has been approved."
            );
            return $response;
        } else {
            $response = array(
                "status" => "error",
                "message" => "Failed: " . $insertIntoClientData
            );
            return $response;
        }
    }


    public function getTotalItem($tableName, $searchTerm = "")
    {
        $total = array();

        $sql = "SELECT COUNT(*) FROM $tableName";

        if ($searchTerm) {
            $likeTerm = "%" . $searchTerm . "%";
            $sql .= " WHERE full_name LIKE ? OR meter_number LIKE ? OR street LIKE ? OR brgy LIKE ? OR property_type LIKE ? OR status LIKE ?";
        }

        $stmt = $this->conn->prepareStatement($sql);
        if ($searchTerm) {
            mysqli_stmt_bind_param($stmt, "ssssss", $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm);
        }

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_row($result)) {
            $total['totalItem'] = $row[0];
        }

        mysqli_stmt_close($stmt);

        return $total;
    }


    public function retrieveClientApplicationData($id)
    {

        $data = array();
        $sql = "SELECT * FROM client_application WHERE id = ?";
        $stmt = $this->conn->prepareStatement($sql);
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $result = $this->conn->getResultSet($stmt);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                $data['applicationData'] = $row;
            } else {
                echo "Applicant not found.";
            }
            mysqli_free_result($result);
        } else {
            echo "Error: " . $this->conn->getErrorMessage();
        }
        mysqli_stmt_close($stmt);
        return $data;
    }

    public function deleteItem($delID, $tableName)
    {
        $response = array();
        $sqlFetchName = "SELECT full_name FROM $tableName WHERE id = ?";
        $stmtName = $this->conn->prepareStatement($sqlFetchName);
        $stmtName->bind_param("i", $delID);
        if ($stmtName->execute()) {
            $result = $stmtName->get_result();
            if ($result->num_rows > 0) {
                $userData = $result->fetch_assoc();
                $response['full_name'] = $userData['full_name'];
            }
            $stmtName->close();
        } else {
            $response['error'] = "Failed to fetch user's full name.";
            return $response;
        }

        $sqlDelete = "DELETE FROM $tableName WHERE id = ?";
        try {
            $stmtDelete = $this->conn->prepareStatement($sqlDelete);
            $stmtDelete->bind_param("i", $delID);

            if (!$stmtDelete->execute()) {
                throw new Exception("Failed to delete item. " . $stmtDelete->error);
            }

            if ($stmtDelete->affected_rows == 0) {
                throw new Exception("No rows were deleted.");
            }

            $stmtDelete->close();

            $response['success'] = "Item deleted successfully!";
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
        }

        return $response;
    }

    public function getName($id, $tableName)
    {
        $sql = "SELECT full_name FROM $tableName WHERE id = ?";
        $response = array();

        try {
            $stmt = $this->conn->prepareStatement($sql);
            $stmt->bind_param("i", $id);

            if (!$stmt->execute()) {
                throw new Exception("Failed to fetch name. " . $stmt->error);
            }

            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $response['full_name'] = $row['full_name'];
            } else {
                throw new Exception("No user found with the given ID.");
            }

            $stmt->close();
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
        }

        return $response;
    }
    public function updatedClientAppStatus($applicantID, $documentsData)
    {
        $meterNumber = htmlspecialchars($documentsData['meterNumber'], ENT_QUOTES, 'UTF-8');
        $firstName = htmlspecialchars($documentsData['firstName'], ENT_QUOTES, 'UTF-8');
        $middleName = htmlspecialchars($documentsData['middleName'], ENT_QUOTES, 'UTF-8');
        $lastName = htmlspecialchars($documentsData['lastName'], ENT_QUOTES, 'UTF-8');
        $fullName = htmlspecialchars($documentsData['fullName'], ENT_QUOTES, 'UTF-8');
        $nameSuffix = htmlspecialchars($documentsData['nameSuffix'], ENT_QUOTES, 'UTF-8');
        $birthDate = htmlspecialchars($documentsData['birthDate'], ENT_QUOTES, 'UTF-8');
        $age = htmlspecialchars($documentsData['age'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($documentsData['email'], ENT_QUOTES, 'UTF-8');
        $gender = htmlspecialchars($documentsData['gender'], ENT_QUOTES, 'UTF-8');
        $phoneNumber = htmlspecialchars($documentsData['phoneNumber'], ENT_QUOTES, 'UTF-8');
        $propertyType = htmlspecialchars($documentsData['propertyType'], ENT_QUOTES, 'UTF-8');
        $streetAddress = htmlspecialchars($documentsData['streetAddress'], ENT_QUOTES, 'UTF-8');
        $brgy = htmlspecialchars($documentsData['brgy'], ENT_QUOTES, 'UTF-8');
        $fullAddress = htmlspecialchars($documentsData['fullAddress'], ENT_QUOTES, 'UTF-8');
        $validID = htmlspecialchars($documentsData['validID'], ENT_QUOTES, 'UTF-8');
        $proofOfOwnership = htmlspecialchars($documentsData['proofOfOwnership'], ENT_QUOTES, 'UTF-8');
        $deedOfSale = htmlspecialchars($documentsData['deedOfSale'], ENT_QUOTES, 'UTF-8');
        $affidavit = htmlspecialchars($documentsData['affidavit'], ENT_QUOTES, 'UTF-8');


        $sql = "UPDATE client_application SET 
                status = 'confirmed',
                meter_number = ?,
                first_name = ?,
                middle_name = ?,
                last_name = ?,
                full_name = ?,
                name_suffix = ?,
                birthdate = ?,
                age = ?,
                email = ?,
                gender = ?,
                phone_number = ?,
                property_type = ?,
                street = ?,
                brgy = ?,
                full_address = ?,
                valid_id = ?,
                proof_of_ownership = ?, 
                deed_of_sale = ?, 
                affidavit = ?,
                billing_status = 'unpaid',
                timestamp = CURRENT_TIMESTAMP 
                WHERE id = ?";
        $stmt = $this->conn->prepareStatement($sql);

        $stmt->bind_param(
            'ssssssssssssssssssss',
            $meterNumber,
            $firstName,
            $middleName,
            $lastName,
            $fullName,
            $nameSuffix,
            $birthDate,
            $age,
            $email,
            $gender,
            $phoneNumber,
            $propertyType,
            $streetAddress,
            $brgy,
            $fullAddress,
            $validID,
            $proofOfOwnership,
            $deedOfSale,
            $affidavit,
            $applicantID
        );

        if ($stmt->execute()) {
            return [
                'status' => 'success',
                'message' => 'Successfully updated the client application status.'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Failed to update the client application status.'
            ];
        }
    }

    public function loadNotificationHtml($limit)
    {
        $limit = isset($_POST['limit']) ? $_POST['limit'] : 10;
        if ($limit === 'all') {
            $sql = "SELECT * FROM notifications WHERE status = 'unread' ORDER BY created_at DESC";
        } else {
            $sql = "SELECT * FROM notifications WHERE status = 'unread' ORDER BY created_at DESC LIMIT $limit";
        }
        $result = $this->conn->query($sql);

        $notifCount = 0;
        $output = "";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $notifCount++;
                $icon = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGZpbGw9Im5vbmUiIHZpZXdCb3g9IjAgMCAyNCAyNCIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZT0iY3VycmVudENvbG9yIiBjbGFzcz0idy02IGgtNiI+DQogIDxwYXRoIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgZD0iTTEwLjEyNSAyLjI1aC00LjVjLS42MjEgMC0xLjEyNS41MDQtMS4xMjUgMS4xMjV2MTcuMjVjMCAuNjIxLjUwNCAxLjEyNSAxLjEyNSAxLjEyNWgxMi43NWMuNjIxIDAgMS4xMjUtLjUwNCAxLjEyNS0xLjEyNXYtOU0xMC4xMjUgMi4yNWguMzc1YTkgOSAwIDAxOSA5di4zNzVNMTAuMTI1IDIuMjVBMy4zNzUgMy4zNzUgMCAwMTEzLjUgNS42MjV2MS41YzAgLjYyMS41MDQgMS4xMjUgMS4xMjUgMS4xMjVoMS41YTMuMzc1IDMuMzc1IDAgMDEzLjM3NSAzLjM3NU05IDE1bDIuMjUgMi4yNUwxNSAxMiIgLz4NCjwvc3ZnPg0K"; // Your SVG data
                $notificationContent = $row['message'];
                $userID = $row['user_id'];
                $referenceID = $row['reference_id'];
                $url = BASE_URL . 'admin/client_application_review.php?id=' . $referenceID;

                // Calculate time ago
                $currentDateTime = new DateTime(); // Current time
                $notificationDateTime = new DateTime($row['created_at'], new DateTimeZone('Asia/Manila'));
                $interval = $notificationDateTime->diff($currentDateTime); // Difference between the two times

                if ($interval->y > 0) {
                    $timeAgo = $interval->y . " year" . ($interval->y > 1 ? "s" : "") . " ago";
                } elseif ($interval->m > 0) {
                    $timeAgo = $interval->m . " month" . ($interval->m > 1 ? "s" : "") . " ago";
                } elseif ($interval->d > 0) {
                    $timeAgo = $interval->d . " day" . ($interval->d > 1 ? "s" : "") . " ago";
                } elseif ($interval->h > 0) {
                    $timeAgo = $interval->h . " hour" . ($interval->h > 1 ? "s" : "") . " ago";
                } elseif ($interval->i > 0) {
                    $timeAgo = $interval->i . " minute" . ($interval->i > 1 ? "s" : "") . " ago";
                } else {
                    $timeAgo = "a few moments ago";
                }

                $output .= "
                    <a href=\"$url\" class=\"flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700\">
                        <div class=\"flex-shrink-0\">
                            <img class=\"rounded-full w-11 h-11\" src='$icon' alt=\"Confirm Icon\">
                        </div>
                        <div class=\"w-full pl-3\">
                            <div class=\"text-gray-500 text-sm mb-1.5 dark:text-gray-400\">$notificationContent <span class=\"font-semibold text-gray-900 dark:text-white\">$userID</span></div>
                            <div class=\"text-xs text-blue-600 dark:text-blue-500\">$timeAgo</div>
                        </div>
                    </a>
                ";
            }
        } else {
            $sql = "TRUNCATE TABLE notifications";
            $this->conn->query($sql);
            $output .= "<div class=\"flex justify-center items-center px-4 py-3 hover:bg-gray-100\">None</div>";
        }
        $output = '<input id="notif_count_hidden" type="hidden" value="' . $notifCount . '">' . $output;
        echo $output;
    }

    public function countUnreadNotifications()
    {
        $sql = "SELECT COUNT(*) as unread_count FROM notifications WHERE status = 'unread'";
        $response = array();

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $unread_count = $row['unread_count'];

            if ($unread_count > 0) {
                $response['status'] = 'success';
                $response['unread_count'] = $unread_count;
            } else {
                $response['status'] = 'empty';
                $response['unread_count'] = 0;
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Unable to fetch data';
        }

        return json_encode($response);
    }

    public function updateApplicationFees($formData)
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $user_id = $_SESSION['user_id'];


        $applicationFee = filter_var($formData['applicationFee'], FILTER_VALIDATE_FLOAT);
        $inspectionFee = filter_var($formData['inspectionFee'], FILTER_VALIDATE_FLOAT);
        $installationFee = filter_var($formData['installationFee'], FILTER_VALIDATE_FLOAT);
        $registrationFee = filter_var($formData['registrationFee'], FILTER_VALIDATE_FLOAT);
        $connectionFee = filter_var($formData['connectionFee'], FILTER_VALIDATE_FLOAT);
        $reference_id = $user_id;


        $sql = "INSERT into client_application_fees(application_fee, inspection_fee, registration_fee, connection_fee, installation_fee, reference_id, time, date, timestamp) VALUES(?, ?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";
        $stmt = $this->conn->prepareStatement($sql);

        $stmt->bind_param("ddddds", $applicationFee, $inspectionFee, $registrationFee, $connectionFee, $installationFee, $reference_id);


        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'Application Fees are updated successfully'];
        } else {
            return ['status' => 'error', 'message' => 'Data insertion failed', 'error' => $this->conn->getErrorMessage()];
        }
    }
    public function updatePenaltyFees($formData)
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $user_id = $_SESSION['user_id'];


        $latePaymentFee = filter_var($formData['latePaymentFee'], FILTER_VALIDATE_FLOAT);
        $reconnectionFee = filter_var($formData['reconnectionFee'], FILTER_VALIDATE_FLOAT);
        $reference_id = $user_id;


        $sql = "INSERT into penalty_fees(late_payment_fee, reconnection_fee, reference_id, time, date, timestamp) VALUES( ?, ?,?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";
        $stmt = $this->conn->prepareStatement($sql);

        $stmt->bind_param("dds", $latePaymentFee, $reconnectionFee, $reference_id);


        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'Penalty Fees are updated successfully'];
        } else {
            return ['status' => 'error', 'message' => 'Data insertion failed', 'error' => $this->conn->getErrorMessage()];
        }
    }
    public function updateRates($formData)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $user_id = $_SESSION['user_id'];


        $propertyType = htmlspecialchars($formData['propertyType'], ENT_QUOTES, 'UTF-8');
        $rates = filter_var($formData['rates'], FILTER_VALIDATE_FLOAT);
        $currentMonthYear = date('F Y');
        $reference_id = $user_id;


        $sql = "INSERT into rates(property_type, rates, billing_month, reference_id, time, date, timestamp) VALUES(?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";
        $stmt = $this->conn->prepareStatement($sql);

        $stmt->bind_param("sdss", $propertyType, $rates, $currentMonthYear, $reference_id);

        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'Rates are updated successfully'];
        } else {
            return ['status' => 'error', 'message' => 'Data insertion failed', 'error' => $this->conn->getErrorMessage()];
        }
    }
}


class DataTable extends BaseQuery
{
    //CLIENT-APPLICATION
    public function clientApplicationTable($dataTableParam)
    {
        $pageNumber = $dataTableParam['pageNumber'];
        $itemPerPage = $dataTableParam['itemPerPage'];
        $searchTerm = isset($dataTableParam['searchTerm']) ? $dataTableParam['searchTerm'] : "";
        $offset = ($pageNumber - 1) * $itemPerPage;
        $sortColumn = isset($dataTableParam['sortColumn']) ? $dataTableParam['sortColumn'] : "timestamp";
        $sortDirection = isset($dataTableParam['sortDirection']) ? $dataTableParam['sortDirection'] : "DESC";
        $filters = isset($dataTableParam['filters']) ? $dataTableParam['filters'] : [];

        $conditions = [];
        $params = [];
        $types = "";

        if ($searchTerm) {
            $likeTerm = "%" . $searchTerm . "%";
            $conditions[] = "(full_name LIKE ? OR meter_number LIKE ? OR street LIKE ? OR brgy LIKE ? OR property_type LIKE ? OR status LIKE ? OR billing_status LIKE ?)";
            $params = array_merge($params, [$likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm]);
            $types .= "sssssss";
        }

        if (!empty($filters)) {
            foreach ($filters as $filter) {
                $conditions[] = "{$filter['column']} = ?";
                $params[] = $filter['value'];
                $types .= "s";
            }
        }

        if (!empty($conditions)) {
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM client_application WHERE " . implode(" AND ", $conditions);
        } else {
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM client_application";
        }


        $validColumns = [
            'meter_number', 'full_name',  'property_type', 'brgy',
            'status', 'billing_status', 'timestamp'
        ];
        $validDirections = ['ASC', 'DESC'];

        if (in_array($sortColumn, $validColumns) && in_array($sortDirection, $validDirections)) {
            $sql .= " ORDER BY {$sortColumn} {$sortDirection}";
        } else {
            $sql .= " ORDER BY timestamp DESC";
        }

        $sql .= " LIMIT ? OFFSET ?";
        $params = array_merge($params, [$itemPerPage, $offset]);
        $types .= "ii";

        $stmt = $this->conn->prepareStatement($sql);
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        mysqli_stmt_execute($stmt);


        $result = mysqli_stmt_get_result($stmt);

        $resultCount = $this->conn->query("SELECT FOUND_ROWS() as total");

        if ($resultCount && $row = mysqli_fetch_assoc($resultCount)) {
            $totalRecords = $row['total'];
        } else {
            $totalRecords = 0;
        }

        $descendingIcon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
    </svg>';
        $ascendingIcon = ' <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
    </svg>';

        $sortIcon = $sortDirection === 'DESC' ? $ascendingIcon : $descendingIcon;

        $table = '<table class="w-full text-sm text-left text-gray-500 rounded-b-lg">
        <thead class="text-xs text-gray-500 uppercase">
            <tr class="bg-slate-100 border-b cursor-pointer">
                <th class="px-6 py-4" data-sortable="false">No.</th>
                <th class="px-6 py-4" data-column-name="meter_number" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Meter No.</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="full_name" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Names</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                        <span id="totalItemsSpan" class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer" >' . $totalRecords . '</span>
                    </div>
                </th>
                <input id="totalItemsHidden" type="hidden" value="' . $totalRecords . '">
                <th class="px-6 py-4" data-column-name="property_type" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Property Type</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="brgy" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Address</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="status" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Status</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="billing_status" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Billing Status</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="timestamp" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Applied Date</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-sortable="false">Action</th>
            </tr>
        </thead>';

        $countArr = array();
        $number = ($pageNumber - 1) * $itemPerPage + 1;

        while ($row = mysqli_fetch_assoc($result)) {
            $tableName = "client_application";
            $id = $row['id'];
            $meter_number = $row['meter_number'];
            $name = $row['full_name'];
            $street = $row['street'];
            $brgy = $row['brgy'];
            $property_type = $row['property_type'];
            $status = $row['status'];
            $billingStatus = $row['billing_status'];
            $time = $row['time'];
            $date = $row['date'];

            $readable_date = date("F j, Y", strtotime($date));
            $readable_time = date("h:i A", strtotime($time));

            $approvedBadge = '<span class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Approved</span>';
            $unconfirmedBadge = '<span class="bg-yellow-100 text-yellow-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Unconfirmed</span>';
            $confirmedBadge = '<span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Confirmed</span>';
            $statusBadge = ($status === 'approved') ? $approvedBadge : (($status === 'confirmed') ? $confirmedBadge : ($status === 'unconfirmed' ? $unconfirmedBadge : ''));

            $page = 'client_application_review.php';

            $table .= '<tr onclick="openPage(event, ' . $id . ', \'' . $page . '\')" data-client-id="' . $id . '" class="table-auto bg-white border-b hover:bg-gray-50  overflow-auto">
            <td  class="px-6 py-3 text-sm">' . $number . '</td>
            <td class="px-6 py-3 text-sm">' . $meter_number . '</td>
            <td class="px-6 py-3 text-sm">' . $name . '</td>
            <td class="px-6 py-3 text-sm">' . $property_type . '</td>
            <td class="px-6 py-3 text-sm"> 
                <span class="font-medium text-sm">' . $brgy . '</span> </br>
                <span class="text-xs text-gray-400">' . $street . '</span>
            </td>
            <td class="px-6 py-3 text-sm">' . $statusBadge . '</td>
            <td class="px-6 py-3 text-sm">' . $billingStatus . '</td>
            <td class="px-6 py-3 text-sm">            
                <span class="font-medium text-sm">' . $readable_date . '</span> </br>
                <span class="text-xs">' . $readable_time . '</span>
            </td>

            <td class="flex items-center px-6 py-4 space-x-3">
                <a href="./client_application_review.php?id=' . $id . '" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                <span class="sr-only">Icon description</span>
                </a>
                <button  onclick="deleteClientApplication(' . $id . ', \'' . $tableName . '\')" type="button" class="delete-client text-white bg-red-700 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16px" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                <span class="sr-only">Icon description</span>
                </button>
            </td>
        </tr>';
            array_push($countArr, $number);
            $number++;
        }

        $start = 0;
        $end = 0;

        if (!empty($countArr)) {
            $start = $countArr[0];
            $end = end($countArr);

            $table .= '</tbody></table>';

            if ($number > 1) {
                echo $table;
            } else {
                echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">No client found</div>';
            }
        } else {
            echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">No client found</div>';
        }

        echo '<input data-hidden-name="start" type="hidden" value="' . $start . '">';
        echo '<input data-hidden-name="end" type="hidden" value="' . $end . '">';
    }


    //CLIENT-TABLE
    public function clientTable($dataTableParam)
    {
        $pageNumber = $dataTableParam['pageNumber'];
        $itemPerPage = $dataTableParam['itemPerPage'];
        $searchTerm = isset($dataTableParam['searchTerm']) ? $dataTableParam['searchTerm'] : "";
        $offset = ($pageNumber - 1) * $itemPerPage;
        $sortColumn = isset($dataTableParam['sortColumn']) ? $dataTableParam['sortColumn'] : "timestamp";
        $sortDirection = isset($dataTableParam['sortDirection']) ? $dataTableParam['sortDirection'] : "DESC";
        $filters = isset($dataTableParam['filters']) ? $dataTableParam['filters'] : [];
        $conditions = [];
        $params = [];
        $types = "";

        if ($searchTerm) {
            $likeTerm = "%" . $searchTerm . "%";
            $conditions[] = "(full_name LIKE ? OR client_id LIKE ? OR meter_number LIKE ? OR street LIKE ? OR brgy LIKE ? OR property_type LIKE ? OR status LIKE ?)";
            $params = array_merge($params, [$likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm]);
            $types .= "sssssss";
        }

        if (!empty($filters)) {
            foreach ($filters as $filter) {
                $conditions[] = "{$filter['column']} = ?";
                $params[] = $filter['value'];
                $types .= "s";  // Assuming all filter values are strings, adjust if not
            }
        }

        if (!empty($conditions)) {
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM client_data WHERE " . implode(" AND ", $conditions);
        } else {
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM client_data";
        }

        $validColumns = [
            'client_id', 'meter_number', 'full_name', 'property_type', 'brgy',
            'status', 'timestamp'
        ];
        $validDirections = ['ASC', 'DESC'];

        if (in_array($sortColumn, $validColumns) && in_array($sortDirection, $validDirections)) {
            $sql .= " ORDER BY {$sortColumn} {$sortDirection}";
        } else {
            $sql .= " ORDER BY timestamp DESC";
        }

        $sql .= " LIMIT ? OFFSET ?";
        $params = array_merge($params, [$itemPerPage, $offset]);
        $types .= "ii";

        $stmt = $this->conn->prepareStatement($sql);
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $resultCount = $this->conn->query("SELECT FOUND_ROWS() as total");

        if ($resultCount && $row = mysqli_fetch_assoc($resultCount)) {
            $totalRecords = $row['total'];
        } else {
            $totalRecords = 0;
        }


        $ascendingIcon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
    </svg>';

        $descendingIcon = ' <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
    </svg>';

        $sortIcon = $sortDirection === 'DESC' ? $ascendingIcon : $descendingIcon;
        $table = '<table class="w-full text-sm text-left text-gray-500 rounded-b-lg">

        
        <thead class="text-xs text-gray-500 uppercase">
            <tr class="bg-slate-100 border-b cursor-pointer">
                <th class="px-6 py-4" data-sortable="false">No.</th>
                <th class="px-6 py-4" data-column-name="client_id" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Client ID</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="meter_number" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Meter No.</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="full_name" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Names</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                        <span id="totalItemsSpan" class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer">' . $totalRecords . '</span></th>
                    </div>
                <input id="totalItemsHidden" type="hidden" value="' . $totalRecords . '">
                <th class="px-6 py-4" data-column-name="property_type" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Property Type</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="brgy" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Address</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="status" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Status</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="timestamp" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Joined</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-sortable="false">Action</th>
            </tr>
        </thead>';

        $countArr = array();
        $number = ($pageNumber - 1) * $itemPerPage + 1;

        while ($row = mysqli_fetch_assoc($result)) {
            $tableName = "client_data";
            $id = $row['id'];
            $clientID = $row['client_id'];
            $meter_number = $row['meter_number'];
            $name = $row['full_name'];
            $street = $row['street'];
            $brgy = $row['brgy'];
            $property_type = $row['property_type'];
            $status = $row['status'];
            $time = $row['time'];
            $date = $row['date'];

            $readable_date = date("F j, Y", strtotime($date));
            $readable_time = date("h:i A", strtotime($time));

            $activeBadge = '<span class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Active</span>';
            $inactiveBadge = '<span class="bg-yellow-100 text-yellow-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Inactive</span>';
            $statusBadge = ($status === 'active') ? $activeBadge : (($status === 'inactive' ? $inactiveBadge : ''));

            $table .= '<tr class="table-auto data-id="' . $id . '" bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 overflow-auto">
            <td  class="px-6 py-3 text-sm">' . $number . '</td>
            <td  class="px-6 py-3 text-sm">' . $clientID . '</td>
            <td class="px-6 py-3 text-sm">' . $meter_number . '</td>
            <td class="px-6 py-3 text-sm">' . $name . '</td>
            <td class="px-6 py-3 text-sm">' . $property_type . '</td>
            <td class="px-6 py-3 text-sm"> 
                <span class="font-medium text-sm">' . $brgy . '</span> </br>
                <span class="text-xs text-gray-400">' . $street . '</span>
            </td>
            <td class="px-6 py-3 text-sm">' . $statusBadge . '</td>
            <td class="px-6 py-3 text-sm">            
                <span class="font-medium text-sm">' . $readable_date . '</span> </br>
                <span class="text-xs">' . $readable_time . '</span>
            </td>

            <td class="flex items-center px-6 py-4 space-x-3">
                <button onclick="openViewClientModal(\'' . $clientID . '\')" type="button" title="View Client" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                <span class="sr-only">Icon description</span>
                </button>
                <button onclick="deleteClient(' . $id . ', \'' . $tableName . '\')" type="button" class="delete-client text-white bg-red-700 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16px" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                <span class="sr-only">Icon description</span>
                </button>

                <button  onclick="clientActions(\'' . $clientID . '\')"  class="delete-client text-gray-800 bg-gray-200 hover:bg-gray-200 focus:ring-2 focus:outline-none focus:ring-gray-200 font-medium rounded-full text-sm p-2 text-center inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                    </svg>
                
                    <span class="sr-only">Icon description</span>
                </button>
            </td>
        </tr>';
            array_push($countArr, $number);
            $number++;
        }

        $start = 0;
        $end = 0;

        if (!empty($countArr)) {
            $start = $countArr[0];
            $end = end($countArr);

            $table .= '</tbody></table>';

            if ($number > 1) {
                echo $table;
            } else {
                echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">No client application found</div>';
            }
        } else {
            echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">No client application found</div>';
        }

        echo '<input data-hidden-name="start" type="hidden" value="' . $start . '">';
        echo '<input data-hidden-name="end" type="hidden" value="' . $end . '">';
    }
}
