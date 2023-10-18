<?php

use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

require './database_queries.php';
require __DIR__ . "/vendor/autoload.php";

$options = new Options;
$options->setChroot(__DIR__);
$options->setIsRemoteEnabled(true);
$options->set('defaultFont', 'Helvetica');
$options->set('isHtml5ParserEnabled', true);

$dompdf = new Dompdf($options);

$sql = "SELECT bd.*, sd.* 
        FROM billing_data bd 
        JOIN client_secondary_data sd ON bd.client_id = sd.client_id 
        WHERE bd.billing_status = 'unpaid'";

$stmt = $conn->prepareStatement($sql);

$billing_data = [];

if (mysqli_stmt_execute($stmt)) {
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $billing_data[] = $row;
    }
    echo "Error executing statement: " . mysqli_stmt_error($stmt);
}


$template = file_get_contents('templates/template.html');

// Initialize empty string to store all invoices
$all_invoices = "";

// Process each invoice
foreach ($billing_data as $invoice) {
    // Generate QR code for the invoice using Endroid library
    $qrCode = new QrCode(json_encode($invoice));
    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    // Data URI for the QR code image
    $qrDataUri = $result->getDataUri();

    // Replace placeholders in the template with actual data

    $accountNUmber = $invoice['client_id'];
    $firstName = $invoice['first_name'];
    $middleName = $invoice['middle_name'];
    $lastName = $invoice['last_name'];
    $street = $invoice['street'];
    $brgy = $invoice['brgy'];
    $municipality = $invoice['municipality'];

    $propertyType = $invoice['property_type'];

    $invoiceHtml = str_replace(
        ['{{client_id}}', '{{last_name}}', '{{first_name}}', '{{brgy}}', '{{municipality}}', '{{meter_reading}}', '{{qr_code_path}}'],
        [$accountNUmber, $lastName, $firstName, $brgy, $municipality, $invoice['meter_reading'], $qrDataUri],
        $template
    );

    // Append individual invoice HTML to all invoices
    $all_invoices .= $invoiceHtml;
}

// Load combined invoices to Dompdf
$dompdf->loadHtml($all_invoices);

// Set paper size (Half Letter size in this case)
$dompdf->setPaper('letter');

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
