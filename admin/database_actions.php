<?php

use Admin\Database\DatabaseConnection;

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
        case 'retrieveClientData':
            handleRetrieveClientData($dbQueries);
            break;
        case 'processClientApplication':
            handleProcessClientApplication($dbQueries);
            break;
        case 'approveClientApplication':
            handleApproveClientApplication($dbQueries);
            break;
        case 'getDataTable':
            handleGetDataTable($dataTable);
            break;
        case 'getTotalItem':
            handleGetTotalItem($dbQueries);
            break;
        case 'getName':
            handleGetName($dbQueries);
            break;
        case 'getClientApplicationData':
            handleGetClientApplicationData($dbQueries);
            break;
        case 'getAddressData':
            handleGetAddressData($dbQueries);
            break;
        case 'deleteItem':
            handleDeleteItem($dbQueries);
            break;
        case 'setInitialBillingData':
            handleSetInitialBillingData($dbQueries);
            break;
        case 'updatedClientAppStatus':
            handleUpdatedClientAppStatus($dbQueries);
            break;
        case 'loadNotification':
            handleLoadNotification($dbQueries);
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
            break;
    }
}

function handleRetrieveClientData($dbQueries)
{
    if (isset($_POST['clientID'])) {
        $client_id = $_POST['clientID'];
        $client_data = $dbQueries->retrieveClientData($client_id);
        echo json_encode($client_data);
    }
}

function handleProcessClientApplication($dbQueries)
{
    if (isset($_POST['formData'])) {
        $formData = $_POST['formData'];
        $processResponse = $dbQueries->processClientApplication($formData);
        echo json_encode($processResponse);
    }
}

function handleApproveClientApplication($dbQueries)
{
    if (isset($_POST['formData'])) {
        $formData = $_POST['formData'];
        $processResponse = $dbQueries->approveClientApplication($formData);
        echo json_encode($processResponse);
    }
}

function handleGetDataTable($dataTable)
{
    if (isset($_POST['dataTableParam']) && isset($_POST['tableName'])) {
        $dataTableParam = $_POST['dataTableParam'];
        $tableName = $_POST['tableName'];

        switch ($tableName) {
            case "client_application":
                $dataTable->clientApplicationTable($dataTableParam);
                break;
            case "client_data":
                $dataTable->clientTable($dataTableParam);
                break;
                // Add more cases if you have more tables with similar functionality.
                // case "another_table":
                //     $dataTable->anotherTableFunction($dataTableParam);
                //     break;
            default:
                echo "Invalid table name provided.";
        }
    }
}

function handleGetTotalItem($dbQueries)
{
    if (isset($_POST['tableName'])) {
        $tableName = $_POST['tableName'];
        $searchTerm = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : "";

        $getTotal = $dbQueries->getTotalItem($tableName, $searchTerm);
        echo json_encode($getTotal);
    }
}


function handleGetClientApplicationData($dbQueries)
{
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $getClientApplicationData = $dbQueries->retrieveClientApplicationData($id);
        echo json_encode($getClientApplicationData);
    }
}
function handleGetAddressData($dbQueries)
{
    $getAddressData = $dbQueries->fetchAddressData();
    echo json_encode($getAddressData);
}

function handleDeleteItem($dbQueries)
{
    if (isset($_POST['id']) && isset($_POST['tableName'])) {
        $id = $_POST['id'];
        $tableName = $_POST['tableName'];
        $deleteItem = $dbQueries->deleteItem($id, $tableName);
        echo json_encode($deleteItem);
    }
}

function handleGetName($dbQueries)
{
    if (isset($_POST['id']) && isset($_POST['tableName'])) {
        $id = $_POST['id'];
        $tableName = $_POST['tableName'];
        $getName = $dbQueries->getName($id, $tableName);
        echo json_encode($getName);
    }
}
function handleSetInitialBillingData($dbQueries)
{
    if (isset($_POST['regID'])) {
        $regID = $_POST['regID'];
        $setInitialBillingData = $dbQueries->setInitialBillingData($regID);
        echo json_encode($setInitialBillingData);
    }
}

function  handleUpdatedClientAppStatus($dbQueries)
{
    if (isset($_POST['applicantID']) && isset($_POST['documentsData'])) {
        $applicantID = $_POST['applicantID'];
        $documentsData = $_POST['documentsData'];
        $updateClientAppStatus = $dbQueries->updatedClientAppStatus($applicantID, $documentsData);
        echo json_encode($updateClientAppStatus);
    }
}


function handleLoadNotification($dbQueries)
{
    if (isset($_POST['limit'])) {
        $limit = $_POST['limit'];
        $dbQueries->loadNotificationHtml($limit);
    }
}
