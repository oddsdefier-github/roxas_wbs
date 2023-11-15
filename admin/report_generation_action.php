<?php

use Admin\Database\DatabaseConnection;

require './report_generation.php';

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
    $queryReportsData = new QueryReportsData($dbConnection);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    handleAction($action, $queryReportsData);
}

function handleAction($action, $queryReportsData)
{
    switch ($action) {
        case 'generateRevenueReports':
            handleGenerateApplicationRevenueReports($queryReportsData);
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
            break;
    }
}

function handleGenerateApplicationRevenueReports($queryReportsData)
{
    if (isset($_POST['dataParam'])) {
        $dataParam = $_POST['dataParam'];
        $data = $queryReportsData->generateRevenueReports($dataParam);
        echo json_encode($data);
    }

}
