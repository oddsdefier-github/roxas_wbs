<?php

use Cashier\Database\DatabaseConnection;

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
    public function notificationExists($user_id, $type, $reference_id)
    {
        $sql = "SELECT id FROM notifications WHERE user_id = ? AND type = ? AND reference_id = ? LIMIT 1";
        $stmt = $this->conn->prepareStatement($sql);

        if (!$stmt) {
            return false;
        }

        mysqli_stmt_bind_param($stmt, "sss", $user_id, $type, $reference_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        $num_rows = mysqli_stmt_num_rows($stmt);
        mysqli_stmt_close($stmt);
        return $num_rows > 0;
    }


    public function addNotification($user_id, $message, $type, $reference_id = null)
    {
        $sql = "INSERT INTO notifications (user_id, message, type, reference_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepareStatement($sql);

        mysqli_stmt_bind_param($stmt, "ssss", $user_id, $message, $type, $reference_id);

        if (mysqli_stmt_execute($stmt)) {
            return true;
        } else {
            return false;
        }
    }
    // public function markAllNotificationsAsRead()
    // {
    //     $sql = "UPDATE notifications SET status = 'read' WHERE user_id = ? AND status = 'unread'";
    //     $stmt = $this->conn->prepareStatement($sql);

    //     session_start();
    //     $user_id = $_SESSION['user_id'];
    //     mysqli_stmt_bind_param($stmt, "s", $user_id);

    //     if (mysqli_stmt_execute($stmt)) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    public function handleLoadNotification()
    {

        $sql = "SELECT * FROM notifications ORDER BY timestamp DESC LIMIT 10";
        $result = $this->conn->query($sql);

        $output = "";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $url = "https://www.facebook.com";
                $icon = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGZpbGw9Im5vbmUiIHZpZXdCb3g9IjAgMCAyNCAyNCIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZT0iY3VycmVudENvbG9yIiBjbGFzcz0idy02IGgtNiI+DQogIDxwYXRoIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgZD0iTTEwLjEyNSAyLjI1aC00LjVjLS42MjEgMC0xLjEyNS41MDQtMS4xMjUgMS4xMjV2MTcuMjVjMCAuNjIxLjUwNCAxLjEyNSAxLjEyNSAxLjEyNWgxMi43NWMuNjIxIDAgMS4xMjUtLjUwNCAxLjEyNS0xLjEyNXYtOU0xMC4xMjUgMi4yNWguMzc1YTkgOSAwIDAxOSA5di4zNzVNMTAuMTI1IDIuMjVBMy4zNzUgMy4zNzUgMCAwMTEzLjUgNS42MjV2MS41YzAgLjYyMS41MDQgMS4xMjUgMS4xMjUgMS4xMjVoMS41YTMuMzc1IDMuMzc1IDAgMDEzLjM3NSAzLjM3NU05IDE1bDIuMjUgMi4yNUwxNSAxMiIgLz4NCjwvc3ZnPg0K"; // Your SVG data
                $notificationContent = $row['content'];
                $userName = $row['user_name'];
                $timeAgo = "a few moments ago";

                $output .= "
                    <a href=\"$url\" target=\"_blank\" class=\"flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700\">
                        <div class=\"flex-shrink-0\">
                            <img class=\"rounded-full w-11 h-11\" src='$icon' alt=\"Confirm Icon\">
                        </div>
                        <div class=\"w-full pl-3\">
                            <div class=\"text-gray-500 text-sm mb-1.5 dark:text-gray-400\">$notificationContent <span class=\"font-semibold text-gray-900 dark:text-white\">$userName</span></div>
                            <div class=\"text-xs text-blue-600 dark:text-blue-500\">$timeAgo</div>
                        </div>
                    </a>
                ";
            }
        }

        return $output; // This will return our generated HTML to wherever you call the function
    }

    public function retrieveBillingRates()
    {
        $response = array();
        $sql = "SELECT * FROM rates ORDER BY timestamp DESC LIMIT 1";

        $result = $this->conn->query($sql);
        if ($result) {
            if ($row = mysqli_fetch_assoc($result)) {
                $response = [
                    'status' => 'success',
                    'rates' => $row
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'rates' => null
                ];
            }
        } else {
            $response = [
                'status' => 'error',
                'rates' => $this->conn->getErrorMessage()
            ];
        }

        return $response;
    }

    public function retrieveBillingData($clientID)
    {
        $response = array();

        $sql = "SELECT billing_data.*, client_data.* FROM billing_data "
            . "LEFT JOIN client_data ON billing_data.client_id = client_data.client_id "
            . "WHERE billing_data.reading_type = 'current' AND client_data.client_id = ?";

        if ($stmt = $this->conn->prepareStatement($sql)) {
            mysqli_stmt_bind_param($stmt, "s", $clientID);

            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if ($row = mysqli_fetch_assoc($result)) {
                    $response = [
                        'status' => 'success',
                        'billingData' => $row
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'No data found.'
                    ];
                }
                mysqli_free_result($result);
            } else {
                $response = [
                    'status' => 'error',
                    'message' => "Execute failed: " . $this->conn->getErrorMessage()
                ];
            }
            mysqli_stmt_close($stmt);
        } else {
            $response = [
                'status' => 'error',
                'message' => "Prepare failed: " . $this->conn->getErrorMessage()
            ];
        }

        return $response;
    }

    public function calculateTotalBill($billingAmount, $penalty, $taxRate)
    {
        $taxAmount = $billingAmount * ($taxRate / 100);
        $totalWithTax = $billingAmount + $penalty + $taxAmount;
        $roundedTaxAmount = round($taxAmount, 2);
        $roundedTotalWithTax = round($totalWithTax, 2);

        return array($roundedTaxAmount, $roundedTotalWithTax);
    }

    public function generateTransactionID()
    {
        $timestamp = time();
        $randomNumber = mt_rand(1000, 9999);
        $transactionID = $timestamp . $randomNumber;
        return $transactionID;
    }

    public function getClientName($clientID)
    {
        $sql = "SELECT full_name FROM client_data WHERE client_id = ?";
        $stmt = $this->conn->prepareStatement($sql);
        mysqli_stmt_bind_param($stmt, "s", $clientID);

        if (!$stmt) {
            return null;
        }

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                if ($row) {
                    $clientName = $row['full_name'];
                    return $clientName;
                }
            }
        }
        return null;
    }

    public function updateBillingData($billingID)
    {
        $update = "UPDATE billing_data SET billing_status = 'paid' WHERE billing_id = ?";
        $stmt = $this->conn->prepareStatement($update);
        mysqli_stmt_bind_param($stmt, "s", $billingID);

        if (!$stmt) {
            if (!$stmt) {
                return false;
            }
        }
        if (mysqli_stmt_execute($stmt)) {
            return true;
        }
        return false;
    }

    public function checkDuplicate($column, $value, $table)
    {
        $checkDuplicateQuery = "SELECT $column FROM $table WHERE $column = ?";

        $stmt = $this->conn->prepareStatement($checkDuplicateQuery);
        if (!$stmt) {
            return false;
        }

        mysqli_stmt_bind_param($stmt, "s", $value);

        if (!mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return false;
        }

        mysqli_stmt_store_result($stmt);

        $isDuplicate = mysqli_stmt_num_rows($stmt) > 0;

        mysqli_stmt_close($stmt);

        return $isDuplicate;
    }


    public function insertIntoTransactions($data)
    {
        $transactionID = $data['transactionID'];
        $transactionType = $data['transactionType'];
        $referenceID = $data['referenceID'];
        $description = $data['description'];
        $amountDue = $data['amountDue'];
        $amountPaid = $data['amountPaid'];
        $remainingBalance = $data['remainingBalance'];
        $userID = $data['confirmedBy'];

        $sql = "INSERT INTO transactions (transaction_id, reference_id, transaction_type, transaction_desc, amount_due, amount_paid, remaining_balance, confirmed_by, time, date, timestamp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";

        $stmt = $this->conn->prepareStatement($sql);
        if (!$stmt) {
            return false;
        } else {
            mysqli_stmt_bind_param(
                $stmt,
                "ssssddds",
                $transactionID,
                $referenceID,
                $transactionType,
                $description,
                $amountDue,
                $amountPaid,
                $remainingBalance,
                $userID
            );
            if (mysqli_stmt_execute($stmt)) {
                return true;
            }
        }
    }


    public function confirmBillingPayment($formData)
    {
        $this->conn->beginTransaction();

        $clientID = htmlspecialchars($formData['clientID'], ENT_QUOTES, 'UTF-8');
        $amountPaid = htmlspecialchars($formData['amountPaid'], ENT_QUOTES, 'UTF-8');

        $transactionID = $this->generateTransactionID();

        $transactionType = 'bill_payment';

        $rates = $this->retrieveBillingRates();
        $billingData = $this->retrieveBillingData($clientID);

        $billingID = $billingData['billingData']['billing_id'];
        $billingAmount = $billingData['billingData']['billing_amount'];
        $billingMonth = $billingData['billingData']['billing_month'];
        $taxRate = $rates['rates']['tax'];
        $penalty = $billingData['billingData']['penalty'];

        $calculatedTotalBill = $this->calculateTotalBill($billingAmount, $penalty, $taxRate);
        $totalWithTax = $calculatedTotalBill[1];

        $clientName = $this->getClientName($clientID);

        $amountDue = $totalWithTax;
        $remainingBalance = intval($amountPaid) - intval($amountDue);

        $referenceID = $billingID;
        session_start();
        $userID = $_SESSION['user_id'];
        $userName = $_SESSION['user_name'];
        $description = "Payment received from $clientName - Billing Month of $billingMonth - Confirmed by $userName";


        $data = array(
            "transactionID" => $transactionID,
            "transactionType" =>  $transactionType,
            "referenceID" => $referenceID,
            "description" => $description,
            "amountDue" => $amountDue,
            "amountPaid" => $amountPaid,
            "remainingBalance" => $remainingBalance,
            "confirmedBy" => $userID
        );

        try {
            if ($this->checkDuplicate('reference_id', $referenceID, 'transactions')) {
                throw new Exception("Failed to do insert new transaction. Duplicate reference ID.");
            }
            if (!$this->insertIntoTransactions($data)) {
                throw new Exception("Failed to update client application.");
            }
            if (!$this->updateBillingData($billingID)) {
                throw new Exception("Failed to update billing data.");
            }

            $this->conn->commitTransaction();

            $response = array(
                "status" => "success",
                "message" => "Payment confirmed successfully."
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
    public function retrieveClientApplicationFees()
    {
        $sql = "SELECT * FROM client_application_fees ORDER BY timestamp DESC LIMIT 1";
        $result = $this->conn->query($sql);

        if (!$result) {
            return "Failed: " . $this->conn->getErrorMessage();
        }
        if ($row = mysqli_fetch_assoc($result)) {
            $response = array(
                'client_application_fees' => $row
            );
            return $response;
        }
    }
    public function retrieveClientApplication($applicationID)
    {

        $queryClientApp = "SELECT * FROM client_application WHERE application_id = ?";
        $stmt = $this->conn->prepareStatement($queryClientApp);
        mysqli_stmt_bind_param($stmt, "s", $applicationID);
        if (!$stmt) {
            $response = array(
                "status" => "error",
                "client_application" => "Failed to client application fees" . $this->conn->getErrorMessage()
            );
            return $response;
        }
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if ($clientAppRow = mysqli_fetch_assoc($result)) {
                $response["client_application"] = $clientAppRow;
                return $response;
            }
        }
    }

    public function updateClientApplication($applicationID)
    {
        $sql = "UPDATE client_application SET billing_status = 'paid' WHERE application_id = ?";
        $stmt = $this->conn->prepareStatement($sql);

        mysqli_stmt_bind_param($stmt, "s", $applicationID);
        if (!mysqli_stmt_execute($stmt)) {
            return false;
        }
        return true;
    }

    public function confirmAppPayment($formData)
    {
        $this->conn->beginTransaction();

        $applicationID = htmlspecialchars($formData['applicationID'], ENT_QUOTES, 'UTF-8');
        $amountPaid = htmlspecialchars($formData['amountPaid'], ENT_QUOTES, 'UTF-8');

        $transactionID = $this->generateTransactionID();

        $transactionType = 'application_payment';
        $referenceID = $applicationID;

        $clientApplicationFees = $this->retrieveClientApplicationFees();
        $applicationFee = $clientApplicationFees['client_application_fees']['application_fee'];
        $inspectionFee = $clientApplicationFees['client_application_fees']['inspection_fee'];
        $registrationFee = $clientApplicationFees['client_application_fees']['registration_fee'];
        $connectionFee = $clientApplicationFees['client_application_fees']['connection_fee'];
        $installationFee = $clientApplicationFees['client_application_fees']['installation_fee'];

        $amountDue = intval($applicationFee) + intval($inspectionFee) + intval($registrationFee) + intval($connectionFee) + intval($installationFee);
        $remainingBalance = intval($amountPaid) - intval($amountDue);

        $roundedRemainingBalance = round($remainingBalance, 2);

        $clientApplication = $this->retrieveClientApplication($applicationID);
        $clientName = $clientApplication['client_application']['full_name'];
        $propertyType = $clientApplication['client_application']['property_type'];
        session_start();
        $userID = $_SESSION['user_id'];
        $userName = $_SESSION['user_name'];
        $description = "Payment received from $clientName - Property Type $propertyType - Confirmed by $userName";

        $data = array(
            "transactionID" => $transactionID,
            "transactionType" =>  $transactionType,
            "referenceID" => $referenceID,
            "description" => $description,
            "amountDue" => $amountDue,
            "amountPaid" => $amountPaid,
            "remainingBalance" => $roundedRemainingBalance,
            "confirmedBy" => $userID
        );

        try {
            if ($this->checkDuplicate('reference_id', $referenceID, 'transactions')) {
                throw new Exception("Failed to do insert new transaction. Duplicate reference ID.");
            }

            if (!$this->insertIntoTransactions($data)) {
                throw new Exception("Failed to update client application.");
            }

            if (!$this->updateClientApplication($applicationID)) {
                throw new Exception("Failed to update client application.");
            }

            $message = "Payment confirmed for application ID: " . $applicationID;
            $type = "payment_confirmation";

            if ($this->notificationExists($userID, $type, $applicationID)) {
                throw new Exception("Notification already exists for application ID: " . $applicationID);
            }

            if (!$this->addNotification($userID, $message, $type, $applicationID)) {
                throw new Exception("Failed to add notification.");
            }

            $this->conn->commitTransaction();

            $response = array(
                "status" => "success",
                "message" => "Payment confirmed successfully."
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
}


class DataTable extends BaseQuery
{
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
            $sql .= " WHERE bd.billing_type = 'billed' AND bd.billing_status = 'unpaid' AND " . implode(" AND ", $conditions);
        } else {
            $sql = "SELECT SQL_CALC_FOUND_ROWS bd.*, cd.* FROM billing_data AS bd";
            $sql .= " INNER JOIN client_data AS cd ON bd.client_id = cd.client_id";
            $sql .= " WHERE bd.billing_type = 'billed' AND bd.billing_status = 'unpaid'";
        }

        // echo $sql;
        // print_r($params);

        $validColumns = [
            'bd.client_id', 'bd.billing_id', 'cd.full_name',  'cd.property_type', 'bd.timestamp', 'cd.brgy'
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
                <th class="px-6 py-4" data-column-name="bd.billing_id" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Billing ID</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                        <span id="totalItemsSpan" class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer">' . $totalRecords . '</span>
                    </div>
                </th>
                <input id="totalItemsHidden" type="hidden" value="' . $totalRecords . '">
                <th class="px-6 py-4" data-column-name="bd.client_id" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Client ID</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
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
                <th class="px-6 py-4" data-column-name="bd.billing_amount" data-sortable="true">
                <div class="flex items-center gap-2">
                    <p>Amount</p>
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
            $billingID = $row['billing_id'];
            $clientID = $row['client_id'];
            $clientName = $row['full_name'];
            $propertyType = $row['property_type'];
            $billingAmount = $row['billing_amount'];
            $formattedBillingAmount = "₱" . number_format($billingAmount, 2, '.', ',');
            $time = $row['time'];
            $date = $row['date'];
            $readable_date = date("F j, Y", strtotime($date));
            $readable_time = date("h:i A", strtotime($time));

            $table .= '<tr class="table-auto bg-white border-b border-gray-200 group hover:bg-gray-100" data-id="' . $id . '">
            <td  class="px-6 py-3 text-sm">' . $number . '</td>
            <td  class="px-6 py-3 text-sm">' . $billingID . '</td>
            <td  class="px-6 py-3 text-sm">' . $clientID . '</td>
            <td  class="px-6 py-3 text-sm">' . $clientName . '</td>
            <td class="px-6 py-3 text-sm">' . $propertyType . '</td>
            <td class="px-6 py-3 text-sm font-semibold  group-hover:bg-gray-50 group-hover:text-indigo-500 group-hover:font-semibold ease-in-out duration-150">' . $formattedBillingAmount . '</td>
            <td class="px-6 py-3 text-sm">            
                <span class="font-medium text-sm">' . $readable_date . '</span> </br>
                <span class="text-xs">' . $readable_time . '</span>
            </td>
            <td class="flex items-center px-6 py-4 space-x-3">

                <button title="Accept Payment" onclick="acceptClientBillingPayment(\'' . $clientID . '\')" type="button" title="View Client" class="text-white bg-primary-700 hover:bg-primary-600 focus:ring-2 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center ">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 icon icon-tabler icon-tabler-cash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" >
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M7 9m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z"></path>
                <path d="M14 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                <path d="M17 9v-2a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v6a2 2 0 0 0 2 2h2"></path>
             </svg>
        
                <span class="ml-2 text-sm">Payment</span>
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
    public function clientAppBillingTable($dataTableParam)
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

        $conditions[] = "status = ?";
        $params[] = 'confirmed';
        $types .= "s";

        $conditions[] = "billing_status = ?";
        $params[] = 'unpaid';
        $types .= "s";

        if ($searchTerm) {
            $likeTerm = "%" . $searchTerm . "%";
            $conditions[] = "(full_name LIKE ? OR meter_number LIKE ? OR property_type LIKE ? OR application_id LIKE ?)";
            $params = array_merge($params, [$likeTerm, $likeTerm, $likeTerm, $likeTerm]);
            $types .= "ssss";
        }

        if (!empty($filters)) {
            foreach ($filters as $filter) {
                $conditions[] = "{$filter['column']} = ?";
                $params[] = $filter['value'];
                $types .= "s";  // Assuming all filter values are strings, adjust if not
            }
        }

        if (!empty($conditions)) {
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM client_application WHERE " . implode(" AND ", $conditions);
        } else {
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM client_application";
        }


        $validColumns = [
            'full_name', 'meter_number', 'property_type', 'brgy',  'application_id', 'timestamp', 'brgy'
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

        // More efficient way to get total records
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
                <th class="px-6 py-4" data-column-name="application_id" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Application ID</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                        <span id="totalItemsSpan" class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer">' . $totalRecords . '</span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="full_name" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Name</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
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
                <th class="px-6 py-4" data-column-name="timestamp" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Applied Date</p>
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
            $applicationID = $row['application_id'];
            $name = $row['full_name'];
            $propertyType = $row['property_type'];
            $street = $row['street'];
            $brgy = $row['brgy'];
            $time = $row['time'];
            $date = $row['date'];

            $readable_date = date("F j, Y", strtotime($date));
            $readable_time = date("h:i A", strtotime($time));

            $table .= '<tr class="table-auto bg-white border-b border-gray-200 group hover:bg-gray-100" data-id="' . $id . '">
            <td  class="px-6 py-3 text-sm">' . $number . '</td>
            <td  class="px-6 py-3 text-sm">' . $applicationID . '</td>
            <td  class="px-6 py-3 text-sm font-semibold  group-hover:bg-gray-50 group-hover:text-indigo-500 group-hover:font-semibold ease-in-out duration-150">' . $name . '</td>
            <td  class="px-6 py-3 text-sm">' . $propertyType . '</td>
            <td class="px-6 py-3 text-sm"> 
            <span class="font-medium text-sm">' . $brgy . '</span> </br>
            <span class="text-xs text-gray-400">' . $street . '</span>
        </td>
            <td class="px-6 py-3 text-sm">            
                <span class="font-medium text-sm">' . $readable_date . '</span> </br>
                <span class="text-xs">' . $readable_time . '</span>
            </td>

            <td class="flex items-center px-6 py-4 space-x-3">
            <button title="Accept Payment" onclick="acceptClientAppPayment(\'' . $applicationID . '\')" type="button" title="View Client" class="text-white bg-primary-700 hover:bg-primary-600 focus:ring-2 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center ">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 icon icon-tabler icon-tabler-cash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" >
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M7 9m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z"></path>
                <path d="M14 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                <path d="M17 9v-2a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v6a2 2 0 0 0 2 2h2"></path>
                </svg>
        
                <span class="ml-2 text-sm">Payment</span>
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
