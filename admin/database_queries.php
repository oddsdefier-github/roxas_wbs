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


    public function processClientApplication($formData)
    {
        $response = array();
        // Sanitize and validate input data

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

        $status = 'pending';

        $checkDuplicateMeterNo = "SELECT meter_number FROM client_application WHERE meter_number = ?";
        $stmt = $this->conn->prepareStatement($checkDuplicateMeterNo);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $meterNumber);

            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                $response = array(
                    "status" => "error",
                    "inputName" => "meterNumber",
                    "message" => "Meter No: " . $meterNumber . " already exists in the database."
                );
            } else {
                $checkDuplicate = "SELECT email FROM client_application WHERE email = ?";
                $stmt = $this->conn->prepareStatement($checkDuplicate);

                if ($stmt) {

                    mysqli_stmt_bind_param($stmt, "s", $email);

                    mysqli_stmt_execute($stmt);

                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) > 0) {
                        $response = array(
                            "status" => "error",
                            "inputName" => "email",
                            "message" => $email . " already exists in the database."
                        );
                    } else {

                        $applicationID = 'A' . date("YmdHis");
                        $sql = "INSERT INTO client_application (meter_number, first_name, middle_name, last_name, name_suffix, full_name, email, phone_number, birthdate, age, gender, property_type, street, brgy, municipality, province, region, full_address, valid_id, proof_of_ownership, deed_of_sale, affidavit, status, application_id, time, date, timestamp ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";

                        $stmt = $this->conn->prepareStatement($sql);

                        if ($stmt) {
                            mysqli_stmt_bind_param(
                                $stmt,
                                "ssssssssssssssssssssssss",
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
                                $status,
                                $applicationID
                            );

                            if (mysqli_stmt_execute($stmt)) {
                                $response = array(
                                    "applicant" => $firstName,
                                    "status" => "success",
                                    "message" => $firstName . "'s application submitted successfully."
                                );
                            } else {
                                $response = array(
                                    "status" => "error",
                                    "message" => "Error executing the query: " . $this->conn->getErrorMessage()
                                );
                            }

                            mysqli_stmt_close($stmt);
                        } else {
                            $response = array(
                                "status" => "error",
                                "message" => "Error preparing the statement: " . $this->conn->getErrorMessage()
                            );
                        }
                    }
                }
            }
            return $response;
        } else {
            $response = array(
                "status" => "error",
                "error" => "Error in preparing the statement: " . $this->conn->getErrorMessage()
            );
        }
        return $response;
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

    public function approveClientApplication($formData)
    {
        $response = array();

        $applicationID = htmlspecialchars($formData['applicationID'], ENT_QUOTES, 'UTF-8');
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


        $checkDuplicateMeterNo = "SELECT meter_number FROM client_data WHERE meter_number = ?";
        $stmt = $this->conn->prepareStatement($checkDuplicateMeterNo);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $meterNumber);

            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                $response = array(
                    "status" => "error",
                    "inputName" => "meterNumber",
                    "message" => "Meter No: " . $meterNumber . " already exists in the client_data database."
                );
            } else {
                $checkDuplicate = "SELECT email FROM client_data WHERE email = ?";
                $stmt = $this->conn->prepareStatement($checkDuplicate);

                if ($stmt) {

                    mysqli_stmt_bind_param($stmt, "s", $email);

                    mysqli_stmt_execute($stmt);

                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) > 0) {
                        $response = array(
                            "status" => "error",
                            "inputName" => "email",
                            "message" => $email . " already exists in the database."
                        );
                    } else {
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


                        $status = "active";
                        $readingStatus = "pending";

                        $registrationId = 'R' . date("YmdHis");

                        $sql = "INSERT INTO client_data (client_id, reg_id, meter_number, full_name, email, phone_number, birthdate, age, property_type, street, brgy, full_address, status, reading_status, application_id, time, date, timestamp ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";

                        $stmt = $this->conn->prepareStatement($sql);

                        if ($stmt) {
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
                                $status = 'approved';
                                $sql = "UPDATE client_application SET status = ? WHERE application_id = ?";
                                $stmt = $this->conn->prepareStatement($sql);

                                if ($stmt) {
                                    $stmt->bind_param("ss", $status, $applicationID);

                                    if ($stmt->execute()) {
                                        $insert_sec_data = "INSERT INTO client_secondary_data (client_id, first_name, middle_name, last_name, name_suffix, property_type, gender, street, brgy, municipality, province, region, valid_id, proof_of_ownership, deed_of_sale, affidavit, time, date, timestamp) VALUES (?, ?, ?, ?, ?, ?, ?,?, ?, ?,?, ?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";
                                        $stmt = $this->conn->prepareStatement($insert_sec_data);

                                        if ($stmt) {
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

                                                session_start();
                                                $encoder = $_SESSION['admin_name'];

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
                                                $consumption = NULL;
                                                $rates = NULL;
                                                $billingAmount = 0;

                                                $currentDate = new DateTime();
                                                $billingMonthAndYear = $currentDate->format('F Y');

                                                $sql_billing = "INSERT INTO billing_data (billing_id, client_id, prev_reading, curr_reading, reading_type, consumption, rates, billing_amount, billing_status, billing_month, due_date, disconnection_date, period_to, period_from, encoder, time, date, timestamp ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";
                                                $stmt_billing = $this->conn->prepareStatement($sql_billing);

                                                // HERE WERE USING THE SAME VALUE FOR PERIOD TO AND PERIOD FROM FRO INITIALIZATION
                                                if ($stmt_billing) {
                                                    mysqli_stmt_bind_param(
                                                        $stmt_billing,
                                                        "ssiisssisssssss",
                                                        $billingID,
                                                        $clientID,
                                                        $prevReading,
                                                        $initialReading,
                                                        $readingType,
                                                        $consumption,
                                                        $rates,
                                                        $billingAmount,
                                                        $billingStatus,
                                                        $billingMonthAndYear,
                                                        $dueDate,
                                                        $disconnectionDate,
                                                        $periodFrom,
                                                        $periodFrom,
                                                        $encoder
                                                    );


                                                    if (mysqli_stmt_execute($stmt_billing)) {
                                                        $response = array(
                                                            "status" => "success",
                                                            "message" => $firstName . "'s application has been approved.",
                                                            "client_id" => $clientID,
                                                            "reg_id" => $registrationId,
                                                            "name" => $fullName,
                                                            "address" => $fullAddress,
                                                            "age" => $age,
                                                            "property_type" => $propertyType,
                                                            "meter_number" => $meterNumber,
                                                            "date" => date('F j, Y')
                                                        );
                                                    } else {
                                                        $response = array(
                                                            "status" => "error",
                                                            "message" => "Error inserting initial reading: " . $stmt_billing->error
                                                        );
                                                    }
                                                    $stmt_billing->close();
                                                } else {
                                                    $response = array(
                                                        "status" => "error",
                                                        "message" => "Error preparing billing statement: " . $this->conn->getErrorMessage()
                                                    );
                                                }
                                            }
                                        } else {
                                            $response = array(
                                                "status" => "error",
                                                "message" => "Error preparing statement: " . $this->conn->getErrorMessage()
                                            );
                                        }
                                    } else {
                                        $response = array(
                                            "status" => "error",
                                            "message" => "Error updating status: " . $this->conn->getErrorMessage()
                                        );
                                    }
                                } else {
                                    $response = array(
                                        "status" => "error",
                                        "message" => "Error preparing statement: " . $this->conn->getErrorMessage()
                                    );
                                }
                            } else {
                                $response = array(
                                    "status" => "error",
                                    "message" => "Error executing the query: " . $this->conn->getErrorMessage()
                                );
                            }
                            mysqli_stmt_close($stmt);
                        } else {
                            $response = array(
                                "status" => "error",
                                "message" => "Error preparing the statement: " . $this->conn->getErrorMessage()
                            );
                        }
                    }
                }
            }
            return $response;
        } else {
            $response = array(
                "status" => "error",
                "error" => "Error in preparing the statement: " . $this->conn->getErrorMessage()
            );
        }
        return $response;
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

    // public function setInitialBillingData($regID)
    // {
    //     $response = array();
    //     $initialReading = 0;

    //     session_start();
    //     $encoder = $_SESSION['admin_name'];

    //     $billingID = "B" . time();
    //     $readingType = 'current';
    //     $dueDate = NULL;
    //     $billingStatus = NULL;
    //     $consumption = NULL;
    //     $month = date('M');
    //     $year = date('Y');
    //     $billingMonthAndYear = $month . '-' . $year;

    //     $sql_billing = "INSERT INTO billing_data (billing_id, reg_id, meter_reading, reading_type, consumption, billing_status, billing_month, due_date, encoder, time, date, timestamp ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";
    //     $stmt_billing = $this->conn->prepareStatement($sql_billing);

    //     if ($stmt_billing) {
    //         mysqli_stmt_bind_param($stmt_billing, "ssissssss", $billingID, $regID, $initialReading, $readingType, $consumption, $billingStatus, $billingMonthAndYear, $dueDate, $encoder);
    //         if (mysqli_stmt_execute($stmt_billing)) {
    //             $response["message"] = $billingID;
    //         } else {
    //             $response = array(
    //                 "status" => "error",
    //                 "message" => "Error inserting initial reading: " . $stmt_billing->error
    //             );
    //         }
    //         $stmt_billing->close();
    //     } else {
    //         $response = array(
    //             "status" => "error",
    //             "message" => "Error preparing billing statement: " . $this->conn->getErrorMessage()
    //         );
    //     }

    //     return $response;
    // }
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

        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM client_application";
        if ($searchTerm) {
            $likeTerm = "%" . $searchTerm . "%";
            $sql .= " WHERE (full_name LIKE ? OR meter_number LIKE ? OR street LIKE ? OR brgy LIKE ? OR property_type LIKE ? OR status LIKE ?)";
        }

        $sql .= " ORDER BY timestamp DESC LIMIT ? OFFSET ?";

        if ($searchTerm) {
            $stmt = $this->conn->prepareStatement($sql);
            mysqli_stmt_bind_param($stmt, "ssssssii", $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $itemPerPage, $offset);
        } else {
            $stmt = $this->conn->prepareStatement($sql);
            mysqli_stmt_bind_param($stmt, "ii", $itemPerPage, $offset);
        }


        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // More efficient way to get total records
        $resultCount = $this->conn->query("SELECT FOUND_ROWS() as total");

        if ($resultCount && $row = mysqli_fetch_assoc($resultCount)) {
            $totalRecords = $row['total'];
        } else {
            $totalRecords = 0;
        }

        $table = '<table class="w-full text-sm text-left text-gray-500 rounded-b-lg">
        <thead class="text-xs text-gray-500 uppercase">
            <tr class="bg-slate-100 border-b">
                <th class="px-6 py-4">No.</th>
                <th class="px-6 py-4">Meter No.</th>
                <th class="px-6 py-4">Names&nbsp;&nbsp; 
                <span id="totalItemsSpan" class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer">' . $totalRecords . '</span></th>
                <input id="totalItemsHidden" type="hidden" value="' . $totalRecords . '">
                <th class="px-6 py-4">Property Type</th>
                <th class="px-6 py-4">Address</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4">DateTime</th>
                <th class="px-6 py-4">Action</th>
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
            $time = $row['time'];
            $date = $row['date'];

            $readable_date = date("F j, Y", strtotime($date));
            $readable_time = date("h:i A", strtotime($time));



            $table .= '<tr data-id="' . $id . '" class="table-auto bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 overflow-auto">
            <td  class="px-6 py-3 text-sm">' . $number . '</td>
            <td class="px-6 py-3 text-sm">' . $meter_number . '</td>
            <td class="px-6 py-3 text-sm">' . $name . '</td>
            <td class="px-6 py-3 text-sm">' . $property_type . '</td>
            <td class="px-6 py-3 text-sm"> 
                <span class="font-medium text-sm">' . $brgy . '</span> </br>
                <span class="text-xs text-gray-400">' . $street . '</span>
            </td>
            <td class="px-6 py-3 text-sm">' . $status . '</td>
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
                echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4">No client found</div>';
            }
        } else {
            echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4">No client found</div>';
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

        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM client_data";
        if ($searchTerm) {
            $likeTerm = "%" . $searchTerm . "%";
            $sql .= " WHERE full_name LIKE ? OR meter_number LIKE ? OR street LIKE ? OR brgy LIKE ? OR property_type LIKE ? OR status LIKE ?";
        }
        $sql .= " ORDER BY timestamp DESC LIMIT ? OFFSET ?";

        if ($searchTerm) {
            $stmt = $this->conn->prepareStatement($sql);
            mysqli_stmt_bind_param($stmt, "ssssssii", $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $itemPerPage, $offset);
        } else {
            $stmt = $this->conn->prepareStatement($sql);
            mysqli_stmt_bind_param($stmt, "ii", $itemPerPage, $offset);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // More efficient way to get total records
        $resultCount = $this->conn->query("SELECT FOUND_ROWS() as total");

        if ($resultCount && $row = mysqli_fetch_assoc($resultCount)) {
            $totalRecords = $row['total'];
        } else {
            $totalRecords = 0;
        }

        $table = '<table class="w-full text-sm text-left text-gray-500 rounded-b-lg">
        <thead class="text-xs text-gray-500 uppercase">
            <tr class="bg-slate-100 border-b">
                <th class="px-6 py-4">No.</th>
                <th class="px-6 py-4">Meter No.</th>
                <th class="px-6 py-4">Names&nbsp;&nbsp; 
                <span id="totalItemsSpan" class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer">' . $totalRecords . '</span></th>
                <input id="totalItemsHidden" type="hidden" value="' . $totalRecords . '">
                <th class="px-6 py-4">Property Type</th>
                <th class="px-6 py-4">Address</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4">DateTime</th>
                <th class="px-6 py-4">Action</th>
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

            $table .= '<tr class="table-auto data-id="' . $id . '" bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 overflow-auto">
            <td  class="px-6 py-3 text-sm">' . $number . '</td>
            <td class="px-6 py-3 text-sm">' . $meter_number . '</td>
            <td class="px-6 py-3 text-sm">' . $name . '</td>
            <td class="px-6 py-3 text-sm">' . $property_type . '</td>
            <td class="px-6 py-3 text-sm"> 
                <span class="font-medium text-sm">' . $brgy . '</span> </br>
                <span class="text-xs text-gray-400">' . $street . '</span>
            </td>
            <td class="px-6 py-3 text-sm">' . $status . '</td>
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
                echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4">No client found</div>';
            }
        } else {
            echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4">No client found</div>';
        }

        echo '<input data-hidden-name="start" type="hidden" value="' . $start . '">';
        echo '<input data-hidden-name="end" type="hidden" value="' . $end . '">';
    }



    //BILLING-FROM-READING
    public function clientBillingTable($dataTableParam)
    {
        $pageNumber = $dataTableParam['pageNumber'];
        $itemPerPage = $dataTableParam['itemPerPage'];
        $searchTerm = isset($dataTableParam['searchTerm']) ? $dataTableParam['searchTerm'] : "";
        $offset = ($pageNumber - 1) * $itemPerPage;


        $sql = "SELECT SQL_CALC_FOUND_ROWS b.*, c.client_name 
        FROM billing AS b
        LEFT JOIN client_data AS c ON b.client_id = c.client_id";

        if ($searchTerm) {
            $likeTerm = "%" . $searchTerm . "%";
            $sql .= " WHERE b.billing_id LIKE ? OR c.client_name LIKE ? OR b.previous_reading LIKE ? OR b.current_reading LIKE ? OR b.consumption LIKE ? OR b.billing_status LIKE ?";
        }
        $sql .= " ORDER BY b.timestamp DESC LIMIT ? OFFSET ?";

        if ($searchTerm) {
            $stmt = $this->conn->prepareStatement($sql);
            mysqli_stmt_bind_param($stmt, "sssssssi", $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $itemPerPage, $offset);
        } else {
            $stmt = $this->conn->prepareStatement($sql);
            mysqli_stmt_bind_param($stmt, "ii", $itemPerPage, $offset);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // More efficient way to get total records
        $resultCount = $this->conn->query("SELECT FOUND_ROWS() as total");

        if ($resultCount && $row = mysqli_fetch_assoc($resultCount)) {
            $totalRecords = $row['total'];
        } else {
            $totalRecords = 0;
        }

        $table = '<table class="w-full text-sm text-left text-gray-500 rounded-b-lg">
        <thead class="text-xs text-gray-500 uppercase">
            <tr class="bg-slate-100 border-b">
                <th class="px-6 py-4">No.</th>
                <th class="px-6 py-4">Billing ID</th>
                <th class="px-6 py-4">Client Names&nbsp;&nbsp; 
                <span id="totalItemsSpan" class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer">' . $totalRecords . '</span></th>
                <input id="totalItemsHidden" type="hidden" value="' . $totalRecords . '">
                <th class="px-6 py-4">Property Type</th>
                <th class="px-6 py-4">Consumption</th>
                <th class="px-6 py-4">Rates</th>
                <th class="px-6 py-4">Amount Due</th>
                <th class="px-6 py-4">Due Data</th>
                <th class="px-6 py-4">Date Time</th>
                <th class="px-6 py-4">Action</th>
            </tr>
        </thead>';

        $countArr = array();
        $number = ($pageNumber - 1) * $itemPerPage + 1;

        while ($row = mysqli_fetch_assoc($result)) {
            $tableName = "client_application";
            $id = $row['id'];
            $billing_id = $row['meter_number'];
            $client_name = $row['full_name'];
            $property_type = $row['property_type'];
            $consumption = $row['current_reading'];
            $billing_status = $row['status'];
            $time = $row['time'];
            $date = $row['date'];

            $readable_date = date("F j, Y", strtotime($date));
            $readable_time = date("h:i A", strtotime($time));

            $table .= '<tr data-id="' . $id . '" class="table-auto bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 overflow-auto">
            <td  class="px-6 py-3 text-sm">' . $number . '</td>
            <td class="px-6 py-3 text-sm">' . $billing_id . '</td>
            <td class="px-6 py-3 text-sm">' . $client_name . '</td>
            <td class="px-6 py-3 text-sm">' . $property_type . '</td>
            <td class="px-6 py-3 text-sm">' . $consumption . '</td>
            <td class="px-6 py-3 text-sm">' . $billing_status . '</td>
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
                echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4">No client found</div>';
            }
        } else {
            echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4">No client found</div>';
        }

        echo '<input data-hidden-name="start" type="hidden" value="' . $start . '">';
        echo '<input data-hidden-name="end" type="hidden" value="' . $end . '">';
    }


    //BILLING-FROM-APPLICATION
    public function clientApplicationBillingTable($dataTableParam)
    {
        $pageNumber = $dataTableParam['pageNumber'];
        $itemPerPage = $dataTableParam['itemPerPage'];
        $searchTerm = isset($dataTableParam['searchTerm']) ? $dataTableParam['searchTerm'] : "";
        $offset = ($pageNumber - 1) * $itemPerPage;


        $sql = "SELECT SQL_CALC_FOUND_ROWS b.*, c.client_name 
            FROM billing AS b
            LEFT JOIN client_data AS c ON b.client_id = c.client_id";

        if ($searchTerm) {
            $likeTerm = "%" . $searchTerm . "%";
            $sql .= " WHERE b.billing_id LIKE ? OR c.client_name LIKE ? OR b.previous_reading LIKE ? OR b.current_reading LIKE ? OR b.consumption LIKE ? OR b.billing_status LIKE ?";
        }
        $sql .= " ORDER BY b.timestamp DESC LIMIT ? OFFSET ?";

        if ($searchTerm) {
            $stmt = $this->conn->prepareStatement($sql);
            mysqli_stmt_bind_param($stmt, "sssssssi", $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $itemPerPage, $offset);
        } else {
            $stmt = $this->conn->prepareStatement($sql);
            mysqli_stmt_bind_param($stmt, "ii", $itemPerPage, $offset);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // More efficient way to get total records
        $resultCount = $this->conn->query("SELECT FOUND_ROWS() as total");

        if ($resultCount && $row = mysqli_fetch_assoc($resultCount)) {
            $totalRecords = $row['total'];
        } else {
            $totalRecords = 0;
        }

        $table = '<table class="w-full text-sm text-left text-gray-500 rounded-b-lg">
            <thead class="text-xs text-gray-500 uppercase">
                <tr class="bg-slate-100 border-b">
                    <th class="px-6 py-4">No.</th>
                    <th class="px-6 py-4">Billing ID</th>
                    <th class="px-6 py-4">Client Names&nbsp;&nbsp; 
                    <span id="totalItemsSpan" class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer">' . $totalRecords . '</span></th>
                    <input id="totalItemsHidden" type="hidden" value="' . $totalRecords . '">
                    <th class="px-6 py-4">Property Type</th>
                    <th class="px-6 py-4">Consumption</th>
                    <th class="px-6 py-4">Rates</th>
                    <th class="px-6 py-4">Amount Due</th>
                    <th class="px-6 py-4">Due Data</th>
                    <th class="px-6 py-4">Date Time</th>
                    <th class="px-6 py-4">Action</th>
                </tr>
            </thead>';

        $countArr = array();
        $number = ($pageNumber - 1) * $itemPerPage + 1;

        while ($row = mysqli_fetch_assoc($result)) {
            $tableName = "client_application";
            $id = $row['id'];
            $billing_id = $row['meter_number'];
            $client_name = $row['full_name'];
            $property_type = $row['property_type'];
            $consumption = $row['current_reading'];
            $billing_status = $row['status'];
            $time = $row['time'];
            $date = $row['date'];

            $readable_date = date("F j, Y", strtotime($date));
            $readable_time = date("h:i A", strtotime($time));

            $table .= '<tr data-id="' . $id . '" class="table-auto bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 overflow-auto">
                <td  class="px-6 py-3 text-sm">' . $number . '</td>
                <td class="px-6 py-3 text-sm">' . $billing_id . '</td>
                <td class="px-6 py-3 text-sm">' . $client_name . '</td>
                <td class="px-6 py-3 text-sm">' . $property_type . '</td>
                <td class="px-6 py-3 text-sm">' . $consumption . '</td>
                <td class="px-6 py-3 text-sm">' . $billing_status . '</td>
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
                echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4">No client found</div>';
            }
        } else {
            echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4">No client found</div>';
        }

        echo '<input data-hidden-name="start" type="hidden" value="' . $start . '">';
        echo '<input data-hidden-name="end" type="hidden" value="' . $end . '">';
    }
}
