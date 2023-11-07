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
                $response = array_merge($response, [
                    "billing_id" => $row['billing_id'],
                    "billing_month" => $row['billing_month'],
                    "prev_reading" => $row['prev_reading'],
                    "curr_reading" => $row['curr_reading']
                ]);
            } else {
                $response['error'] = 'No billing data found for the provided ID.';
            }
        }

        return $response;
    }

    public function getDueAndDisconnectionDates(): array
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

    public function getRates(string $propertyType, string $billingMonthAndYear)
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

    public function updateReadingTypeToPrevious(string $clientID): bool
    {
        $updateSql = "UPDATE billing_data SET reading_type = 'previous' WHERE client_id = ? ORDER BY timestamp DESC LIMIT 1";
        $stmt_update = $this->conn->prepareStatement($updateSql);
        mysqli_stmt_bind_param($stmt_update, "s", $clientID);
        $updateResult = mysqli_stmt_execute($stmt_update);
        mysqli_stmt_close($stmt_update);
        if (!$updateResult) {
            $this->conn->rollbackTransaction();
            return false;
        }
        return true;
    }


    public function updateClientReadingStatus(string $clientID, string $readingStatus): bool
    {
        $updateReadingStatus = "UPDATE client_data SET reading_status = ? WHERE client_id = ?";
        $stmt_update = $this->conn->prepareStatement($updateReadingStatus);
        mysqli_stmt_bind_param($stmt_update, "ss", $readingStatus, $clientID);
        $updateResult = mysqli_stmt_execute($stmt_update);

        if (mysqli_stmt_affected_rows($stmt_update) === 0) {
            mysqli_stmt_close($stmt_update);
            return false;
        }
        if (!$updateResult) {
            mysqli_stmt_close($stmt_update);
            return false;
        }
        mysqli_stmt_close($stmt_update);
        return true;
    }

    public function checkDuplicate($clientID, $billingMonthAndYear)
    {
        $checkDuplicateQuery = "SELECT client_id FROM billing_data WHERE client_id = ? AND billing_month = ? AND (billing_type = 'unverified' OR billing_type = 'verified')";
        $stmt = $this->conn->prepareStatement($checkDuplicateQuery);
        if (!$stmt) {
            return false;
        }
        mysqli_stmt_bind_param($stmt, "ss", $clientID, $billingMonthAndYear);

        if (!mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return false;
        }

        mysqli_stmt_store_result($stmt);

        $isDuplicate = mysqli_stmt_num_rows($stmt) > 0;

        mysqli_stmt_close($stmt);

        return $isDuplicate;
    }

    public function retrievePreviousReading($clientID)
    {
        $sql = "SELECT prev_reading FROM billing_data WHERE client_id = ? ORDER BY timestamp DESC LIMIT 1";
        $stmt = $this->conn->prepareStatement($sql);
        if (!$stmt) {
            return false;
        }
        mysqli_stmt_bind_param($stmt, "s", $clientID);
        if (!mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return false;
        }
        mysqli_stmt_bind_result($stmt, $prev_reading);
        $result = mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        if ($result) {
            return $prev_reading;
        } else {
            return false;
        }
    }

    public function insertIntoMeterReadingLogs(array $data): bool
    {
        $referenceID = $data['referenceID'];
        $clientID = $data['clientID'];
        $prevReading = $data['prevReading'];
        $currReading = $data['currReading'];
        $meterNumber = $data['meterNumber'];
        $consumption = $data['consumption'];
        $userID = $data['userID'];
        $readingMonth = $data['readingMonth'];

        $this->conn->beginTransaction();
        $sql = "INSERT into meter_reading_logs (reference_id, client_id, meter_number, prev_reading, curr_reading, consumption, user_id, reading_month, time, date, timestamp) VALUES (?, ?, ?, ?,?, ?, ?,?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";
        $stmt = $this->conn->prepareStatement($sql);
        if (!$stmt) {
            return false;
        }
        mysqli_stmt_bind_param(
            $stmt,
            "sssdddss",
            $referenceID,
            $clientID,
            $meterNumber,
            $prevReading,
            $currReading,
            $consumption,
            $userID,
            $readingMonth
        );

        if (!mysqli_stmt_execute($stmt)) {
            $this->conn->rollbackTransaction();
            return false;
        }
        mysqli_stmt_close($stmt);
        return true;
    }

    public function updateAndVerifiedBillingData($formData)
    {
        $this->conn->beginTransaction();
        $clientID = $formData['clientID'];
        $billingID = $formData['billingID'];
        $billingMonth = $formData['billingMonth'];
        $prevReading = $formData['prevReading'];
        $currReading = $formData['currReading'];
        $consumption = intval($currReading) - intval($prevReading);

        $propertyType = $formData['propertyType'];
        $billingType = 'verified';

        $rates = $this->getRates($propertyType, $billingMonth);
        $billingAmount = $consumption * $rates;
        $roundedBillingAmount = round($billingAmount, 2);

        $sql = "UPDATE billing_data SET curr_reading = ?, consumption = ?, rates = ?, billing_amount = ?, billing_type = ?, last_update = CURRENT_TIMESTAMP WHERE billing_id = ? ORDER BY timestamp DESC LIMIT 1";
        $stmt_update = $this->conn->prepareStatement($sql);
        mysqli_stmt_bind_param(
            $stmt_update,
            "ddddss",
            $currReading,
            $consumption,
            $rates,
            $roundedBillingAmount,
            $billingType,
            $billingID
        );
        $updateResult = mysqli_stmt_execute($stmt_update);

        if (mysqli_stmt_affected_rows($stmt_update) === 0) {
            mysqli_stmt_close($stmt_update);
            return false;
        }
        if (!$updateResult) {
            mysqli_stmt_close($stmt_update);
            return false;
        }
        mysqli_stmt_close($stmt_update);
        return true;
    }

    public function verifyReadingData($formData)
    {
        $response = array();
        $this->conn->beginTransaction();
        try {
            if(!$this->updateAndVerifiedBillingData($formData)) {
                throw new Exception("Failed to update and verified billing data.");
            }

            $this->conn->commitTransaction();
            $response = array(
                "status" => "success",
                "message" => "Verification success."
            );
            return $response;
        } catch (Exception $e) {
            $this->conn->rollbackTransaction();
            $response = array(
                "status" => "error",
                "message" => $e->getMessage()
            );
            return false;
        }
    }
    public function insertIntoBillingData($formData)
    {
        $this->conn->beginTransaction();

        session_start();
        $encoder = $_SESSION['user_name'];
        $readingType = 'current';

        $getDueAndDisconnectionDates = $this->getDueAndDisconnectionDates();
        $dueDate = $getDueAndDisconnectionDates['dueDate'];
        $disconnectionDate = $getDueAndDisconnectionDates['disconnectionDate'];

        $billingStatus = 'unpaid';
        $billingType = 'unverified';
        $currentDate = new DateTime();
        $billingMonthAndYear = $currentDate->format('F Y');

        $clientID = $formData['clientID'];
        $prevReading = $this->retrievePreviousReading($clientID);
        $currReading = $formData['currReading'];
        $consumption = intval($currReading) - intval($prevReading);
        $roundedConsumption = round($consumption, 2);
        $meterNumber = $formData['meterNumber'];
        $billingID = "B-" . $meterNumber . "-" . time();

        $periodTo = $this->getPeriodTo();
        $periodFrom = $this->getPeriodFrom($clientID);

        $data = array(
            "referenceID" => $billingID,
            "clientID" => $clientID,
            "meterNumber" => $meterNumber,
            "prevReading" => $prevReading,
            "currReading" => $currReading,
            "consumption" => $roundedConsumption,
            "userID" => $encoder,
            "readingMonth" => $billingMonthAndYear
        );

        if (!$this->insertIntoMeterReadingLogs($data)) {
            $this->conn->rollbackTransaction();
            return false;
        }

        if (!$this->updateReadingTypeToPrevious($clientID)) {
            $this->conn->rollbackTransaction();
            return false;
        }

        if ($this->checkDuplicate($clientID, $billingMonthAndYear)) {
            $this->conn->rollbackTransaction();
            return false;
        }

        $sql_billing = "INSERT INTO billing_data (billing_id, client_id, meter_number,  prev_reading, curr_reading, reading_type, consumption, billing_status, billing_type, billing_month, due_date, disconnection_date, period_to, period_from, encoder, time, date, timestamp ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";

        $stmt_billing = $this->conn->prepareStatement($sql_billing);
        if (!$stmt_billing) {
            return false;
        }
        mysqli_stmt_bind_param(
            $stmt_billing,
            "sssddsdssssssss",
            $billingID,
            $clientID,
            $meterNumber,
            $prevReading,
            $currReading,
            $readingType,
            $roundedConsumption,
            $billingStatus,
            $billingType,
            $billingMonthAndYear,
            $dueDate,
            $disconnectionDate,
            $periodTo,
            $periodFrom,
            $encoder
        );


        if (!mysqli_stmt_execute($stmt_billing)) {
            mysqli_stmt_close($stmt_billing);
            return false;
        }
        mysqli_stmt_close($stmt_billing);
        return true;
    }


    public function encodeCurrentReading($formData)
    {
        $response = array();
        $clientID = $formData['clientID'];

        try {
            if (!$this->insertIntoBillingData($formData)) {
                throw new Exception("Failed to do insert into billing data. Already encoded for this month.");
            }

            if (!$this->updateClientReadingStatus($clientID, 'encoded')) {
                throw new Exception("Failed to update client reading status to encoded.");
            }

            $this->conn->commitTransaction();
            $response = array(
                "status" => "success",
                "message" => "Client reading has been encoded."
            );
        } catch (Exception $e) {
            $this->conn->rollbackTransaction();

            $response = array(
                "status" => "error",
                "message" => $e->getMessage()
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
            $conditions[] = "(full_name LIKE ? OR client_id LIKE ? OR meter_number LIKE ? OR street LIKE ? OR reading_status LIKE ? OR brgy LIKE ? OR property_type LIKE ? OR status LIKE ?)";
            $params = array_merge($params, [$likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm]);
            $types .= "ssssssss";
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
            'status', 'reading_status', 'timestamp'
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

        $ascendingIcon = ' <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
    </svg>';

        $descendingIcon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
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
                <th class="px-6 py-4" data-column-name="reading_status" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Reading</p>
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
            $reading_status = $row['reading_status'];
            $time = $row['time'];
            $date = $row['date'];

            $readable_date = date("F j, Y", strtotime($date));
            $readable_time = date("h:i A", strtotime($time));

            $activeBadge = '<span class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Active</span>';
            $inactiveBadge = '<span class="bg-yellow-100 text-yellow-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Inactive</span>';
            $statusBadge = ($status === 'active') ? $activeBadge : (($status === 'inactive' ? $inactiveBadge : ''));

            $table .= '<tr class="table-auto bg-white border-b border-gray-200 group hover:bg-gray-100" data-id="' . $id . '">
            <td  class="px-6 py-3 text-sm">' . $number . '</td>
            <td  class="px-6 py-3 text-sm">' . $clientID . '</td>
            <td class="px-6 py-3 text-sm">' . $meter_number . '</td>
            <td class="px-6 py-3 text-sm font-semibold  group-hover:bg-gray-50 group-hover:text-indigo-500 group-hover:font-semibold ease-in-out duration-150">' . $name . '</td>
            <td class="px-6 py-3 text-sm">' . $property_type . '</td>
            <td class="px-6 py-3 text-sm"> 
                <span class="font-medium text-sm">' . $brgy . '</span> </br>
                <span class="text-xs text-gray-400">' . $street . '</span>
            </td>
            <td class="px-6 py-3 text-sm">' . $statusBadge . '</td>
            <td class="px-6 py-3 text-sm">' . $reading_status . '</td>
            <td class="px-6 py-3 text-sm">            
                <span class="font-medium text-sm">' . $readable_date . '</span> </br>
                <span class="text-xs">' . $readable_time . '</span>
            </td>

            <td class="flex items-center px-6 py-4 space-x-3">
                <button  title="Encode Reading" onclick="encodeReadingData(\'' . $clientID . '\')" class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded text-sm p-2 text-center inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
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

    public function billingTable($dataTableParam)
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

        $currentDate = new DateTime();
        $billingMonthAndYear = $currentDate->format('F Y');

        $conditions[] = "billing_month = ?";
        $params[] = $billingMonthAndYear;
        $types .= "s";

        if ($searchTerm) {
            $likeTerm = "%" . $searchTerm . "%";
            $conditions[] = "(bd.billing_id LIKE ? OR bd.client_id LIKE ? OR cd.full_name LIKE ? OR bd.meter_number LIKE ? OR cd.property_type LIKE ? OR cd.status LIKE ?)";
            $params = array_merge($params, [$likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm]);
            $types .= "ssssss";
        }

        if (!empty($filters)) {
            foreach ($filters as $filter) {
                $conditions[] = "{$filter['column']} = ?";
                $params[] = $filter['value'];
                $types .= "s";
            }
        }

        if (!empty($conditions)) {
            $sql = "SELECT SQL_CALC_FOUND_ROWS bd.*, cd.* FROM billing_data AS bd";
            $sql .= " INNER JOIN client_data AS cd ON bd.client_id = cd.client_id";
            $sql .= " WHERE cd.reading_status = 'encoded' AND bd.billing_type = 'unverified' AND bd.billing_status = 'unpaid' AND " . implode(" AND ", $conditions);
        } else {
            $sql = "SELECT SQL_CALC_FOUND_ROWS bd.*, cd.* FROM billing_data AS bd";
            $sql .= " INNER JOIN client_data AS cd ON bd.client_id = cd.client_id";
            $sql .= " WHERE cd.reading_status = 'encoded' AND bd.billing_type = 'unverified' AND bd.billing_status = 'unpaid'";
        }

        // echo $sql;
        // print_r($params);

        $validColumns = [
            'bd.client_id', 'bd.meter_number', 'cd.full_name',  'cd.property_type', 'bd.timestamp', 'bd.prev_reading', 'bd.curr_reading', 'cd.brgy'
        ];
        $validDirections = ['ASC', 'DESC'];

        if (in_array($sortColumn, $validColumns) && in_array($sortDirection, $validDirections)) {
            $sql .= " ORDER BY {$sortColumn} {$sortDirection}";
        } else {
            $sql .= " ORDER BY bd.timestamp DESC";
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
            <tr class="bg-slate-100 border-b">
                <th class="px-6 py-4">No.</th>
                <th class="px-6 py-4" data-column-name="bd.client_id" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Client ID</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                        <span id="totalItemsSpan" class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer">' . $totalRecords . '</span>
                    </div>
                </th>
                <input id="totalItemsHidden" type="hidden" value="' . $totalRecords . '">
                <th class="px-6 py-4" data-column-name="cd.full_name" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Client Name</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="cd.property_type" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Property Type</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="cd.brgy" data-sortable="true">
                <div class="flex items-center gap-2">
                    <p>Address</p>
                    <span class="sort-icon">
                    ' . $sortIcon . '
                    </span>
                </div>
                </th>
                <th class="px-6 py-4" data-column-name="bd.prev_reading" data-sortable="true" title="Previous Reading">
                <div class="flex items-center gap-2">
                    <p>Previous</p>
                    <span class="sort-icon">
                    ' . $sortIcon . '
                    </span>
                </div>
                </th>
                <th class="px-6 py-4" data-column-name="bd.curr_reading" data-sortable="true" title="Current Reading">
                <div class="flex items-center gap-2">
                    <p>Current</p>
                    <span class="sort-icon">
                    ' . $sortIcon . '
                    </span>
                </div>
                </th>
                <th class="px-6 py-4" data-column-name="bd.timestamp" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Reading Date</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4">Action</th>
            </tr>
        </thead>';

        $countArr = array();
        $number = ($pageNumber - 1) * $itemPerPage + 1;

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $clientID = $row['client_id'];
            $clientName = $row['full_name'];
            $propertyType = $row['property_type'];
            $street = $row['street'];
            $brgy = $row['brgy'];
            $prevReading = $row['prev_reading'];
            $currReading = $row['curr_reading'];
            $time = $row['time'];
            $date = $row['date'];
            $readable_date = date("F j, Y", strtotime($date));
            $readable_time = date("h:i A", strtotime($time));

            $table .= '<tr class="table-auto bg-white border-b border-gray-200 group hover:bg-gray-100" data-id="' . $id . '">
            <td  class="px-6 py-3 text-sm">' . $number . '</td>
            <td  class="px-6 py-3 text-sm">' . $clientID . '</td>
            <td class="px-6 py-3 text-sm font-semibold  group-hover:bg-gray-50 group-hover:text-indigo-500 group-hover:font-semibold ease-in-out duration-150">' . $clientName . '</td>
            <td class="px-6 py-3 text-sm">' . $propertyType . '</td>
            <td class="px-6 py-3 text-sm"> 
            <span class="font-medium text-sm">' . $brgy . '</span> </br>
            <span class="text-xs text-gray-400">' . $street . '</span>
            </td>
            <td class="px-6 py-3 text-sm font-semibold">' . $prevReading . '</td>
            <td class="px-6 py-3 text-sm font-semibold  group-hover:bg-gray-50 group-hover:text-indigo-500 group-hover:font-semibold ease-in-out duration-150">
            ' . $currReading . '  <span class="hidden group-hover:flex text-xs">cubic meter</span></td>
            <td class="px-6 py-3 text-sm">            
                <span class="font-medium text-sm">' . $readable_date . '</span> </br>
                <span class="text-xs">' . $readable_time . '</span>
            </td>
            <td class="flex items-center px-6 py-4 space-x-3">

            <button  title="Verify Reading" onclick="verifyReadingData(\'' . $clientID . '\')" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">No billing found.</div>';
            }
        } else {
            echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">No billing found.</div>';
        }

        echo '<input data-hidden-name="start" type="hidden" value="' . $start . '">';
        echo '<input data-hidden-name="end" type="hidden" value="' . $end . '">';
    }
    public function verifiedBillingTable($dataTableParam)
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

        $currentDate = new DateTime();
        $billingMonthAndYear = $currentDate->format('F Y');

        $conditions[] = "billing_month = ?";
        $params[] = $billingMonthAndYear;
        $types .= "s";

        if ($searchTerm) {
            $likeTerm = "%" . $searchTerm . "%";
            $conditions[] = "(bd.billing_id LIKE ? OR bd.client_id LIKE ? OR cd.full_name LIKE ? OR bd.meter_number LIKE ? OR cd.property_type LIKE ? OR cd.status LIKE ?)";
            $params = array_merge($params, [$likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm]);
            $types .= "ssssss";
        }

        if (!empty($filters)) {
            foreach ($filters as $filter) {
                $conditions[] = "{$filter['column']} = ?";
                $params[] = $filter['value'];
                $types .= "s";
            }
        }

        
        if (!empty($conditions)) {
            $sql = "SELECT SQL_CALC_FOUND_ROWS bd.*, cd.* FROM billing_data AS bd";
            $sql .= " INNER JOIN client_data AS cd ON bd.client_id = cd.client_id";
            $sql .= " WHERE bd.billing_type = 'verified' AND bd.billing_status = 'unpaid' AND " . implode(" AND ", $conditions);
        } else {
            $sql = "SELECT SQL_CALC_FOUND_ROWS bd.*, cd.* FROM billing_data AS bd";
            $sql .= " INNER JOIN client_data AS cd ON bd.client_id = cd.client_id";
            $sql .= " WHERE bd.billing_type = 'verified' AND bd.billing_status = 'unpaid'";
        }

        // echo $sql;
        // print_r($params);

        $validColumns = [
            'bd.client_id', 'bd.meter_number', 'cd.full_name',  'cd.property_type', 'bd.timestamp', 'bd.prev_reading', 'bd.curr_reading', 'cd.brgy'
        ];
        $validDirections = ['ASC', 'DESC'];

        if (in_array($sortColumn, $validColumns) && in_array($sortDirection, $validDirections)) {
            $sql .= " ORDER BY {$sortColumn} {$sortDirection}";
        } else {
            $sql .= " ORDER BY bd.timestamp DESC";
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
            <tr class="bg-slate-100 border-b">
                <th class="px-6 py-4">No.</th>
                <th class="px-6 py-4" data-column-name="bd.client_id" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Client ID</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                        <span id="totalItemsSpan" class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer">' . $totalRecords . '</span>
                    </div>
                </th>
                <input id="totalItemsHidden" type="hidden" value="' . $totalRecords . '">
                <th class="px-6 py-4" data-column-name="cd.full_name" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Client Name</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="cd.property_type" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Property Type</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="cd.brgy" data-sortable="true">
                <div class="flex items-center gap-2">
                    <p>Address</p>
                    <span class="sort-icon">
                    ' . $sortIcon . '
                    </span>
                </div>
                </th>
                <th class="px-6 py-4" data-column-name="bd.prev_reading" data-sortable="true" title="Previous Reading">
                <div class="flex items-center gap-2">
                    <p>Previous</p>
                    <span class="sort-icon">
                    ' . $sortIcon . '
                    </span>
                </div>
                </th>
                <th class="px-6 py-4" data-column-name="bd.curr_reading" data-sortable="true" title="Current Reading">
                <div class="flex items-center gap-2">
                    <p>Current</p>
                    <span class="sort-icon">
                    ' . $sortIcon . '
                    </span>
                </div>
                </th>
                <th class="px-6 py-4" data-column-name="bd.timestamp" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Reading Date</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4">Action</th>
            </tr>
        </thead>';

        $countArr = array();
        $number = ($pageNumber - 1) * $itemPerPage + 1;

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $clientID = $row['client_id'];
            $clientName = $row['full_name'];
            $propertyType = $row['property_type'];
            $street = $row['street'];
            $brgy = $row['brgy'];
            $prevReading = $row['prev_reading'];
            $currReading = $row['curr_reading'];
            $time = $row['time'];
            $date = $row['date'];
            $readable_date = date("F j, Y", strtotime($date));
            $readable_time = date("h:i A", strtotime($time));

            $table .= '<tr class="table-auto bg-white border-b border-gray-200 group hover:bg-gray-100" data-id="' . $id . '">
            <td  class="px-6 py-3 text-sm">' . $number . '</td>
            <td  class="px-6 py-3 text-sm">' . $clientID . '</td>
            <td class="px-6 py-3 text-sm font-semibold  group-hover:bg-gray-50 group-hover:text-indigo-500 group-hover:font-semibold ease-in-out duration-150">' . $clientName . '</td>
            <td class="px-6 py-3 text-sm">' . $propertyType . '</td>
            <td class="px-6 py-3 text-sm"> 
            <span class="font-medium text-sm">' . $brgy . '</span> </br>
            <span class="text-xs text-gray-400">' . $street . '</span>
            </td>
            <td class="px-6 py-3 text-sm font-semibold">' . $prevReading . '</td>
            <td class="px-6 py-3 text-sm font-semibold  group-hover:bg-gray-50 group-hover:text-indigo-500 group-hover:font-semibold ease-in-out duration-150">
            ' . $currReading . '  <span class="hidden group-hover:flex text-xs">cubic meter</span></td>
            <td class="px-6 py-3 text-sm">            
                <span class="font-medium text-sm">' . $readable_date . '</span> </br>
                <span class="text-xs">' . $readable_time . '</span>
            </td>
            <td class="flex items-center px-6 py-4 space-x-3">

            <button  title="Verify Reading" onclick="verifyReadingData(\'' . $clientID . '\')" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">No billing found.</div>';
            }
        } else {
            echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">No billing found.</div>';
        }

        echo '<input data-hidden-name="start" type="hidden" value="' . $start . '">';
        echo '<input data-hidden-name="end" type="hidden" value="' . $end . '">';
    }

}
