<?php

use Admin\Database\DatabaseConnection;

include 'database/connection.php';

class DatabaseQueries
{
    private $conn;

    public function __construct(DatabaseConnection $databaseConnection)
    {
        $this->conn = $databaseConnection;
    }
    public function retrieveClientData($clientId)
    {
        $response = array();

        $sql = "SELECT * FROM `clients` WHERE id = ?";
        $stmt = $this->conn->prepareStatement($sql); // Use prepareStatement instead of query
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
        $addressStmt = $this->conn->query($addressSql); // Use query method for the address query
        $addressResult = $this->conn->getResultSet($addressStmt);

        $addressArray = array();

        while ($addressRow = mysqli_fetch_assoc($addressResult)) {
            $addressArray[] = $addressRow;
        }

        $this->conn->closeStatement($addressStmt);

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

        $stmt = $this->conn->prepareStatement($sql);

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
                $response['error'] = "Error executing the query: " . $this->conn->getErrorMessage();
            }

            mysqli_stmt_close($stmt);
        } else {
            $response['error'] = "Error preparing the statement: " . $this->conn->getErrorMessage();
        }

        return $response;
    }
    public function clientApplicationTable($dataTableParam)
    {
        $pageNumber = $dataTableParam['pageNumber'];
        $itemPerPage = $dataTableParam['itemPerPage'];

        $offset = ($pageNumber - 1) * $itemPerPage;
        $sql = "SELECT * FROM client_application ORDER BY timestamp DESC LIMIT ? OFFSET ?";

        $stmt = $this->conn->prepareStatement($sql);
        mysqli_stmt_bind_param($stmt, "ii", $itemPerPage, $offset);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $sql = "SELECT * from client_application";
        $totalRecords = mysqli_num_rows($this->conn->query($sql));
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
                <th class="px-6 py-4">Age</th>
                <th class="px-6 py-4">Email</th>
                <th class="px-6 py-4">Phone Number</th>
                <th class="px-6 py-4">Time</th>
                <th class="px-6 py-4">Date</th>
                <th class="px-6 py-4">Action</th>
            </tr>
        </thead>';

        $countArr = array();
        $response = array();
        $number = ($pageNumber - 1) * $itemPerPage + 1;

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $meter_number = $row['meter_number'];
            $name = $row['full_name'];
            $address = $row['street'] . ", " . $row['brgy'];
            $property_type = $row['property_type'];
            $email = $row['email'];
            $phone_number = $row['phone_number'];
            $age = $row['age'];
            $time = $row['time'];
            $date = $row['date'];

            $table .= '<tr class="table-auto bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td  class="px-6 py-3 text-sm">' . $number . '</td>
            <td class="px-6 py-3 text-sm">' . $meter_number . '</td>
            <td class="px-6 py-3 text-sm">' . $name . '</td>
            <td class="px-6 py-3 text-sm">' . $property_type . '</td>
            <td class="px-6 py-3 text-sm">' . $address . '</td>
            <td class="px-6 py-3 text-sm">' . $age . '</td>
            <td class="px-6 py-3 text-sm">' . $email . '</td>
            <td class="px-6 py-3 text-sm">' . $phone_number . '</td>
            <td class="px-6 py-3 text-sm">' . $time . '</td>
            <td class="px-6 py-3 text-sm">' . $date . '</td>

            <td class="flex items-center px-6 py-4 space-x-3">
                <button onclick="updateClient(' . $id . ')" type="button" class="update text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16px" class=" w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                <span class="sr-only">Icon description</span>
                </button>
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

        $start = $countArr[0];
        $end = end($countArr);


        $table .= '</tbody></table>'; // Close table body and table

        if ($number > 1) {
            echo $table;
        } else {
            echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4">No client found</div>';
        }

        $start = '<input data-hidden-name="start" type="hidden" value=' . $start . '>';
        $end = '<input data-hidden-name="end" type="hidden" value=' . $end . '>';
        mysqli_stmt_close($stmt);

        echo $start;
        echo $end;
        return "success";
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
    public function updateClient()
    {
    }
    public function deleteClient()
    {
    }
}


if ($conn) {
    $dbConnection = new DatabaseConnection($host1, $username1, $password1, $database1);
    $dbQueries = new DatabaseQueries($dbConnection);
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
    } elseif ($action == 'getDataTable') {
        if (isset($_POST['dataTableParam'])) {
            $dataTableParam = $_POST['dataTableParam'];
            $html = $dbQueries->clientApplicationTable($dataTableParam);
        }
    } elseif ($action == 'getTotalItem') {
        if (isset($_POST['tableName'])) {
            $tableName = $_POST['tableName'];
            $getTotal = $dbQueries->getTotalItem($tableName);

            echo json_encode($getTotal);
        }
    }
}
