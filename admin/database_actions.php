<?php

use Admin\Database\DatabaseConnection;

require './database_queries.php';

if ($conn) {
    $dbConnection = new DatabaseConnection($host1, $username1, $password1, $database1);
    $dbQueries = new DatabaseQueries($dbConnection);
    $dataTable = new DataTable($dbConnection);
} else {
    echo "Database connection failed.";
}


if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'retrieveClientData':
            if (isset($_POST['updateId'])) {
                $client_id = $_POST['updateId'];
                $client_data = $dbQueries->retrieveClientData($client_id);
                echo json_encode($client_data);
            }
            break;

        case 'processClientApplication':
            if (isset($_POST['formData'])) {
                $formData = $_POST['formData'];
                $processResponse = $dbQueries->processClientApplication($formData);
                echo json_encode($processResponse);
            }
            break;
        case 'approveClientApplication':
            if (isset($_POST['formData'])) {
                $formData = $_POST['formData'];
                $processResponse = $dbQueries->approveClientApplication($formData);
                echo json_encode($processResponse);
            }
            break;
        case 'getDataTable':
            if (isset($_POST['dataTableParam'])) {
                $dataTableParam = $_POST['dataTableParam'];
                $html = $dataTable->clientApplicationTable($dataTableParam);
            }
            break;

        case 'getTotalItem':
            if (isset($_POST['tableName'])) {
                $tableName = $_POST['tableName'];
                $getTotal = $dbQueries->getTotalItem($tableName);
                echo json_encode($getTotal);
            }
            break;
        case 'getClientApplicationData':
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                $getClientApplicationData = $dbQueries->retrieveClientApplicationData($id);
                echo json_encode($getClientApplicationData);
            }
            break;

        default:
            break;
    }
}
