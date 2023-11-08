<?php

// use MeterReader\Database\DatabaseConnection;

// use Dompdf\Dompdf;
// use Dompdf\Options;
// use Endroid\QrCode\QrCode;
// use Endroid\QrCode\Writer\PngWriter;

// use League\OAuth2\Client\Provider\Google;
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require 'database/connection.php';
// require __DIR__ . "/vendor/autoload.php";

// class BaseQuery
// {
//     protected $conn;

//     public function __construct(DatabaseConnection $databaseConnection)
//     {
//         $this->conn = $databaseConnection;
//     }
// }


// class PdfGenerator
// {
//     public function generateIndividualBilling($data)
//     {
//         $template = file_get_contents('templates/billing-template.html');

//         $options = new Options();
//         $options->setChroot(__DIR__);
//         $options->setIsRemoteEnabled(true);
//         $options->set('defaultFont', 'Helvetica');
//         $options->set('isHtml5ParserEnabled', true);

//         $dompdf = new Dompdf($options);
//         if (session_status() == PHP_SESSION_NONE) {
//             session_start();
//         }
//         $meterReader = $_SESSION['user_name'];

//         $qrCode = new QrCode($data['billing_id']);
//         $writer = new PngWriter();
//         $result = $writer->write($qrCode);

//         // Data URI for the QR code image
//         $qrDataUri = $result->getDataUri();

//         $billingID = $data['billing_id'];
//         $accountNUmber = $data['client_id'];
//         $meterNumber = $data['meter_number'];
//         $propertyType = $data['property_type'];
//         $firstName = $data['first_name'];
//         $lastName = $data['last_name'];
//         $brgy = $data['brgy'];
//         $municipality = $data['municipality'];
//         $propertyType = $data['property_type'];
//         $billingMonth = $data['billing_month'];
//         $currReading = $data['curr_reading'];
//         $prevReading = $data['prev_reading'];
//         $consumption = $data['consumption'];
//         $rates = $data['rates'];
//         $formattedRates = number_format($rates, 2, '.', ',');
//         $billingAmount = $data['billing_amount'];
//         $formattedBillingAmount = number_format($billingAmount, 2, '.', ',');
//         $periodTo = $data['period_to'];
//         $periodFrom = $data['period_from'];
//         $dueDate = $data['due_date'];
//         $disconnectionDate = $data['disconnection_date'];
//         $timestamp = $data['timestamp'];

//         $date = new DateTime($timestamp, new DateTimeZone('Asia/Manila'));  // Explicitly specify the original timezone
//         $formattedDate = $date->format('D M d, Y h:i A');  // Format the date

//         $billingHtml = str_replace(
//             ['{{billing_id}}', '{{datetime}}', '{{client_id}}', '{{last_name}}', '{{first_name}}', '{{brgy}}', '{{municipality}}', '{{curr_reading}}', '{{prev_reading}}', '{{consumption}}', '{{rates}}', '{{billing_amount}}', '{{billing_month}}', '{{meter_number}}', '{{property_type}}', '{{period_to}}', '{{period_from}}', '{{due_date}}', '{{disconnection_date}}', '{{meter_reader}}', '{{qr_code_path}}'],
//             [$billingID, $formattedDate, $accountNUmber, $lastName, $firstName, $brgy, $municipality, $currReading, $prevReading, $consumption, $formattedRates, $formattedBillingAmount, $billingMonth, $meterNumber, $propertyType, $periodTo, $periodFrom, $dueDate, $disconnectionDate, $meterReader, $qrDataUri],
//             $template
//         );

//         $dompdf->loadHtml($billingHtml);
//         $dompdf->setPaper('legal');
//         $dompdf->render();

//         $individualFileName = __DIR__ . '/temp/' . $billingID . '.pdf';
//         if (file_put_contents($individualFileName, $dompdf->output())) {
//             return $individualFileName;
//         } else {
//             return null;
//         }
//     }

// }
// class WBSMailer extends PdfGenerator
// {
//     // public function queryAllEmails($status)
//     // {
//     //     $sql = "SELECT client_data.email
//     //             FROM client_data
//     //             JOIN billing_data ON client_data.client_id = billing_data.client_id
//     //             WHERE client_data.status = ? AND billing_data.billing_type = 'verified' AND client_data.reading_status = 'encoded'";
//     //     $stmt = $this->conn->prepareStatement($sql);

//     //     if (!$stmt) {
//     //         return null;
//     //     }
//     //     mysqli_stmt_bind_param($stmt, "s", $status);
//     //     if (!mysqli_stmt_execute($stmt)) {
//     //         return null;
//     //     }
//     //     $result = mysqli_stmt_get_result($stmt);
//     //     if (!$result) {
//     //         return null;
//     //     }
//     //     $emailList = [];

//     //     while ($row = mysqli_fetch_assoc($result)) {
//     //         $emailList[] = $row['email'];
//     //     }

//     //     if (empty($emailList)) {
//     //         return null;
//     //     }

//     //     mysqli_stmt_free_result($stmt);
//     //     mysqli_stmt_close($stmt);
//     //     return $emailList;
//     // }


//     // public function selectClientID($email)
//     // {
//     //     $sql = "SELECT client_id FROM client_data WHERE email = ?";
//     //     $stmt = $this->conn->prepareStatement($sql);
//     //     if (!$stmt) {
//     //         return null;
//     //     }

//     //     mysqli_stmt_bind_param($stmt, "s", $email);
//     //     if (!mysqli_stmt_execute($stmt)) {
//     //         return null;
//     //     }

//     //     $result = mysqli_stmt_get_result($stmt);
//     //     if (!$result) {
//     //         return null;
//     //     }

//     //     $row = mysqli_fetch_assoc($result);
//     //     $clientID = $row['client_id'];

//     //     mysqli_stmt_free_result($stmt);
//     //     mysqli_stmt_close($stmt);
//     //     return $clientID;

//     // }
//     public function queryDataForInvoice($clientID)
//     {
//         $sql = "SELECT cd.*, bd.*, sd.*
//         FROM client_data cd
//         JOIN billing_data bd ON cd.client_id = bd.client_id
//         JOIN client_secondary_data sd ON cd.client_id = sd.client_id
//         WHERE cd.client_id = ? AND bd.billing_status = 'unpaid' AND bd.billing_type = 'verified'";

//         $stmt = $this->conn->prepareStatement($sql);

//         if (!$stmt) {
//             return null;
//         }

//         mysqli_stmt_bind_param($stmt, "s", $clientID);

//         if (!mysqli_stmt_execute($stmt)) {
//             return null;
//         }
//         $result = mysqli_stmt_get_result($stmt);
//         $data = mysqli_fetch_assoc($result);

//         mysqli_stmt_free_result($stmt);
//         mysqli_stmt_close($stmt);
//         return $data;
//     }

//     public function insertIntoEmailLogs($data)
//     {
//         $clientID = $data['client_id'];
//         $referenceID = $data['billing_id'];
//         $sentTo = $data['sent_to'];
//         $sentFrom = $data['sent_from'];
//         $userID = $data['user_id'];

//         $sql = "INSERT INTO email_logs (client_id, reference_id, sent_to, sent_from, user_id,time, date, timestamp) VALUES (?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";
//         $stmt = $this->conn->prepareStatement($sql);

//         if (!$stmt) {
//             return false;
//         }
//         $stmt->bind_param('sssss', $clientID, $referenceID, $sentTo, $sentFrom, $userID);

//         if (!mysqli_stmt_execute($stmt)) {
//             mysqli_stmt_close($stmt);
//             return true;
//         } else {
//             mysqli_stmt_close($stmt);
//             return false;
//         }
//     }
//     public function checkSentEmail($billingID)
//     {
//         $sql = "SELECT reference_id FROM email_logs WHERE reference_id = ?";
//         $stmt = $this->conn->prepareStatement($sql);

//         if (!$stmt) {
//             return false;
//         }

//         mysqli_stmt_bind_param($stmt, "s", $billingID);

//         if (!mysqli_stmt_execute($stmt)) {
//             mysqli_stmt_close($stmt);
//             return false;
//         }

//         mysqli_stmt_store_result($stmt);

//         $isExist = mysqli_stmt_num_rows($stmt) > 0;

//         mysqli_stmt_close($stmt);

//         return $isExist;
//     }
//     public function mailBillingInvoice($clientData, $filepath)
//     {
//         $requiredFields = ['email', 'first_name', 'last_name'];
//         foreach ($requiredFields as $field) {
//             if (empty($clientData[$field])) {
//                 return "Error: Field '{$field}' is missing from client data.";
//             }
//         }

//         if (!file_exists($filepath) || !is_readable($filepath)) {
//             return "Error: The file at {$filepath} does not exist or is not readable.";
//         }

//         $email = $clientData['email'];
//         $firstName = $clientData['first_name'];
//         $lastName = $clientData['last_name'];

//         $sender = 'roxaswaterbillingsystem@gmail.com';

//         if (session_status() == PHP_SESSION_NONE) {
//             session_start();
//         }
//         $user_id = $_SESSION['user_id'];
//         $data = array(
//             "client_id" => $clientData['client_id'],
//             "billing_id" => $clientData['billing_id'],
//             "sent_to" => $email,
//             "sent_from" => $sender,
//             "user_id" => $user_id
//         );
//         $mail = new PHPMailer(true);
//         try {
//             $credentials = json_decode(file_get_contents('config/credentials.json'), true);

//             $provider = new Google([
//                 'clientId'     => $credentials['clientId'],
//                 'clientSecret' => $credentials['clientSecret'],
//                 'redirectUri'  => $credentials['redirectUri'],
//             ]);

//             $mail = new PHPMailer(true);

//             $mail->isSMTP();
//             $mail->Host = 'smtp.gmail.com';
//             $mail->SMTPAuth = true;
//             //to view proper logging details for success and error messages
//             // $mail->SMTPDebug = 1;
//             $mail->Host = 'smtp.gmail.com';  //gmail SMTP server
//             $mail->Username = 'roxaswaterbillingsystem@gmail.com';   //email
//             $mail->Password = 'sluzmpnriimiseul';   //16 character obtained from app password created
//             $mail->Port = 465;                    //SMTP port
//             $mail->SMTPSecure = "ssl";

//             $mail->setFrom($sender, 'Roxas Water Billing System Inc.');
//             $mail->addAddress($email, $firstName . ' ' . $lastName); // Add a recipient

//             $mail->addAttachment($filepath); // Add the PDF generated

//             // Content
//             $mail->isHTML(true); // Set email format to HTML
//             $mail->Subject = 'Your Billing Information';
//             $mail->Body    = 'Please find your billing information attached.';


//             $mail->send();
//             $this->insertIntoEmailLogs($data);
//             return 'Message has been sent';

//         } catch (Exception $e) {
//             error_log($e->getMessage());
//             return 'An error occurred while sending the email. Please try again later.';
//         }
//     }

//     public function selectEmail($clientID)
//     {
//         $sql = "SELECT email FROM client_data WHERE client_id = ? AND status = 'active'";
//         $stmt = $this->conn->prepareStatement($sql);
//         if (!$stmt) {
//             return null;
//         }
//         mysqli_stmt_bind_param($stmt, "s", $clientID);
//         if (!mysqli_stmt_execute($stmt)) {
//             return null;
//         }

//         $result = mysqli_stmt_get_result($stmt);
//         $row = mysqli_fetch_assoc($result);
//         mysqli_stmt_close($stmt);

//         return $row['email'];
//     }
//     public function sendIndividualBilling($clientID)
//     {
//         $response = array();
//         $clientData = $this->queryDataForInvoice($clientID);
//         $billingID = $clientData['billing_id'];
//         $generatedBilling = $this->generateIndividualBilling($clientData);
//         $this->mailBillingInvoice($clientData, $generatedBilling);

//         if (!empty($errors)) {
//             return $response = array(
//                 "status" => "error",
//                 "message" => "There were errors sending some emails.",
//                 "errors" => $errors
//             );
//         }

//         $this->checkSentEmail($billingID);

//         return $response;
//     }

// }
