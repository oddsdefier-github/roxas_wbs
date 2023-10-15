<?php

use MeterReader\Database\DatabaseConnection;

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
    public function retrieveClientData($clientId)
    {
        $response = array();

        $sql = "SELECT * FROM client_data WHERE client_id = ?";
        $stmt = $this->conn->prepareStatement($sql);
        mysqli_stmt_bind_param($stmt, "s", $clientId);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $response['full_name'] = $row['full_name'];
                $response['meter_number'] = $row['meter_number'];
                $response['status'] = $row['status'];
                $response['property_type'] = $row['property_type'];
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
}


class DataTable extends BaseQuery
{
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
                <th class="px-6 py-4">Previous Billing</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4">Action</th>
            </tr>
        </thead>';

        $countArr = array();
        $number = ($pageNumber - 1) * $itemPerPage + 1;

        while ($row = mysqli_fetch_assoc($result)) {
            $tableName = "client_data";
            $client_id = $row['client_id'];
            $id = $row['id'];
            $meter_number = $row['meter_number'];
            $name = $row['full_name'];
            $property_type = $row['property_type'];
            $status = $row['status'];

            $table .= '<tr class="table-auto data-id="' . $id . '" bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 overflow-auto">
            <td  class="px-6 py-3 text-sm">' . $number . '</td>
            <td class="px-6 py-3 text-sm">' . $meter_number . '</td>
            <td class="px-6 py-3 text-sm">' . $name . '</td>
            <td class="px-6 py-3 text-sm">' . $property_type . '</td>
            <td class="px-6 py-3 text-sm">' . $status . '</td>
            <td class="px-6 py-3 text-sm">' . $status . '</td>

            <td class="flex items-center px-6 py-4 space-x-3">
                <button  title="Encode Reading" onclick="encodeReadingData(\'' . $client_id . '\')" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                <span class="sr-only">Icon description</span>
                </button>
                <button title="View Reading" onclick="viewReadingData(' . $id . ', \'' . $tableName . '\')" class="text-white bg-green-400 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
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
