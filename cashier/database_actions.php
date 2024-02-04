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
        case 'retrieveUserData':
            handleRetrieveUserData($dbQueries);
            break;
        case 'confirmAppPayment':
            handleConfirmAppPayment($dbQueries);
            break;
        case 'confirmBillingPayment':
            handleConfirmBillingPayment($dbQueries);
            break;
        case 'loadNotification':
            handleLoadNotification($dbQueries);
            break;
        case 'retrieveClientApplication':
            handleRetrieveClientApplication($dbQueries);
            break;
        case 'retrieveClientApplicationFee':
            handleRetrieveClientApplicationFee($dbQueries);
            break;
        case 'retrieveBillingRates':
            handleRetrieveBillingRates($dbQueries);
            break;
        case 'retrieveBillingData':
            handleRetrieveBillingData($dbQueries);
            break;
        case 'countUnreadNotifications':
            handleCountUnreadNotification($dbQueries);
            break;
        case 'checkClientIDExistence':
            handleCheckClientIDExistence($dbQueries);
            break;
        case 'updateUserProfile':
            handleUpdateUserProfile($dbQueries);
            break;
        case 'updateUserProfile':
            handleUpdateUserProfile($dbQueries);
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
            case "reports":
                $dataTable->reportsTable($dataTableParam);
                break;
            default:
                echo "Invalid table name provided.";
        }
    }
}

function handleRetrieveUserData($dbQueries)
{
    if (isset($_POST['userID'])) {
        $user_id = $_POST['userID'];
        $user_data = $dbQueries->retrieveUserData($user_id);
        echo json_encode($user_data);
    }
}
function handleRetrieveClientApplicationFee($dbQueries)
{
    $retrieveClientApplicationFees = $dbQueries->retrieveClientApplicationFees();
    echo json_encode($retrieveClientApplicationFees);
}
function handleConfirmAppPayment($dbQueries)
{
    if (isset($_POST['formData'])) {
        $formData = $_POST['formData'];
        $confirmAppPayment = $dbQueries->confirmAppPayment($formData);
        echo json_encode($confirmAppPayment);
    }
}

function handleLoadNotification($dbQueries)
{
    if (isset($_POST['limit'])) {
        $limit = $_POST['limit'];
        $dbQueries->loadNotificationHtml($limit);
    }
}

function handleRetrieveClientApplication($dbQueries)
{
    if (isset($_POST['applicationID'])) {
        $applicationID = $_POST['applicationID'];
        $clientApplicationChargingFees =  $dbQueries->retrieveClientApplication($applicationID);
        echo json_encode($clientApplicationChargingFees);
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
function handleConfirmBillingPayment($dbQueries)
{
    if (isset($_POST['formData'])) {
        $formData = $_POST['formData'];
        $confirmBillPayment = $dbQueries->confirmBillingPayment($formData);
        echo json_encode($confirmBillPayment);
    }
}
function handleCountUnreadNotification($dbQueries)
{
    $count = $dbQueries->countUnreadNotifications();
    echo $count;
}
function handleCheckClientIDExistence($dbQueries)
{
    if (isset($_POST['clientID'])) {
        $clientID = $_POST['clientID'];
        $checkClientIDExistence = $dbQueries->checkClientIDExistence($clientID);
        echo json_encode($checkClientIDExistence);
    }

}

function handleUpdateUserProfile($dbQueries)
{
    if (isset($_POST['formData'])) {
        $formData = $_POST['formData'];
        $updateUserProfile = $dbQueries->updateUserProfile($formData);
        echo json_encode($updateUserProfile);
    }
}
