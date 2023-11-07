<?php

use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

use League\OAuth2\Client\Provider\Google;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

// Initialize empty string to store all billings
$all_billings = "";

$all_pdf_paths = [];

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
    $email = $billing['email'];
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

    $dompdf->loadHtml($billingHtml);
    $dompdf->setPaper('legal');
    $dompdf->render();

    // Save individual PDF to temporary directory
    $individualFileName = __DIR__ . '/temp/' . $billingID . '.pdf';
    file_put_contents($individualFileName, $dompdf->output());
    $all_pdf_paths[] = $individualFileName; // Keep track of this file

    // Prepare and send the email with the PDF attached
    $mail = new PHPMailer(true);

    try {

        $provider = new Google([
            'clientId'     => '528897583972-kcpsk9dkalmr5beu32ui9368g9ifbff7.apps.googleusercontent.com',
            'clientSecret' => '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',
            'redirectUri'  => 'https://example.com/callback-url',
        ]);

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        //to view proper logging details for success and error messages
        // $mail->SMTPDebug = 1;
        $mail->Host = 'smtp.gmail.com';  //gmail SMTP server
        $mail->Username = 'roxaswaterbillingsystem@gmail.com';   //email
        $mail->Password = 'sluzmpnriimiseul';   //16 character obtained from app password created
        $mail->Port = 465;                    //SMTP port
        $mail->SMTPSecure = "ssl";

        $mail->setFrom('roxaswaterbillingsystem@gmail.com', 'Roxas Water Billing System Inc.');
        $mail->addAddress($email, $firstName . ' ' . $lastName); // Add a recipient

        $mail->addAttachment($individualFileName); // Add the PDF generated

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Your Billing Information';
        $mail->Body    = 'Please find your billing information attached.';

        $mail->send();
        echo 'Message has been sent';

        if (!$mail->send()) {
            throw new Exception('Email not sent an error was encountered: ' . $mail->ErrorInfo);
        } else {
            echo 'Message has been sent.';
        }


    } catch (Exception $e) {
        echo $e->getMessage();
    }

    // Append individual billing HTML to all billings
    $all_billings .= $billingHtml;
}


// $dompdf->loadHtml($all_billings);
// $dompdf->setPaper('legal');
// $dompdf->render();
// $dompdf->addInfo("Title", "Billing");

// $fileName = "billings.pdf";
// $dompdf->stream($fileName, ["Attachment" => 0]);

// // Save PDF to file system
// $output = $dompdf->output();
// $fileName = "/billings.pdf";
// file_put_contents($fileName, $output);


$concatenatedPdf = new Dompdf($options);
$concatenatedPdf->loadHtml(implode('', array_map('file_get_contents', $all_pdf_paths)));
$concatenatedPdf->setPaper('legal');
$concatenatedPdf->render();
$dompdf->addInfo("Title", "Billing");

$finalFileName = 'billings_combined.pdf';
$dompdf->stream($finalFileName, ["Attachment" => 0]);

// Save the final concatenated PDF

file_put_contents($finalFileName, $concatenatedPdf->output());
