<?php

include 'database/connection.php';

class DatabaseQueries
{
    private $conn;
    public function setConnection($databaseConnection)
    {
        $this->conn = $databaseConnection;
    }

    public function retrieveClientData($clientId)
    {
        $response = array();

        $sql = "SELECT * FROM `clients` WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $clientId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $clientRow = mysqli_fetch_assoc($result);
        if ($clientRow) {
            $response['clientData'] = $clientRow;
        }
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);

        $addressArray = array();

        $addressSql = "SELECT * FROM `address`";
        $addressStmt = mysqli_prepare($this->conn, $addressSql);
        mysqli_stmt_execute($addressStmt);
        $addressResult = mysqli_stmt_get_result($addressStmt);


        $addressArray = array();

        while ($addressRow = mysqli_fetch_assoc($addressResult)) {
            $addressArray[] = $addressRow;
        }

        mysqli_stmt_close($addressStmt);

        $response['addressData'] = $addressArray;

        return $response;
    }

    public function processClientApplication(
        $formData,

    ) {
        $response = array();
        // Sanitize and validate input data

        $meterNumber = htmlspecialchars($formData['meterNumber'], ENT_QUOTES, 'UTF-8');
        $firstName = htmlspecialchars($formData['firstName'], ENT_QUOTES, 'UTF-8');
        $middleName = htmlspecialchars($formData['middleName'], ENT_QUOTES, 'UTF-8');
        $lastName = htmlspecialchars($formData['lastName'], ENT_QUOTES, 'UTF-8');
        $fullName = htmlspecialchars($formData['fullName'], ENT_QUOTES, 'UTF-8');
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
        $country = htmlspecialchars($formData['country'], ENT_QUOTES, 'UTF-8');
        $fullAddress = htmlspecialchars($formData['fullAddress'], ENT_QUOTES, 'UTF-8');
        $validID = htmlspecialchars($formData['validID'], ENT_QUOTES, 'UTF-8');
        $proofOfOwnership = htmlspecialchars($formData['proofOfOwnership'], ENT_QUOTES, 'UTF-8');
        $deedOfSale = htmlspecialchars($formData['deedOfSale'], ENT_QUOTES, 'UTF-8');
        $affidavit = htmlspecialchars($formData['affidavit'], ENT_QUOTES, 'UTF-8');


        $sql = "INSERT INTO client_application (meter_number, first_name, middle_name, last_name, full_name, email, phone_number, age, gender, property_type, street, brgy, municipality, province, region, country, full_address, valid_id, proof_of_ownership, deed_of_sale, affidavit, time, date, timestamp ) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?, ?, ?, ?, ?, ?, ?,CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";

        $stmt = mysqli_prepare($this->conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt,
                "sssssssssssssssssssss",
                $meterNumber,
                $firstName,
                $middleName,
                $lastName,
                $fullName,
                $email,
                $phoneNumber,
                $age,
                $gender,
                $propertyType,
                $streetAddress,
                $brgy,
                $municipality,
                $province,
                $region,
                $country,
                $fullAddress,
                $validID,
                $proofOfOwnership,
                $deedOfSale,
                $affidavit,
            );


            if (mysqli_stmt_execute($stmt)) {
                $response['success'] = "Application submitted successfully.";
            } else {
                $response['error'] = "Error executing the query: " . mysqli_error($this->conn);
            }

            mysqli_stmt_close($stmt);
        } else {
            $response['error'] = "Error preparing the statement: " . mysqli_error($this->conn);
        }

        return $response;
    }

    public function updateClient()
    {
    }
    public function deleteClient()
    {
    }
}


if ($conn) {
    $dbQueries = new DatabaseQueries();
    $dbQueries->setConnection($conn);
} else {
    echo "Database connection failed.";
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'retrieveClientData') {
        if (isset($_POST['updateId'])) {
            $client_id = $_POST['updateId'];
            $client_data = $dbQueries->retrieveClientData($client_id);
            echo json_encode($client_data);
        }
    } elseif ($action == 'processClientApplication') {
        if (isset($_POST['formData'])) {
            $formData = $_POST['formData'];
            $processResponse = $dbQueries->processClientApplication($formData);
            echo json_encode($processResponse);
        }
    }
}
