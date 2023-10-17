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
    public function retrieveClientData($clientID)
    {
        $response = array();

        $sqlClient = "SELECT * FROM client_data WHERE client_id = ?";
        try {
            $stmt = $this->conn->prepareStatement($sqlClient);
            $stmt->bind_param("s", $clientID);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();

                    $response['full_name'] = $row['full_name'];
                    $response['meter_number'] = $row['meter_number'];
                    $response['status'] = $row['status'];
                    $response['property_type'] = $row['property_type'];
                    $response['client_id'] = $row['client_id'];
                } else {
                    $response['error'] = "No client found with the provided ID.";
                }
            } else {
                $response['error'] = "There was an error executing the client_data statement.";
            }
            $stmt->close();
        } catch (Exception $e) {
            $response['error'] = "Exception caught: " . $e->getMessage();
        }

        $sqlBilling = "SELECT * FROM billing_data WHERE client_id = ? ORDER BY timestamp DESC LIMIT 1";
        try {
            $stmt = $this->conn->prepareStatement($sqlBilling);
            $stmt->bind_param("s", $clientID);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    $response['recent_meter_reading'] = $row['meter_reading'];
                }
            } else {
                $response['error'] = "There was an error executing the billing_data statement.";
            }
            $stmt->close();
        } catch (Exception $e) {
            $response['error'] = "Exception caught: " . $e->getMessage();
        }

        return $response;
    }


    public function encodeCurrentReading($formData)
    {
        $response = array();
        session_start();

        $encoder = $_SESSION['admin_name'];

        $billingID = "B" . time();
        $readingType = 'current';

        $dateTime = new DateTime();
        $dateTime->modify('+7 days');
        $dateTime->setTime(16, 0, 0);

        $dayOfWeek = $dateTime->format('w');

        if ($dayOfWeek == 6) {
            $dateTime->modify('+2 days');
        } elseif ($dayOfWeek == 0) {
            $dateTime->modify('+1 day');
        }

        $dueDate = $dateTime->format('Y-m-d H:i:s');
        $billingStatus = 'unpaid';

        $month = date('M');
        $year = date('Y');

        $billingMonthAndYear = $month . '-' . $year;
        $clientID = $formData['clientID'];

        $meterReading = $formData['meterReading'];
        $consumption = $formData['consumption'];

        $this->conn->beginTransaction();


        $updateSql = "UPDATE billing_data SET reading_type = 'previous' WHERE client_id = ? ORDER BY timestamp DESC LIMIT 1";
        $stmt_update = $this->conn->prepareStatement($updateSql);
        mysqli_stmt_bind_param($stmt_update, "s", $clientID);
        $updateResult = mysqli_stmt_execute($stmt_update);
        mysqli_stmt_close($stmt_update);


        if (!$updateResult) {
            $this->conn->rollbackTransaction();
            return array("status" => "error", "message" => "Error updating previous reading.");
        }

        $insertSql = "INSERT INTO billing_data (billing_id, client_id, meter_reading, reading_type, consumption, billing_status, billing_month, due_date, encoder, time, date, timestamp ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";
        $stmt_insert = $this->conn->prepareStatement($insertSql);
        mysqli_stmt_bind_param(
            $stmt_insert,
            "ssissssss",
            $billingID,
            $clientID,
            $meterReading,
            $readingType,
            $consumption,
            $billingStatus,
            $billingMonthAndYear,
            $dueDate,
            $encoder
        );

        if (mysqli_stmt_execute($stmt_insert)) {
            $this->conn->commitTransaction();
            $response["message"] = $billingID;

            $updateReadingStatus = "UPDATE client_data SET reading_status = 'read'  WHERE client_id = ?";
            $stmt_update = $this->conn->prepareStatement($updateReadingStatus);
            mysqli_stmt_bind_param($stmt_update, "s", $clientID);
            $updateResult = mysqli_stmt_execute($stmt_update);
            mysqli_stmt_close($stmt_update);

            if (!$updateResult) {
                $this->conn->rollbackTransaction();
                return array("status" => "error", "message" => "Error client reading status.");
            }
        } else {
            $this->conn->rollbackTransaction();
            $response = array("status" => "error", "message" => "Error inserting initial reading: " . $stmt_insert->error);
        }

        mysqli_stmt_close($stmt_insert);

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

        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM client_data WHERE reading_status = 'pending'";
        if ($searchTerm) {
            $likeTerm = "%" . $searchTerm . "%";
            $sql .= " AND (full_name LIKE ? OR meter_number LIKE ? OR street LIKE ? OR brgy LIKE ? OR property_type LIKE ? OR status LIKE ?)";
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
                <th class="px-6 py-4">Registration ID.</th>
                <th class="px-6 py-4">Names&nbsp;&nbsp; 
                <span id="totalItemsSpan" class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer">' . $totalRecords . '</span></th>
                <input id="totalItemsHidden" type="hidden" value="' . $totalRecords . '">
                <th class="px-6 py-4">Property Type</th>
                <th class="px-6 py-4">Status</th>
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
            $property_type = $row['property_type'];
            $status = $row['status'];
            $regID = $row['reg_id'];

            $table .= '<tr class="table-auto bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 overflow-auto">
            <td  class="px-6 py-3 text-sm">' . $number . '</td>
            <td class="px-6 py-3 text-sm">' . $regID . '</td>
            <td class="px-6 py-3 text-sm">' . $name . '</td>
            <td class="px-6 py-3 text-sm">' . $property_type . '</td>
            <td class="px-6 py-3 text-sm">' . $status . '</td>

            <td class="flex items-center px-6 py-4 space-x-3">
                <button  title="Encode Reading" onclick="encodeReadingData(\'' . $clientID . '\')" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center">
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
                echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">No client found</div>';
            }
        } else {
            echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">All clients has been read.</div>';
        }

        echo '<input data-hidden-name="start" type="hidden" value="' . $start . '">';
        echo '<input data-hidden-name="end" type="hidden" value="' . $end . '">';
    }
}
