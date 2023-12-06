<?php

use MeterReader\Database\DatabaseConnection;

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
    $wbsMailer = new WBSMailer($dbConnection);
    $dataTable = new DataTable($dbConnection);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    handleAction($action, $dbQueries, $wbsMailer, $dataTable);
}

function handleAction($action, $dbQueries, $wbsMailer, $dataTable)
{
    switch ($action) {
        case 'getClientData':
            handleGetClientData($dbQueries);
            break;
        case 'getDataTable':
            handleGetDataTable($dataTable);
            break;
        case 'getAddressData':
            handleGetAddressData($dbQueries);
            break;
        case 'encodeMeterReadingData':
            handleEncodeMeterReadingData($dbQueries);
            break;
        case 'editReadingData':
            handleEditReadingData($dbQueries);
            break;
        case 'sendIndividualBilling':
            handleSendIndividualBilling($wbsMailer);
            break;
        case 'getLatestBillingLogDataForMonth':
            handleGetLatestBillingLogDataForMonth($dbQueries);
            break;
        case 'checkEncodedBill':
            handleCheckEncodedBill($dbQueries);
            break;
        case 'checkVerifiedBill':
            handleCheckVerifiedBill($dbQueries);
            break;
        case 'verifyAllBillingData':
            handleVerifyAllBillingData($dbQueries);
            break;
        case 'submitMeterReport':
            handleSubmitMeterReport($dbQueries);
            break;
        case 'generateAllBilling':
            handleGenerateAllBilling($dbQueries);
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
            break;
    }
}

function handleGetClientData($dbQueries)
{
    if (isset($_POST['clientID'])) {
        $clientID = $_POST['clientID'];
        $retrieveData = $dbQueries->getClientData($clientID);
        echo json_encode($retrieveData);
    }
}

function handleGetDataTable($dataTable)
{
    if (isset($_POST['dataTableParam']) && isset($_POST['tableName'])) {
        $dataTableParam = $_POST['dataTableParam'];
        $tableName = $_POST['tableName'];

        switch ($tableName) {
            case "client_data":
                $dataTable->clientTable($dataTableParam);
                break;
            case "billing_data":
                $dataTable->billingTable($dataTableParam);
                break;
            case "recent_meter_reading_data":
                $dataTable->recentReadingTable($dataTableParam);
                break;
            default:
                echo "Invalid table name provided.";
        }
    }
}

function handleGetAddressData($dbQueries)
{
    $getAddressData = $dbQueries->fetchAddressData();
    echo json_encode($getAddressData);
}

function handleEncodeMeterReadingData($dbQueries)
{
    if (isset($_POST['formData'])) {
        $formData = $_POST['formData'];
        $encodeMeterReadingData = $dbQueries->encodeCurrentReading($formData);
        echo json_encode($encodeMeterReadingData);
    }
}

function handleEditReadingData($dbQueries)
{
    if (isset($_POST['formData'])) {
        $formData = $_POST['formData'];
        $editReadingData = $dbQueries->editReadingData($formData);
        echo json_encode($editReadingData);
    }
}


function handleSendIndividualBilling($wbsMailer)
{
    if (isset($_POST['clientID'])) {
        $clientID = $_POST['clientID'];
        $sendIndividualBilling = $wbsMailer->sendIndividualBilling($clientID);
        echo json_encode($sendIndividualBilling);
    }
}


function handleCheckEncodedBill($dbQueries)
{
    $checkEncodedBill = $dbQueries->checkEncodedBill();
    echo json_encode($checkEncodedBill);
}
function handleCheckVerifiedBill($dbQueries)
{
    $checkVerifiedBill = $dbQueries->checkVerifiedBill();
    echo json_encode($checkVerifiedBill);
}
function handleVerifyAllBillingData($dbQueries)
{
    $verifyAllBillingData = $dbQueries->verifyAllBillingData();
    echo json_encode($verifyAllBillingData);
}

function handleSubmitMeterReport($dbQueries)
{
    if (isset($_FILES['add_img']) && !empty($_FILES['add_img']) && isset($_POST['report_description']) && !empty($_POST['report_description'])) {
        $filesArray = $_FILES['add_img'];
        $reportDescription = $_POST['report_description'];
        $otherSpecify = $_POST['other_specify'];
        $issueType = $_POST['issue_type'];
        $clientID = $_POST['clientID'];
        $meterNumber = $_POST['meterNumber'];

        $formData = array(
            'client_id' => $clientID,
            'meter_number' => $meterNumber,
            'issue_type' => $issueType,
            'other_specify' => $otherSpecify,
            'report_description' => $reportDescription,
            'files' => $filesArray
        );

        $submitReport = $dbQueries->submitMeterReport($formData);
        echo json_encode($submitReport);
    } else {
        echo json_encode(array('error' => 'Missing data'));
    }
}

function handleGenerateAllBilling($dbQueries)
{
    $generateAllBilling = $dbQueries->generateAllBilling();
    echo json_encode($generateAllBilling);
}

function handleGetLatestBillingLogDataForMonth($dbQueries)
{
    $latestBillingLog = $dbQueries->getLatestBillingLogDataForMonth();
    echo json_encode($latestBillingLog);
}
