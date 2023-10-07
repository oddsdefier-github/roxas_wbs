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
    public function retrieveClientData($clientId)
    {
        $response = array();

        $sql = "SELECT * FROM `clients` WHERE id = ?";
        $stmt = $this->conn->prepareStatement($sql);
        mysqli_stmt_bind_param($stmt, "i", $clientId);
        mysqli_stmt_execute($stmt);
        $result = $this->conn->getResultSet($stmt);

        $clientRow = mysqli_fetch_assoc($result);
        if ($clientRow) {
            $response['clientData'] = $clientRow;
        }
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);

        $addressArray = array();

        $addressSql = "SELECT * FROM `address`";
        $addressStmt = $this->conn->query($addressSql);
        $addressResult = $this->conn->getResultSet($addressStmt);

        $addressArray = array();

        while ($addressRow = mysqli_fetch_assoc($addressResult)) {
            $addressArray[] = $addressRow;
        }

        $this->conn->closeStatement($addressStmt);

        $response['addressData'] = $addressArray;

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

        $status = 'new';

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



    public function approveClientApplication($formData)
    {
        $response = array();
        // Sanitize and validate input data

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
                        $status = "approved";
                        $registrationId = 'R' . date("YmdHis");
                        $sql = "INSERT INTO client_data (reg_id, meter_number, first_name, middle_name, last_name, name_suffix, full_name, email, phone_number, birthdate, age, gender, property_type, street, brgy, municipality, province, region, full_address, valid_id, proof_of_ownership, deed_of_sale, affidavit, status,application_id, time, date, timestamp ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";

                        $stmt = $this->conn->prepareStatement($sql);

                        if ($stmt) {
                            mysqli_stmt_bind_param(
                                $stmt,
                                "sssssssssssssssssssssssss",
                                $registrationId,
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
                                $status = 'approved';
                                $sql = "UPDATE client_application SET status = ? WHERE application_id = ?";
                                $stmt = $this->conn->prepareStatement($sql);

                                if ($stmt) {
                                    $stmt->bind_param("ss", $status, $applicationID);

                                    if ($stmt->execute()) {
                                        $response = array(
                                            "status" => "success",
                                            "message" => $firstName . "'s application has been approved.",
                                            "name" => $fullName,
                                            "address" => $fullAddress,
                                            "age" => $age,
                                            "property_type" => $propertyType,
                                            "registration_id" => $registrationId,
                                            "meter_number" => $meterNumber,
                                            "date" => date('F j, Y')
                                        );
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
    public function getTotalItem($tableName)
    {
        $total = array();
        $sql = "SELECT COUNT(*) FROM $tableName";
        $result = $this->conn->query($sql);

        if ($result) {

            $row = mysqli_fetch_row($result);

            if ($row) {
                $total['totalItem'] = $row[0];
            }
        }
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
}


class DataTable extends BaseQuery
{
    public function clientApplicationTable($dataTableParam)
    {
        $pageNumber = $dataTableParam['pageNumber'];
        $itemPerPage = $dataTableParam['itemPerPage'];
        $searchTerm = isset($dataTableParam['searchTerm']) ? $dataTableParam['searchTerm'] : "";
        $offset = ($pageNumber - 1) * $itemPerPage;

        $sql = "SELECT * FROM client_application";
        if ($searchTerm) {
            $likeTerm = "%" . $searchTerm . "%";
            $sql .= " WHERE full_name LIKE ? OR meter_number LIKE ? OR street LIKE ? OR brgy LIKE ? OR property_type LIKE ?";
        }
        $sql .= " ORDER BY timestamp DESC LIMIT ? OFFSET ?";

        if ($searchTerm) {
            $stmt = $this->conn->prepareStatement($sql);
            mysqli_stmt_bind_param($stmt, "ssssiii", $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $itemPerPage, $offset);
        } else {
            $stmt = $this->conn->prepareStatement($sql);
            mysqli_stmt_bind_param($stmt, "ii", $itemPerPage, $offset);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // More efficient way to get total records
        $sqlCount = "SELECT COUNT(*) as total FROM client_application";
        $resultCount = $this->conn->query($sqlCount);
        $row = mysqli_fetch_assoc($resultCount);
        $totalRecords = $row['total'];

        // $totalPages = ceil($totalRecords / $itemPerPage);

        $table = '<table class="w-full text-sm text-left text-gray-500 rounded-b-lg">
        <thead class="text-xs text-gray-500 uppercase">
            <tr class="bg-slate-100 border-b">
                <th class="px-6 py-4">No.</th>
                <th class="px-6 py-4">Meter No.</th>
                <th class="px-6 py-4">Names&nbsp;&nbsp; 
                <span class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer">' . $totalRecords . '</span></th>
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

            $table .= '<tr class="table-auto bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 overflow-auto">
            <td  class="px-6 py-3 text-sm">' . $number . '</td>
            <td class="px-6 py-3 text-sm">' . $meter_number . '</td>
            <td class="px-6 py-3 text-sm">' . $name . '</td>
            <td class="px-6 py-3 text-sm">' . $property_type . '</td>
            <td class="px-6 py-3 text-sm"> 
                <span class="font-medium text-sm">' . $brgy . '</span> </br>
                <span class="text-xs text-gray-400">' . $street . '</span>
            <td class="px-6 py-3 text-sm">' . $status . '</td>
            <td class="px-6 py-3 text-sm">            
                <span class="font-medium text-sm">' . $readable_date . '</span> </br>
                <span class="text-xs">' . $readable_time . '</span>
            </td>

            <td class="flex items-center px-6 py-4 space-x-3">
                <a href="./client_application_review.php?id=' . $id . '" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                <span class="sr-only">Icon description</span>
                </a>
                <button  onclick="deleteClient(' . $id . ')" type="button" class="delete-client text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
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

        if (empty($countArr)) {
            echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4">No client found</div>';
        } else {
            $start = $countArr[0];
            $end = end($countArr);

            $table .= '</tbody></table>';

            if ($number > 1) {
                echo $table;
            } else {
                echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4">No client found</div>';
            }
            echo  '<input data-hidden-name="start" type="hidden" value=' . $start . '>';
            echo '<input data-hidden-name="end" type="hidden" value=' . $end . '>';
        }
    }


    public function clientTable($dataTableParam)
    {
        $pageNumber = $dataTableParam['pageNumber'];
        $itemPerPage = $dataTableParam['itemPerPage'];
        $searchTerm = isset($dataTableParam['searchTerm']) ? $dataTableParam['searchTerm'] : "";
        $offset = ($pageNumber - 1) * $itemPerPage;

        $sql = "SELECT * FROM client_data";
        if ($searchTerm) {
            $likeTerm = "%" . $searchTerm . "%";
            $sql .= " WHERE full_name LIKE ? OR meter_number LIKE ? OR street LIKE ? OR brgy LIKE ? OR property_type LIKE ?";
        }
        $sql .= " ORDER BY timestamp DESC LIMIT ? OFFSET ?";

        if ($searchTerm) {
            $stmt = $this->conn->prepareStatement($sql);
            mysqli_stmt_bind_param($stmt, "ssssiii", $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $itemPerPage, $offset);
        } else {
            $stmt = $this->conn->prepareStatement($sql);
            mysqli_stmt_bind_param($stmt, "ii", $itemPerPage, $offset);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // More efficient way to get total records
        $sqlCount = "SELECT COUNT(*) as total FROM client_data";
        $resultCount = $this->conn->query($sqlCount);
        $row = mysqli_fetch_assoc($resultCount);
        $totalRecords = $row['total'];

        // $totalPages = ceil($totalRecords / $itemPerPage);

        $table = '<table class="w-full text-sm text-left text-gray-500 rounded-b-lg">
        <thead class="text-xs text-gray-500 uppercase">
            <tr class="bg-slate-100 border-b">
                <th class="px-6 py-4">No.</th>
                <th class="px-6 py-4">Meter No.</th>
                <th class="px-6 py-4">Names&nbsp;&nbsp; 
                <span class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer">' . $totalRecords . '</span></th>
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

            $table .= '<tr class="table-auto bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 overflow-auto">
            <td  class="px-6 py-3 text-sm">' . $number . '</td>
            <td class="px-6 py-3 text-sm">' . $meter_number . '</td>
            <td class="px-6 py-3 text-sm">' . $name . '</td>
            <td class="px-6 py-3 text-sm">' . $property_type . '</td>
            <td class="px-6 py-3 text-sm"> 
                <span class="font-medium text-sm">' . $brgy . '</span> </br>
                <span class="text-xs text-gray-400">' . $street . '</span>
            <td class="px-6 py-3 text-sm">' . $status . '</td>
            <td class="px-6 py-3 text-sm">            
                <span class="font-medium text-sm">' . $readable_date . '</span> </br>
                <span class="text-xs">' . $readable_time . '</span>
            </td>

            <td class="flex items-center px-6 py-4 space-x-3">
                <a href="./client_application_review.php?id=' . $id . '" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                <span class="sr-only">Icon description</span>
                </a>
                <button  onclick="deleteClient(' . $id . ')" type="button" class="delete-client text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
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

        if (empty($countArr)) {
            echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4">No client found</div>';
        } else {
            $start = $countArr[0];
            $end = end($countArr);

            $table .= '</tbody></table>';

            if ($number > 1) {
                echo $table;
            } else {
                echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4">No client found</div>';
            }
            echo  '<input data-hidden-name="start" type="hidden" value=' . $start . '>';
            echo '<input data-hidden-name="end" type="hidden" value=' . $end . '>';
        }
    }
}
