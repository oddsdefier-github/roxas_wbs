<?php

use Cashier\Database\DatabaseConnection;

require './database_queries.php';

function sanitizeArray($array)
{
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $array[$key] = sanitizeArray($value);
        } else {
            $array[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
    }
    return $array;
}

$_POST = sanitizeArray($_POST);

if ($conn) {
    $dbConnection = new DatabaseConnection($host1, $username1, $password1, $database1);
    $dbQueries = new DatabaseQueries($dbConnection);
    $dataTable = new DataTable($dbConnection);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    handleAction($action, $dbQueries, $dataTable);
}

function handleAction($action, $dbQueries, $dataTable)
{
    switch ($action) {
        case 'getDataTable':
            handleGetDataTable($dataTable);
            break;
        case 'confirmAppPayment':
            handleConfirmAppPayment($dbQueries);
            break;
        case 'confirmBillPayment':
            handleConfirmAppPayment($dbQueries);
            break;
        case 'loadNotification':
            handleLoadNotification($dbQueries);
            break;
        case 'retrieveChargingFees':
            handleRetrieveChargingFees($dbQueries);
            break;
        case 'retrieveBillingRates':
            handleRetrieveBillingRates($dbQueries);
            break;
        case 'retrieveBillingData':
            handleRetrieveBillingData($dbQueries);
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
            break;
    }
}

function handleGetDataTable($dataTable)
{
    if (isset($_POST['dataTableParam']) && isset($_POST['tableName'])) {
        $dataTableParam = $_POST['dataTableParam'];
        $tableName = $_POST['tableName'];

        switch ($tableName) {
            case "billing_data":
                $dataTable->billingTable($dataTableParam);
                break;
            case "client_application":
                $dataTable->clientAppBillingTable($dataTableParam);
                break;
            default:
                echo "Invalid table name provided.";
        }
    }
}

function handleConfirmAppPayment($dbQueries)
{
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $confirmAppPayment = $dbQueries->confirmAppPayment($id);
        echo json_encode($confirmAppPayment);
    }
}
function handleConfirmBillPayment($dbQueries)
{
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $confirmBillPayment = $dbQueries->confirmBillPayment($id);
        echo json_encode($confirmBillPayment);
    }
}

function handleLoadNotification($dbQueries)
{
    $dbQueries->loadNotificationHtml();
}

function handleRetrieveChargingFees($dbQueries)
{
    if (isset($_POST['type']) && isset($_POST['id'])) {
        $id = $_POST['id'];
        $table = $_POST['type'];
        if ($table === 'client_application_fees') {
            $clientApplicationChargingFees =  $dbQueries->retrieveApplicationFees($id, $table);
            echo json_encode($clientApplicationChargingFees);
        } else if ($table === 'penalty_fees') {
            $billingChargingFees =  $dbQueries->retrieveApplicationFees($id, $table);
            echo json_encode($billingChargingFees);
        }
    }
}

function handleRetrieveBillingRates($dbQueries)
{
    $retrieveBillingRates = $dbQueries->retrieveBillingRates();
    echo json_encode($retrieveBillingRates);
}
function handleRetrieveBillingData($dbQueries)
{
    if (isset($_POST['clientID'])) {
        $clientID = $_POST['clientID'];
        $retrieveBillingData = $dbQueries->retrieveBillingData($clientID);
        echo json_encode($retrieveBillingData);
    }
}
