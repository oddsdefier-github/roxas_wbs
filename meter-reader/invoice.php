<?php

use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

// Load dependencies and set up the autoload
require './database_queries.php';
require __DIR__ . "/vendor/autoload.php";

// Configure Dompdf options
$options = new Options;
$options->setChroot(__DIR__);
$options->setIsRemoteEnabled(true);
$options->set('defaultFont', 'Helvetica');
$options->set('isHtml5ParserEnabled', true);

// Initialize Dompdf with the configured options
$dompdf = new Dompdf($options);

// SQL query to get all billing data
$sql = "SELECT * FROM billing_data";
$stmt = $conn->prepareStatement($sql);

// Initialize empty array to store billing data
$billing_data = [];

// Execute SQL query
if (mysqli_stmt_execute($stmt)) {
    $result = mysqli_stmt_get_result($stmt);
    // Fetch all rows and save them in the $billing_data array
    while ($row = mysqli_fetch_assoc($result)) {
        $billing_data[] = $row;
    }
} else {
    // Output error message if SQL query fails
    echo "Error executing statement: " . mysqli_stmt_error($stmt);
}

// Load HTML invoice template from a file
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
    $invoiceHtml = str_replace(
        ['{{client_id}}', '{{meter_reading}}', '{{qr_code_path}}'],
        [$invoice['client_id'], $invoice['meter_reading'], $qrDataUri],
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
