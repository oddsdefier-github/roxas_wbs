<?php

use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

require './database_queries.php';
require __DIR__ . "/vendor/autoload.php";

function updateBillingData($conn, string $billingID)
{
    $sql = "UPDATE billing_data SET billing_type = 'billed' WHERE billing_id = ?";
    $stmt = $conn->prepareStatement($sql);

    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "s", $billingID);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}
function updateClientStatus($conn, string $clientID)
{
    $sql = "UPDATE client_data SET reading_status = 'read' WHERE client_id = ?";
    $stmt = $conn->prepareStatement($sql);

    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "s", $clientID);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}



function generateBillingPDF($conn)
{

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
            WHERE bd.billing_status = 'unpaid' AND bd.billing_type = 'verified'";


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

    $all_billings = "";

    foreach ($billing_data as $billing) {
        $qrCode = new QrCode($billing['billing_id']);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $qrDataUri = $result->getDataUri();


        $billingID = $billing['billing_id'];
        $accountNumber = $billing['client_id'];

        updateBillingData($conn, $billingID);
        updateClientStatus($conn, $accountNumber);

        $meterNumber = $billing['meter_number'];
        $propertyType = $billing['property_type'];
        $firstName = $billing['first_name'];
        $lastName = $billing['last_name'];
        $brgy = $billing['brgy'];
        $municipality = $billing['municipality'];
        $propertyType = $billing['property_type'];
        $billingMonth = $billing['billing_month'];

        $currReading = $billing['curr_reading'];
        $prevReading = $billing['prev_reading'];
        $consumption = $billing['consumption'];
        $rates = $billing['rates'];
        $formattedRates = number_format($rates, 2, '.', ',');
        $billingAmount = $billing['billing_amount'];
        $formattedBillingAmount = number_format($billingAmount, 2, '.', ',');
        $periodTo = $billing['period_to'];
        $periodFrom = $billing['period_from'];
        $dueDate = $billing['due_date'];
        $disconnectionDate = $billing['disconnection_date'];
        $timestamp = $billing['timestamp'];

        $date = new DateTime($timestamp, new DateTimeZone('Asia/Manila'));  // Explicitly specify the original timezone
        $formattedDate = $date->format('D M d, Y h:i A');  // Format the date

        $billingHtml = str_replace(
            ['{{billing_id}}', '{{datetime}}', '{{client_id}}', '{{last_name}}', '{{first_name}}', '{{brgy}}', '{{municipality}}', '{{curr_reading}}', '{{prev_reading}}', '{{consumption}}', '{{rates}}', '{{billing_amount}}', '{{billing_month}}', '{{meter_number}}', '{{property_type}}', '{{period_to}}', '{{period_from}}', '{{due_date}}', '{{disconnection_date}}', '{{meter_reader}}', '{{qr_code_path}}'],
            [$billingID, $formattedDate, $accountNumber, $lastName, $firstName, $brgy, $municipality, $currReading, $prevReading, $consumption, $formattedRates, $formattedBillingAmount, $billingMonth, $meterNumber, $propertyType, $periodTo, $periodFrom, $dueDate, $disconnectionDate, $meterReader, $qrDataUri],
            $template
        );

        $all_billings .= $billingHtml;
    }

    $currentMonth = strtoupper(date("M"));
    $currentYear = date("Y");


    $dompdf->loadHtml($all_billings);
    $dompdf->setPaper('legal');
    $dompdf->render();
    $dompdf->addInfo("Title", "Billing");

    // Stream PDF to client
    $fileName = $currentMonth . "-" . $currentYear;
    $dompdf->stream($fileName, ["Attachment" => 0]);

    $output = $dompdf->output();


    $fileName = "./temp/" . $currentMonth . "-" . $currentYear . "-BILLING-INVOICE.pdf";
    file_put_contents($fileName, $output);

}


generateBillingPDF($conn);
header('Location: ./bill_meter_reading.php');
