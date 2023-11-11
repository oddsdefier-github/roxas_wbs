<?php

use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

require './database_queries.php';
require __DIR__ . "/vendor/autoload.php";

session_start();
$meterReader = $_SESSION['user_name'];

$options = new Options();
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

$template = file_get_contents('templates/invoice-billing.html');

$invoiceHtml = str_replace(
    ['{{transaction_id}}', '{{date}}', '{{client_id}}', '{{last_name}}', '{{first_name}}', '{{meter_number}}','{{property_type}}', '{{brgy}}', '{{municipality}}', '{{consumption}}', '{{rates}}', '{{penalty}}', '{{tax}}', '{{amount_due}}', '{{cashier}}'],
    [$transactionID, $date, $clientID, $lastName, $firstName, $meterNumber, $brgy, $municipality, $consumption, $rates,$penalty, $tax, $amountDue, $cashier],
    $template
);

$dompdf->loadHtml($invoiceHtml);
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
