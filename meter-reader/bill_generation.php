<?php

use MeterReader\Database\DatabaseConnection;

require './pdf_generator.php';

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
    $pdfGenerator = new PdfGenerator($dbConnection);
    $wbsMailer = new WBSMailer($dbConnection);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    handleAction($action, $pdfGenerator, $wbsMailer);
}

function handleAction($action, $pdfGenerator, $wbsMailer)
{
    switch ($action) {
        case 'sendIndividualBilling':
            handleSendIndividualBilling($wbsMailer);
            break;
    }
}

function handleSendIndividualBilling($wbsMailer)
{
    $sendIndividualBill = $wbsMailer->sendIndividualBilling();
    echo json_encode($sendIndividualBill);
}
