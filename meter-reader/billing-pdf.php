<?php

use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

require './database_queries.php';
require __DIR__ . "/vendor/autoload.php";

session_start();
$meterReader = $_SESSION['user_name'];

$options = new Options;
$options->setChroot(__DIR__);
$options->setIsRemoteEnabled(true);
$options->set('defaultFont', 'Helvetica');
$options->set('isHtml5ParserEnabled', true);

$dompdf = new Dompdf($options);

$sql = "SELECT cd.*, bd.*, sd.* 
        FROM client_data cd 
        JOIN billing_data bd ON cd.client_id = bd.client_id 
        JOIN client_secondary_data sd ON cd.client_id = sd.client_id 
        WHERE bd.billing_status = 'unpaid' AND bd.billing_type = 'actual'";


$stmt = $conn->prepareStatement($sql);

$billing_data = [];

if (mysqli_stmt_execute($stmt)) {
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $billing_data[] = $row;
    }
    echo "Error executing statement: " . mysqli_stmt_error($stmt);
}


$template = file_get_contents('templates/billing-template.html');

// Initialize empty string to store all billings
$all_billings = "";

// Process each billing
foreach ($billing_data as $billing) {
    // Generate QR code for the billing using Endroid library
    $qrCode = new QrCode($billing['billing_id']);
    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    // Data URI for the QR code image
    $qrDataUri = $result->getDataUri();

    // Replace placeholders in the template with actual data
    $billingID = $billing['billing_id'];
    $accountNUmber = $billing['client_id'];
    $meterNumber = $billing['meter_number'];
    $propertyType = $billing['property_type'];
    $firstName = $billing['first_name'];
    $middleName = $billing['middle_name'];
    $lastName = $billing['last_name'];
    $brgy = $billing['brgy'];
    $municipality = $billing['municipality'];
    $propertyType = $billing['property_type'];
    $billingMonth = $billing['billing_month'];
    $currReading = $billing['curr_reading'];
    $prevReading = $billing['prev_reading'];
    $consumption = $billing['consumption'];
    $rates = $billing['rates'];
    $billingAmount = number_format($billing['billing_amount']);
    $periodTo = $billing['period_to'];
    $periodFrom = $billing['period_from'];
    $dueDate = $billing['due_date'];
    $disconnectionDate = $billing['disconnection_date'];
    $timestamp = $billing['timestamp'];

    $date = new DateTime($timestamp, new DateTimeZone('Asia/Manila'));  // Explicitly specify the original timezone
    $formattedDate = $date->format('D M d, Y h:i A');  // Format the date

    $billingHtml = str_replace(
        ['{{billing_id}}', '{{datetime}}', '{{client_id}}', '{{last_name}}', '{{first_name}}', '{{brgy}}', '{{municipality}}', '{{curr_reading}}', '{{prev_reading}}', '{{consumption}}', '{{rates}}', '{{billing_amount}}', '{{billing_month}}', '{{meter_number}}', '{{property_type}}', '{{period_to}}', '{{period_from}}', '{{due_date}}', '{{disconnection_date}}', '{{meter_reader}}', '{{qr_code_path}}'],
        [$billingID, $formattedDate, $accountNUmber, $lastName, $firstName, $brgy, $municipality, $currReading, $prevReading, $consumption, $rates, $billingAmount, $billingMonth, $meterNumber, $propertyType, $periodTo, $periodFrom, $dueDate, $disconnectionDate, $meterReader, $qrDataUri],
        $template
    );

    // Append individual billing HTML to all billings
    $all_billings .= $billingHtml;
}

// Load combined billings to Dompdf
$dompdf->loadHtml($all_billings);

// Set paper size (Half Letter size in this case)
$dompdf->setPaper('legal');

// Generate PDF
$dompdf->render();

// Add metadata to PDF
$dompdf->addInfo("Title", "Billing");

// Stream PDF to client
$fileName = "billings.pdf";
$dompdf->stream($fileName, ["Attachment" => 0]);

// Save PDF to file system
$output = $dompdf->output();
$fileName = "/billings.pdf";
file_put_contents($fileName, $output);
