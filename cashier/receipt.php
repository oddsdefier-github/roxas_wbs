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


$template = file_get_contents('templates/invoice-billing.html');

// Initialize empty string to store all invoices
$all_invoices = "";

// Process each invoice
foreach ($billing_data as $invoice) {
    // Generate QR code for the invoice using Endroid library
    $qrCode = new QrCode($invoice['billing_id']);
    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    // Data URI for the QR code image
    $qrDataUri = $result->getDataUri();

    // Replace placeholders in the template with actual data
    $billingID = $invoice['billing_id'];
    $accountNUmber = $invoice['client_id'];
    $meterNumber = $invoice['meter_number'];
    $propertyType = $invoice['property_type'];
    $firstName = $invoice['first_name'];
    $middleName = $invoice['middle_name'];
    $lastName = $invoice['last_name'];
    $brgy = $invoice['brgy'];
    $municipality = $invoice['municipality'];
    $propertyType = $invoice['property_type'];
    $billingMonth = $invoice['billing_month'];
    $currReading = $invoice['curr_reading'];
    $prevReading = $invoice['prev_reading'];
    $consumption = $invoice['consumption'];
    $rates = $invoice['rates'];
    $billingAmount = $invoice['billing_amount'];
    $periodTo = $invoice['period_to'];
    $periodFrom = $invoice['period_from'];
    $dueDate = $invoice['due_date'];
    $disconnectionDate = $invoice['disconnection_date'];
    $timestamp = $invoice['timestamp'];

    $date = new DateTime($timestamp, new DateTimeZone('Asia/Manila'));  // Explicitly specify the original timezone
    $formattedDate = $date->format('D M d, Y h:i A');  // Format the date

    $invoiceHtml = str_replace(
        ['{{billing_id}}', '{{datetime}}', '{{client_id}}', '{{last_name}}', '{{first_name}}', '{{brgy}}', '{{municipality}}', '{{curr_reading}}', '{{prev_reading}}', '{{consumption}}', '{{rates}}', '{{billing_amount}}', '{{billing_month}}', '{{meter_number}}', '{{property_type}}', '{{period_to}}', '{{period_from}}', '{{due_date}}', '{{disconnection_date}}', '{{meter_reader}}', '{{qr_code_path}}'],
        [$billingID, $formattedDate, $accountNUmber, $lastName, $firstName, $brgy, $municipality, $currReading, $prevReading, $consumption, $rates, $billingAmount, $billingMonth, $meterNumber, $propertyType, $periodTo, $periodFrom, $dueDate, $disconnectionDate, $meterReader, $qrDataUri],
        $template
    );

    // Append individual invoice HTML to all invoices
    $all_invoices .= $invoiceHtml;
}

// Load combined invoices to Dompdf
$dompdf->loadHtml($all_invoices);

// Set paper size (Half Letter size in this case)
$dompdf->setPaper('legal');

// Generate PDF
$dompdf->render();

// Add metadata to PDF
$dompdf->addInfo("Title", "Billing");

// Stream PDF to client
$fileName = "invoices.pdf";
$dompdf->stream($fileName, ["Attachment" => 0]);

// Save PDF to file system
$output = $dompdf->output();
$fileName = "/invoices.pdf";
file_put_contents($fileName, $output);
