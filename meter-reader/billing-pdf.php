<?php

use MeterReader\Database\DatabaseConnection;

require './database_queries.php';
require __DIR__ . "/vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

$clientID = null;

if (isset($_GET['id'])) {
    $clientID = strval($_GET['id']);
}

function getTaxRate($conn)
{
    $sql = "SELECT tax FROM rates ORDER BY timestamp DESC LIMIT 1";
    $stmt = $conn->prepareStatement($sql);

    if (!$stmt || !$stmt->execute()) {
        return null;
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['tax'];
    } else {
        return null;
    }
}
function queryDataForInvoice($conn, $clientID)
{
    $taxRate = getTaxRate($conn);
    if ($taxRate === null) {
        return null;
    }
    $sql = "SELECT cd.*, bd.*, sd.*
            FROM client_data cd 
            JOIN billing_data bd ON cd.client_id = bd.client_id 
            JOIN client_secondary_data sd ON cd.client_id = sd.client_id 
            WHERE cd.client_id = ? AND bd.billing_status = 'unpaid' AND bd.billing_type = 'billed'";

    $stmt = $conn->prepareStatement($sql);

    if (!$stmt || !$stmt->bind_param("s", $clientID) || !$stmt->execute()) {
        return null;
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $data['tax_rate'] = $taxRate;
        $stmt->close();
        return $data;
    } else {
        $stmt->close();
        return null;
    }
}

function generateIndividualBilling($data)
{
    $template = file_get_contents('templates/billing-template.html');

    $options = new Options();
    $options->setChroot(__DIR__);
    $options->setIsRemoteEnabled(true);
    $options->set('defaultFont', 'Helvetica');
    $options->set('isHtml5ParserEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->setPaper('legal');
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $meterReader = $_SESSION['user_name'];

    $qrCode = new QrCode($data['client_id']);
    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    $qrDataUri = $result->getDataUri();
    $billingID = $data['billing_id'];
    $accountNumber = $data['client_id'];
    $meterNumber = $data['meter_number'];
    $propertyType = $data['property_type'];
    $firstName = $data['first_name'];
    $lastName = $data['last_name'];
    $brgy = $data['brgy'];
    $municipality = $data['municipality'];
    $propertyType = $data['property_type'];
    $billingMonth = $data['billing_month'];
    $currReading = $data['curr_reading'];
    $prevReading = $data['prev_reading'];
    $consumption = $data['consumption'];
    $rates = $data['rates'];
    $formattedRates = number_format($rates, 2, '.', ',');
    $billingAmount = $data['billing_amount'];
    $formattedBillingAmount = number_format($billingAmount, 2, '.', ',');
    $taxRate = $data['tax_rate'];
    $taxAmount = $billingAmount * ($taxRate / 100);
    $formattedTaxAmount = number_format($taxAmount, 2, '.', ',');
    $totalAmount = $billingAmount + $taxAmount;
    $formattedTotalAmount = number_format($totalAmount, 2, '.', ',');
    $periodTo = $data['period_to'];
    $periodFrom = $data['period_from'];
    $dueDate = $data['due_date'];
    $disconnectionDate = $data['disconnection_date'];
    $timestamp = $data['timestamp'];

    $date = new DateTime($timestamp, new DateTimeZone('Asia/Manila'));
    $formattedDate = $date->format('D M d, Y h:i A');

    $billingHtml = str_replace(
        ["{{billing_id}}", "{{datetime}}", "{{client_id}}", "{{last_name}}", "{{first_name}}", "{{brgy}}", "{{municipality}}", "{{curr_reading}}", "{{prev_reading}}", "{{consumption}}", "{{rates}}", "{{tax}}", "{{billing_amount}}", "{{billing_month}}", "{{meter_number}}", "{{property_type}}", "{{period_to}}", "{{period_from}}", "{{due_date}}", "{{disconnection_date}}", "{{meter_reader}}", "{{qr_code_path}}"],
        [$billingID, $formattedDate, $accountNumber, $lastName, $firstName, $brgy, $municipality, $currReading, $prevReading, $consumption, $formattedRates, $formattedTaxAmount, $formattedTotalAmount, $billingMonth, $meterNumber, $propertyType, $periodTo, $periodFrom, $dueDate, $disconnectionDate, $meterReader, $qrDataUri],
        $template
    );

    $dompdf->loadHtml($billingHtml);
    $dompdf->render();
    $dompdf->addInfo("Title", "Billing");
    $fileName = $billingID . ".pdf";
    $dompdf->stream($fileName, ["Attachment" => 0]);

    $output = $dompdf->output();
    $fileName = "temp/" . $billingID . ".pdf";
    file_put_contents($fileName, $output);
}

$clientData = queryDataForInvoice($conn, $clientID);
if (!$clientData) {
    echo "Error: Unable to retrieve valid data for billing.";
}

print_r($clientData);
generateIndividualBilling($clientData);
