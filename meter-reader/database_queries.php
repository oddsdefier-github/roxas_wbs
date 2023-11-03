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

        $selectQuery = "SELECT * FROM client_data WHERE client_id = ?";
        $stmt = $this->conn->prepareStatement($selectQuery);
        if (!$stmt) {
            return ['error' => 'Failed to prepare statement for client_data query.'];
        }

        mysqli_stmt_bind_param($stmt, "s", $clientID);
        if (!mysqli_stmt_execute($stmt)) {
            return ['error' => 'Error executing the client_data statement.'];
        }

        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
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

        $sql = "SELECT * FROM billing_data WHERE client_id = ? ORDER BY timestamp DESC LIMIT 1";
        $stmt = $this->conn->prepareStatement($sql);
        if (!$stmt) {
            return ['error' => 'Failed to prepare statement for billing_data query.'];
        }

        mysqli_stmt_bind_param($stmt, "s", $clientID);
        if (!mysqli_stmt_execute($stmt)) {
            return ['error' => 'Error executing the billing_data statement.'];
        }

        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                $response['recent_meter_reading'] = $row['curr_reading'];
            } else {
                $response['error'] = 'No billing data found for the provided ID.';
            }
        }

        return $response;
    }

    function getDueAndDisconnectionDates(): array
    {
        $dateTime = new DateTime();
        $dateTime->modify('+15 days');
        $dayOfWeek = $dateTime->format('w');

        // Skip weekends for dueDate
        if ($dayOfWeek == 6) { // Saturday
            $dateTime->modify('+2 days');
        } elseif ($dayOfWeek == 0) { // Sunday
            $dateTime->modify('+1 day');
        }

        $dueDate = $dateTime->format('Y-m-d');

        // Calculate disconnectionDate
        $disconnectionDateTime = clone $dateTime;
        $disconnectionDateTime->modify('+30 days');
        $disconnectionDate = $disconnectionDateTime->format('Y-m-d');

        return [
            'dueDate' => $dueDate,
            'disconnectionDate' => $disconnectionDate
        ];
    }

    public function getRates(string $propertyType, string $billingMonthAndYear): ?string
    {
        $query_rates = "SELECT * FROM rates WHERE property_type = ? AND billing_month = ? ORDER BY timestamp DESC LIMIT 1";
        $stmt = $this->conn->prepareStatement($query_rates);
        mysqli_stmt_bind_param($stmt, "ss", $propertyType, $billingMonthAndYear);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                return $row['rates'];
            }
        }

        return null;
    }


    public function getPeriodTo(): string
    {
        $currentDate = new DateTime();
        $currentDate->setTime(0, 0, 0);
        $periodTo = clone $currentDate;
        $periodTo->modify('last day of this month');
        return $periodTo->format('Y-m-d');
    }

    public function getPeriodFrom(string $clientID): ?string
    {
        $selectBillingData = "SELECT * FROM billing_data WHERE client_id = ? ORDER BY timestamp DESC LIMIT 1";
        $stmt_select = $this->conn->prepareStatement($selectBillingData);
        mysqli_stmt_bind_param($stmt_select, "s", $clientID);
        if (mysqli_stmt_execute($stmt_select)) {
            $result_select = mysqli_stmt_get_result($stmt_select);
            if ($row = mysqli_fetch_assoc($result_select)) {
                $periodFrom = $row['period_to'];
                $date = new DateTime($periodFrom);
                $date->modify('+1 day');
                mysqli_stmt_close($stmt_select);
                return $date->format('Y-m-d');
            }
            mysqli_stmt_close($stmt_select);
        }
        return null;
    }

    public function updateReadingTypeToPrevious(string $clientID): array
    {
        $updateSql = "UPDATE billing_data SET reading_type = 'previous' WHERE client_id = ? ORDER BY timestamp DESC LIMIT 1";
        $stmt_update = $this->conn->prepareStatement($updateSql);
        mysqli_stmt_bind_param($stmt_update, "s", $clientID);
        $updateResult = mysqli_stmt_execute($stmt_update);
        mysqli_stmt_close($stmt_update);
        if (!$updateResult) {
            $this->conn->rollbackTransaction();
            return array("status" => "error", "message" => "Error updating previous reading.");
        }
        return array("status" => "success", "message" => "Successfully updated previous reading.");
    }


    public function updateClientReadingStatus($clientID)
    {
        $updateReadingStatus = "UPDATE client_data SET reading_status = 'read' WHERE client_id = ?";
        $stmt_update = $this->conn->prepareStatement($updateReadingStatus);
        mysqli_stmt_bind_param($stmt_update, "s", $clientID);
        $updateResult = mysqli_stmt_execute($stmt_update);

        if (mysqli_stmt_affected_rows($stmt_update) === 0) {
            mysqli_stmt_close($stmt_update);
            return array("status" => "warning", "message" => "No rows were affected or data is the same.");
        }

        if (!$updateResult) {
            mysqli_stmt_close($stmt_update);
            return array("status" => "error", "message" => "Error updating client reading status.");
        }
        mysqli_stmt_close($stmt_update);
        return array("status" => "success", "message" => "Successfully updated client reading status.");
    }


    public function encodeCurrentReading($formData)
    {
        $response = array();
        session_start();
        $encoder = $_SESSION['user_name'];

        $readingType = 'current';

        $getDueAndDisconnectionDates = $this->getDueAndDisconnectionDates();
        $dueDate = $getDueAndDisconnectionDates['dueDate'];
        $disconnectionDate = $getDueAndDisconnectionDates['disconnectionDate'];

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

        $rates = $this->getRates($propertyType, $billingMonthAndYear);

        $billingAmount = $consumption * $rates;

        $periodTo = $this->getPeriodTo();
        $periodFrom = $this->getPeriodFrom($clientID);


        $response = $this->updateReadingTypeToPrevious($clientID);

        $billingType = 'actual';
        // Insert current reading
        $sql_billing = "INSERT INTO billing_data (billing_id, client_id, meter_number,  prev_reading, curr_reading, reading_type, consumption, rates, billing_amount, billing_status, billing_type, billing_month, due_date, disconnection_date, period_to, period_from, encoder, time, date, timestamp ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";


        $stmt_billing = $this->conn->prepareStatement($sql_billing);

        if ($stmt_billing) {
            mysqli_stmt_bind_param(
                $stmt_billing,
                "sssiisssissssssss",
                $billingID,
                $clientID,
                $meterNumber,
                $prevReading,
                $currReading,
                $readingType,
                $consumption,
                $rates,
                $billingAmount,
                $billingStatus,
                $billingType,
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
                $response = $this->updateClientReadingStatus($clientID);
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
}


class DataTable extends BaseQuery
{
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
                $types .= "s";
            }
        }

        if (!empty($conditions)) {
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM client_data WHERE reading_status = 'pending' AND " . implode(" AND ", $conditions);
        } else {
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM client_data WHERE reading_status = 'pending'";
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
                echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">No client application found</div>';
            }
        } else {
            echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">No client application found</div>';
        }

        echo '<input data-hidden-name="start" type="hidden" value="' . $start . '">';
        echo '<input data-hidden-name="end" type="hidden" value="' . $end . '">';
    }
}
