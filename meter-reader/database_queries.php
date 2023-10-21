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

        // Client Data Query
        $stmt = $this->conn->prepareStatement("SELECT * FROM client_data WHERE client_id = ?");
        if (!$stmt) {
            return ['error' => 'Failed to prepare statement for client_data query.'];
        }

        $stmt->bind_param("s", $clientID);
        if (!$stmt->execute()) {
            return ['error' => 'Error executing the client_data statement.'];
        }

        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $response = array_merge($response, [
                'full_name' => $row['full_name'],
                'meter_number' => $row['meter_number'],
                'status' => $row['status'],
                'property_type' => $row['property_type'],
                'client_id' => $row['client_id'],
            ]);
        } else {
            return ['error' => 'No client found with the provided ID.'];
        }

        // Billing Data Query
        $stmt = $this->conn->prepareStatement("SELECT * FROM billing_data WHERE client_id = ? ORDER BY timestamp DESC LIMIT 1");
        if (!$stmt) {
            return ['error' => 'Failed to prepare statement for billing_data query.'];
        }

        $stmt->bind_param("s", $clientID);
        if (!$stmt->execute()) {
            return ['error' => 'Error executing the billing_data statement.'];
        }

        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if ($row) {
                $response['recent_meter_reading'] = $row['curr_reading'];
            } else {
                $response['error'] = 'No billing data found for the provided ID.';
            }
        }

        return $response;
    }




    public function encodeCurrentReading($formData)
    {
        $response = array();
        session_start();
        $encoder = $_SESSION['admin_name'];

        $readingType = 'current';

        // Initialize DateTime and set dueDate
        $dateTime = new DateTime();
        $dateTime->modify('+15 days');
        $dayOfWeek = $dateTime->format('w');
        if ($dayOfWeek == 6) {
            $dateTime->modify('+2 days');
        } elseif ($dayOfWeek == 0) {
            $dateTime->modify('+1 day');
        }
        $dueDate = $dateTime->format('Y-m-d');

        $disconnectionDateTime = clone $dateTime;
        $disconnectionDateTime->modify('+30 days');
        $disconnectionDate = $disconnectionDateTime->format('Y-m-d');


        $billingStatus = 'unpaid';
        $currentDate = new DateTime();
        $billingMonthAndYear = $currentDate->format('F Y');

        $clientID = $formData['clientID'];
        $prevReading = $formData['prevReading'];
        $currReading = $formData['currReading'];
        $consumption = $formData['consumption'];
        $propertyType = $formData['propertyType'];
        $meterNumber = $formData['meterNumber'];
        $billingID = "B-" . $meterNumber . "-" . time();
        $this->conn->beginTransaction();

        // Fetch rates
        $query_rates = "SELECT * FROM rates WHERE property_type = ? AND billing_month = ?";
        $stmt = $this->conn->prepareStatement($query_rates);
        mysqli_stmt_bind_param($stmt, "ss", $propertyType, $billingMonthAndYear);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            $rates = $row['rates'];
        }

        $billingAmount = $consumption * $rates;

        // Determine periodTo
        $currentDate = new DateTime();
        $currentDate->setTime(0, 0, 0);
        $periodTo = clone $currentDate;
        $periodTo->modify('last day of this month');
        $periodTo = $periodTo->format('Y-m-d');

        // Fetch periodFrom
        $selectBillingData = "SELECT * FROM billing_data WHERE client_id = ? ORDER BY timestamp DESC LIMIT 1";
        $stmt_select = $this->conn->prepareStatement($selectBillingData);
        mysqli_stmt_bind_param($stmt_select, "s", $clientID);
        if (mysqli_stmt_execute($stmt_select)) {
            $result_select = mysqli_stmt_get_result($stmt_select);
            if ($row = mysqli_fetch_assoc($result_select)) {
                $periodFrom = $row['period_to'];

                $date = new DateTime($periodFrom);
                $date->modify('+1 day');
                $periodFrom = $date->format('Y-m-d');
            }
            mysqli_stmt_close($stmt_select);
        }

        // Update previous reading
        $updateSql = "UPDATE billing_data SET reading_type = 'previous' WHERE client_id = ? ORDER BY timestamp DESC LIMIT 1";
        $stmt_update = $this->conn->prepareStatement($updateSql);
        mysqli_stmt_bind_param($stmt_update, "s", $clientID);
        $updateResult = mysqli_stmt_execute($stmt_update);
        mysqli_stmt_close($stmt_update);
        if (!$updateResult) {
            $this->conn->rollbackTransaction();
            return array("status" => "error", "message" => "Error updating previous reading.");
        }

        // Insert current reading
        $sql_billing = "INSERT INTO billing_data (billing_id, client_id, prev_reading, curr_reading, reading_type, consumption, rates, billing_amount, billing_status, billing_month, due_date, disconnection_date, period_to, period_from, encoder, time, date, timestamp ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";
        $stmt_billing = $this->conn->prepareStatement($sql_billing);
        if ($stmt_billing) {
            mysqli_stmt_bind_param(
                $stmt_billing,
                "ssiisssisssssss",
                $billingID,
                $clientID,
                $prevReading,
                $currReading,
                $readingType,
                $consumption,
                $rates,
                $billingAmount,
                $billingStatus,
                $billingMonthAndYear,
                $dueDate,
                $disconnectionDate,
                $periodTo,
                $periodFrom,
                $encoder
            );

            if (mysqli_stmt_execute($stmt_billing)) {
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
                $response = array("status" => "error", "message" => "Error inserting initial reading: " . $stmt_billing->error);
            }
        }

        mysqli_stmt_close($stmt_billing);
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
            $sql .= " AND (full_name LIKE ? OR meter_number LIKE ? OR street LIKE ? OR brgy LIKE ? OR property_type LIKE ? OR status = 'active')";
        }
        $sql .= "AND status = 'active' ORDER BY timestamp DESC LIMIT ? OFFSET ?";

        if ($searchTerm) {
            $stmt = $this->conn->prepareStatement($sql);
            mysqli_stmt_bind_param($stmt, "sssssii", $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $itemPerPage, $offset);
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
