<?php

use Cashier\Database\DatabaseConnection;

use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

use League\OAuth2\Client\Provider\Google;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'database/connection.php';
require __DIR__ . "/vendor/autoload.php";

class BaseQuery
{
    protected $conn;

    public function __construct(DatabaseConnection $databaseConnection)
    {
        $this->conn = $databaseConnection;
    }
}

class PdfGenerator extends BaseQuery
{
    public function selectClientData($clientID)
    {
        $sql = "SELECT * FROM client_data
        LEFT JOIN client_secondary_data ON client_data.client_id = client_secondary_data.client_id
        WHERE client_data.client_id = ?";
        $stmt = $this->conn->prepareStatement($sql);

        if (!$stmt) {
            return null;
        }

        mysqli_stmt_bind_param($stmt, "s", $clientID);

        if (!mysqli_stmt_execute($stmt)) {
            return null;
        }

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            mysqli_stmt_free_result($stmt);
            mysqli_stmt_close($stmt);
            return $row;
        } else {
            mysqli_stmt_free_result($stmt);
            mysqli_stmt_close($stmt);
            return null;
        }
    }

    public function generateBillingReceipt($receiptData)
    {
        $options = new Options();
        $options->setChroot(__DIR__);
        $options->setIsRemoteEnabled(true);
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);

        $options->set('margin-top', '0mm');
        $options->set('margin-right', '0mm');
        $options->set('margin-bottom', '0mm');
        $options->set('margin-left', '0mm');
        $dompdf = new Dompdf($options);

        $dompdf->setPaper(array(0, 0, 504, 504), 'portrait');

        $qrCode = new QrCode($receiptData['no']);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        $qrDataUri = $result->getDataUri();


        $no = $receiptData['no'];
        $date = date("Y-m-d");
        $accountNo = $receiptData['account_no'];
        $propertyType = $receiptData['property_type'];
        $consumption = $receiptData['consumption'];
        $penalty = $receiptData['penalty'];
        $tax = $receiptData['tax'];
        $amountDue = $receiptData['amount_due'];
        $cashier = $receiptData['cashier'];

        $formattedPenalty = number_format($penalty, 2, '.', ',');
        $formattedTax = number_format($tax, 2, '.', ',');
        $formattedAmountDue = number_format($amountDue, 2, '.', ',');

        $clientData = $this->selectClientData($accountNo);
        $firstName = $clientData['first_name'];
        $lastName = $clientData['last_name'];
        $meterNumber = $clientData['meter_number'];
        $street = $clientData['street'];
        $brgy = $clientData['brgy'];

        $template = file_get_contents('templates/invoice-billing.html');
        $invoiceHtml = str_replace(
            ['{{tx_qr}}', '{{transaction_id}}', '{{date}}', '{{account_no}}', '{{last_name}}', '{{first_name}}', '{{meter_number}}','{{property_type}}', '{{street}}', '{{brgy}}', '{{consumption}}', '{{penalty}}', '{{tax}}', '{{amount_due}}', '{{cashier}}'],
            [$qrDataUri, $no, $date, $accountNo, $lastName, $firstName, $meterNumber, $propertyType, $street, $brgy, $consumption,$formattedPenalty, $formattedTax, $formattedAmountDue, $cashier],
            $template
        );
        $dompdf->loadHtml($invoiceHtml);
        $dompdf->render();
        $dompdf->addInfo("Title", "Receipt: $no");

        $outputDirectory = 'temp/receipts/';

        if (!is_dir($outputDirectory)) {
            mkdir($outputDirectory, 0755, true);
        }

        $filename = $no . '.pdf';
        $filepath = $outputDirectory . $filename;
        $emailPath = __DIR__ . '/' . $filepath;
        if (file_put_contents($filepath, $dompdf->output())) {
            return [
                'status' => 'success',
                'filename' => $filename,
                'email_path' => $emailPath,
                'filepath' => $filepath,
            ];
        } else {
            $errorMessage = error_get_last()['message'];
            return [
                'status' => 'error',
                'message' => "Failed to save PDF file. Error: $errorMessage",
            ];
        }


        // $fileName = __DIR__ . '/temp/' . $no . '.pdf';
        // if (file_put_contents($fileName, $dompdf->output())) {
        //     return $fileName;
        // } else {
        //     return null;
        // }

    }
}
class WBSMailer extends PdfGenerator
{
    public function handleEmailSend($mailData, $filepath)
    {
        $requiredFields = ['email', 'first_name', 'last_name'];

        foreach ($requiredFields as $field) {
            if (empty($mailData[$field])) {
                return "Error: Field '{$field}' is missing from client data.";
            }
        }

        if (!file_exists($filepath) || !is_readable($filepath)) {
            return "Error: The file at {$filepath} does not exist or is not readable.";
        }

        $email = $mailData['email'];
        $firstName = $mailData['first_name'];
        $lastName = $mailData['last_name'];

        $sender = 'roxaswaterbillingsystem@gmail.com';

        $mail = new PHPMailer(true);
        try {
            $credentials = json_decode(file_get_contents('config/credentials.json'), true);

            $provider = new Google([
                'clientId'     => $credentials['clientId'],
                'clientSecret' => $credentials['clientSecret'],
                'redirectUri'  => $credentials['redirectUri'],
            ]);

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            //to view proper logging details for success and error messages
            // $mail->SMTPDebug = 1;
            $mail->Host = 'smtp.gmail.com';  //gmail SMTP server
            $mail->Username = $sender;   //email
            $mail->Password = 'sluzmpnriimiseul';   //16 character obtained from app password created
            $mail->Port = 465;                    //SMTP port
            $mail->SMTPSecure = "ssl";

            $mail->setFrom($sender, 'Roxas Water Billing System Inc.');
            $mail->addAddress($email, $firstName . ' ' . $lastName); // Add a recipient

            $mail->addAttachment($filepath); // Add the PDF generated

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Billing Receipt';
            $mail->Body    = 'Please find your receipt attached.';

            $mail->send();
            $mail->smtpClose();
            return 'Message has been sent';

        } catch (Exception $e) {
            error_log($e->getMessage());
            return 'An error occurred while sending the email. Please try again later.';
        }
    }
}
class DatabaseQueries extends BaseQuery
{
    public function retrieveUserData($userID)
    {
        $response = array();
        $sql = "SELECT * FROM users WHERE user_id = ?";

        $stmt = $this->conn->prepareStatement($sql);
        mysqli_stmt_bind_param($stmt, "s", $userID);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $user_data_array = array();

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($user_data_array, $row);
                }
                $response['user_data'] = $user_data_array;
            } else {
                $response['error'] = "No client found with the provided ID.";
            }
        } else {
            $response['error'] = "There was an error executing the statement.";
        }

        mysqli_stmt_close($stmt);

        return $response;
    }
    public function retrieveBillingRates()
    {
        $response = array();
        $sql = "SELECT * FROM rates ORDER BY timestamp DESC LIMIT 1";

        $result = $this->conn->query($sql);
        if ($result) {
            if ($row = mysqli_fetch_assoc($result)) {
                $response = [
                    'status' => 'success',
                    'rates' => $row
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'rates' => null
                ];
            }
        } else {
            $response = [
                'status' => 'error',
                'rates' => $this->conn->getErrorMessage()
            ];
        }

        return $response;
    }

    public function retrieveBillingData($clientID)
    {
        $response = array();

        $sql = "SELECT billing_data.*, client_data.* FROM billing_data "
            . "LEFT JOIN client_data ON billing_data.client_id = client_data.client_id "
            . "WHERE billing_data.reading_type = 'current' AND client_data.client_id = ?";

        if ($stmt = $this->conn->prepareStatement($sql)) {
            mysqli_stmt_bind_param($stmt, "s", $clientID);

            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if ($row = mysqli_fetch_assoc($result)) {
                    $response = [
                        'status' => 'success',
                        'billingData' => $row
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'No data found.'
                    ];
                }
                mysqli_free_result($result);
            } else {
                $response = [
                    'status' => 'error',
                    'message' => "Execute failed: " . $this->conn->getErrorMessage()
                ];
            }
            mysqli_stmt_close($stmt);
        } else {
            $response = [
                'status' => 'error',
                'message' => "Prepare failed: " . $this->conn->getErrorMessage()
            ];
        }

        return $response;
    }

    public function calculateTotalBill($billingAmount, $penalty, $taxRate)
    {
        $taxAmount = $billingAmount * ($taxRate / 100);
        $totalWithTax = $billingAmount + $penalty + $taxAmount;
        $roundedTaxAmount = round($taxAmount, 2);
        $roundedTotalWithTax = round($totalWithTax, 2);

        return array($roundedTaxAmount, $roundedTotalWithTax);
    }

    public function generateTransactionID()
    {
        $timestamp = time();
        $randomNumber = mt_rand(1000, 9999);
        $transactionID = $timestamp . $randomNumber;
        return $transactionID;
    }

    public function getClientName($clientID)
    {
        $sql = "SELECT full_name FROM client_data WHERE client_id = ?";
        $stmt = $this->conn->prepareStatement($sql);
        mysqli_stmt_bind_param($stmt, "s", $clientID);

        if (!$stmt) {
            return null;
        }

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                if ($row) {
                    $clientName = $row['full_name'];
                    return $clientName;
                }
            }
        }
        return null;
    }

    public function updateBillingData($billingID)
    {
        $update = "UPDATE billing_data SET billing_status = 'paid', billing_type = 'paid' WHERE billing_id = ?";
        $stmt = $this->conn->prepareStatement($update);
        mysqli_stmt_bind_param($stmt, "s", $billingID);

        if (!$stmt) {
            if (!$stmt) {
                return false;
            }
        }
        if (mysqli_stmt_execute($stmt)) {
            return true;
        }
        return false;
    }

    public function checkDuplicate($column, $value, $table)
    {
        $checkDuplicateQuery = "SELECT $column FROM $table WHERE $column = ?";

        $stmt = $this->conn->prepareStatement($checkDuplicateQuery);
        if (!$stmt) {
            return false;
        }

        mysqli_stmt_bind_param($stmt, "s", $value);

        if (!mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return false;
        }

        mysqli_stmt_store_result($stmt);

        $isDuplicate = mysqli_stmt_num_rows($stmt) > 0;

        mysqli_stmt_close($stmt);

        return $isDuplicate;
    }

    public function insertIntoTransactions($data)
    {
        $transactionID = $data['transactionID'];
        $transactionType = $data['transactionType'];
        $referenceID = $data['referenceID'];
        $clientID = $data['clientID'];
        $description = $data['description'];
        $amountDue = $data['amountDue'];
        $amountPaid = $data['amountPaid'];
        $remainingBalance = $data['remainingBalance'];
        $userID = $data['confirmedBy'];

        $sql = "INSERT INTO transactions (transaction_id, reference_id, client_id, transaction_type, transaction_desc, amount_due, amount_paid, remaining_balance, confirmed_by, time, date, timestamp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";

        $stmt = $this->conn->prepareStatement($sql);
        if (!$stmt) {
            return false;
        } else {
            mysqli_stmt_bind_param(
                $stmt,
                "sssssddds",
                $transactionID,
                $referenceID,
                $clientID,
                $transactionType,
                $description,
                $amountDue,
                $amountPaid,
                $remainingBalance,
                $userID
            );
            if (mysqli_stmt_execute($stmt)) {
                return true;
            }
        }
    }

    public function confirmBillingPayment($formData)
    {
        $this->conn->beginTransaction();

        $clientID = htmlspecialchars($formData['clientID'], ENT_QUOTES, 'UTF-8');
        $amountPaid = htmlspecialchars($formData['amountPaid'], ENT_QUOTES, 'UTF-8');

        $transactionID = $this->generateTransactionID();

        $transactionType = 'bill_payment';

        $rates = $this->retrieveBillingRates();
        $billingData = $this->retrieveBillingData($clientID);

        $billingID = $billingData['billingData']['billing_id'];
        $billingAmount = $billingData['billingData']['billing_amount'];
        $billingMonth = $billingData['billingData']['billing_month'];
        $propertyType = $billingData['billingData']['rate_type'];
        $consumption = $billingData['billingData']['consumption'];
        $taxRate = $rates['rates']['tax'];
        $penalty = $billingData['billingData']['penalty'];

        $calculatedTotalBill = $this->calculateTotalBill($billingAmount, $penalty, $taxRate);
        $taxAmount =  $calculatedTotalBill[0];
        $totalWithTax = $calculatedTotalBill[1];

        $clientName = $this->getClientName($clientID);

        $amountDue = $totalWithTax;
        $remainingBalance = intval($amountPaid) - intval($amountDue);

        $referenceID = $billingID;
        session_start();
        $userID = $_SESSION['user_id'];
        $userName = $_SESSION['user_name'];
        $description = "Payment received from $clientName - Billing Month of $billingMonth - Confirmed by $userName";


        $transactionData = array(
            "transactionID" => $transactionID,
            "transactionType" =>  $transactionType,
            "referenceID" => $referenceID,
            "clientID" => $clientID,
            "description" => $description,
            "amountDue" => $amountDue,
            "amountPaid" => $amountPaid,
            "remainingBalance" => $remainingBalance,
            "confirmedBy" => $userID
        );

        $receiptData = array(
            "no" => $transactionID,
            "account_no" => $clientID,
            "name" => $clientName,
            "property_type" => $propertyType,
            "consumption" => $consumption,
            "rates" => $rates,
            "penalty" => $penalty,
            "tax" => $taxAmount,
            "amount_due" => $totalWithTax,
            "cashier" => $userName
        );


        try {
            if ($this->checkDuplicate('reference_id', $referenceID, 'transactions')) {
                throw new Exception("Failed to do insert new transaction. $clientName already paid, please check transaction history.");
            }
            if (!$this->insertIntoTransactions($transactionData)) {
                throw new Exception("Failed to update client application.");
            }
            if (!$this->updateBillingData($billingID)) {
                throw new Exception("Failed to update billing data.");
            }

            $pdfGenerator = new PdfGenerator($this->conn);
            $wbsMailer = new WBSMailer($this->conn);

            $generatedBillingReceipt = $pdfGenerator->generateBillingReceipt($receiptData);

            if ($generatedBillingReceipt['status'] === 'success') {
                $filename = $generatedBillingReceipt['filename'];
                $filepath = $generatedBillingReceipt['filepath'];
                $emailPath = $generatedBillingReceipt['email_path'];

                $clientData = $pdfGenerator->selectClientData($clientID);
                $emailSent = $wbsMailer->handleEmailSend($clientData, $emailPath);

                if (!$emailSent) {
                    throw new Exception("Failed to send receipt to email.");
                }
                $this->conn->commitTransaction();

                $response = array(
                    "status" => "success",
                    "client_id" => $clientID,
                    "filename" => $filename,
                    "filepath" => $filepath,
                    "message" => "Billing has been confirmed. Receipt has been sent to email.",
                );
                return $response;
            }

        } catch (Exception $e) {
            $this->conn->rollbackTransaction();
            $response = array(
                "status" => "error",
                "message" => $e->getMessage()
            );
        }

        return $response;
    }


    public function retrieveClientApplicationFees()
    {
        $sql = "SELECT * FROM client_application_fees ORDER BY timestamp DESC LIMIT 1";
        $result = $this->conn->query($sql);

        if (!$result) {
            return "Failed: " . $this->conn->getErrorMessage();
        }
        if ($row = mysqli_fetch_assoc($result)) {
            $response = array(
                'client_application_fees' => $row
            );
            return $response;
        }
    }
    public function retrieveClientApplication($applicationID)
    {

        $queryClientApp = "SELECT * FROM client_application WHERE application_id = ?";
        $stmt = $this->conn->prepareStatement($queryClientApp);
        mysqli_stmt_bind_param($stmt, "s", $applicationID);
        if (!$stmt) {
            $response = array(
                "status" => "error",
                "client_application" => "Failed to client application fees" . $this->conn->getErrorMessage()
            );
            return $response;
        }
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if ($clientAppRow = mysqli_fetch_assoc($result)) {
                $response["client_application"] = $clientAppRow;
                return $response;
            }
        }
    }

    public function updateClientApplication($applicationID, $applicationFeeID)
    {
        $sql = "UPDATE client_application SET billing_status = 'paid', application_fee_id = ?  WHERE application_id = ?";
        $stmt = $this->conn->prepareStatement($sql);

        mysqli_stmt_bind_param($stmt, "ss", $applicationFeeID, $applicationID);
        if (!mysqli_stmt_execute($stmt)) {
            return false;
        }
        return true;
    }
    public function markNotificationAsRead($applicationID)
    {
        $sqlUpdate = "UPDATE notifications SET status = 'read' WHERE reference_id = ?";
        $stmtUpdate = $this->conn->prepareStatement($sqlUpdate);
        if (!$stmtUpdate) {

            return false;
        }
        mysqli_stmt_bind_param($stmtUpdate, "s", $applicationID);

        if (mysqli_stmt_execute($stmtUpdate)) {
            return true;
        } else {

            return false;
        }
    }

    public function confirmAppPayment($formData)
    {
        $this->conn->beginTransaction();

        $applicationID = htmlspecialchars($formData['applicationID'], ENT_QUOTES, 'UTF-8');
        $amountPaid = htmlspecialchars($formData['amountPaid'], ENT_QUOTES, 'UTF-8');

        $transactionID = $this->generateTransactionID();

        $transactionType = 'application_payment';
        $referenceID = $applicationID;

        $clientApplicationFees = $this->retrieveClientApplicationFees();

        $applicationFeeID = $clientApplicationFees['client_application_fees']['application_fee_id'];
        $applicationFee = $clientApplicationFees['client_application_fees']['application_fee'];
        $inspectionFee = $clientApplicationFees['client_application_fees']['inspection_fee'];
        $registrationFee = $clientApplicationFees['client_application_fees']['registration_fee'];
        $connectionFee = $clientApplicationFees['client_application_fees']['connection_fee'];
        $installationFee = $clientApplicationFees['client_application_fees']['installation_fee'];

        $amountDue = intval($applicationFee) + intval($inspectionFee) + intval($registrationFee) + intval($connectionFee) + intval($installationFee);
        $remainingBalance = intval($amountPaid) - intval($amountDue);

        $roundedRemainingBalance = round($remainingBalance, 2);

        $clientApplication = $this->retrieveClientApplication($applicationID);
        $clientName = $clientApplication['client_application']['full_name'];
        $propertyType = $clientApplication['client_application']['property_type'];
        session_start();
        $userID = $_SESSION['user_id'];
        $userName = $_SESSION['user_name'];
        $description = "Payment received from $clientName - Property Type $propertyType - Confirmed by $userName";

        $data = array(
            "transactionID" => $transactionID,
            "transactionType" =>  $transactionType,
            "referenceID" => $referenceID,
            "clientID" => '',
            "description" => $description,
            "amountDue" => $amountDue,
            "amountPaid" => $amountPaid,
            "remainingBalance" => $roundedRemainingBalance,
            "confirmedBy" => $userID
        );

        try {
            if ($this->checkDuplicate('reference_id', $referenceID, 'transactions')) {
                throw new Exception("Failed to do insert new transaction. Duplicate reference ID.");
            }

            if (!$this->insertIntoTransactions($data)) {
                throw new Exception("Failed to update client application.");
            }

            if (!$this->updateClientApplication($applicationID, $applicationFeeID)) {
                throw new Exception("Failed to update client application.");
            }
            if (!$this->markNotificationAsRead($applicationID)) {
                throw new Exception("Failed to mark notification as read.");
            }

            $message = "$clientName's payment for Application: $applicationID has been confirmed.";
            $type = "payment_confirmation";

            if ($this->notificationExists($userID, $type, $applicationID)) {
                throw new Exception("Notification already exists for application ID: " . $applicationID);
            }

            if (!$this->addNotification($userID, $message, $type, $applicationID)) {
                throw new Exception("Failed t o add notification.");
            }

            $this->conn->commitTransaction();

            $response = array(
                "status" => "success",
                "message" => "Payment has been confirmed."
            );
        } catch (Exception $e) {
            $this->conn->rollbackTransaction();
            $response = array(
                "status" => "error",
                "message" => $e->getMessage()
            );
        }

        return $response;
    }

    public function checkClientIDExistence($clientID)
    {
        $sql = "SELECT client_id FROM client_data WHERE client_id = ?";
        $stmt = $this->conn->prepareStatement($sql);

        if (!$stmt) {
            $response = array(
                "status" => "error",
                "message" => "Error preparing statement",
                "is_exist" => false
            );
            return $response;
        }

        mysqli_stmt_bind_param($stmt, "s", $clientID);

        if (!mysqli_stmt_execute($stmt)) {
            $response = array(
                "status" => "error",
                "message" => "Error executing statement",
                "is_exist" => false
            );
            mysqli_stmt_close($stmt);
            return $response;
        }

        $result = mysqli_stmt_get_result($stmt);

        if ($result->num_rows > 0) {
            $response = array(
                "status" => "success",
                "message" => "Client ID exists",
                "is_exist" => true
            );
        } else {
            $response = array(
                "status" => "success",
                "message" => "Client ID does not exist",
                "is_exist" => false
            );
        }

        mysqli_stmt_close($stmt);

        return $response;
    }
    public function notificationExists($user_id, $type, $reference_id)
    {
        $sql = "SELECT id FROM notifications WHERE user_id = ? AND type = ? AND reference_id = ? LIMIT 1";
        $stmt = $this->conn->prepareStatement($sql);

        if (!$stmt) {
            return false;
        }

        mysqli_stmt_bind_param($stmt, "sss", $user_id, $type, $reference_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        $num_rows = mysqli_stmt_num_rows($stmt);
        mysqli_stmt_close($stmt);
        return $num_rows > 0;
    }

    public function addNotification($user_id, $message, $type, $reference_id = null)
    {
        $sql = "INSERT INTO notifications (user_id, message, type, reference_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepareStatement($sql);

        mysqli_stmt_bind_param($stmt, "ssss", $user_id, $message, $type, $reference_id);

        if (mysqli_stmt_execute($stmt)) {
            return true;
        } else {
            return false;
        }
    }

    public function loadNotificationHtml($limit)
    {
        $limit = isset($_POST['limit']) ? $_POST['limit'] : 10;

        $countSql = "SELECT COUNT(*) as notificationCount FROM notifications WHERE status = 'unread' AND type = 'application_confirmation'";

        if ($limit !== 'all') {
            $countSql .= " ORDER BY created_at DESC LIMIT $limit";
        }

        $countResult = $this->conn->query($countSql);
        $row = $countResult->fetch_assoc();
        $notifCount = $row['notificationCount'];

        $sql = "SELECT * FROM notifications WHERE status = 'unread' AND type = 'application_confirmation' ORDER BY created_at DESC";

        if ($limit !== 'all') {
            $sql .= " LIMIT $limit";
        }

        $result = $this->conn->query($sql);

        $output = "";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $icon = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0iY3VycmVudENvbG9yIiBjbGFzcz0idy02IGgtNiIgc3R5bGU9IndpZHRoOiAxLjhyZW07IGhlaWdodDogMS44cmVtOyBjb2xvcjogIzE2YTM0YSI+DQogIDxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgZD0iTTguNjAzIDMuNzk5QTQuNDkgNC40OSAwIDAxMTIgMi4yNWMxLjM1NyAwIDIuNTczLjYgMy4zOTcgMS41NDlhNC40OSA0LjQ5IDAgMDEzLjQ5OCAxLjMwNyA0LjQ5MSA0LjQ5MSAwIDAxMS4zMDcgMy40OTdBNC40OSA0LjQ5IDAgMDEyMS43NSAxMmE0LjQ5IDQuNDkgMCAwMS0xLjU0OSAzLjM5NyA0LjQ5MSA0LjQ5MSAwIDAxLTEuMzA3IDMuNDk3IDQuNDkxIDQuNDkxIDAgMDEtMy40OTcgMS4zMDdBNC40OSA0LjQ5IDAgMDExMiAyMS43NWE0LjQ5IDQuNDkgMCAwMS0zLjM5Ny0xLjU0OSA0LjQ5IDQuNDkgMCAwMS0zLjQ5OC0xLjMwNiA0LjQ5MSA0LjQ5MSAwIDAxLTEuMzA3LTMuNDk4QTQuNDkgNC40OSAwIDAxMi4yNSAxMmMwLTEuMzU3LjYtMi41NzMgMS41NDktMy4zOTdhNC40OSA0LjQ5IDAgMDExLjMwNy0zLjQ5NyA0LjQ5IDQuNDkgMCAwMTMuNDk3LTEuMzA3em03LjAwNyA2LjM4N2EuNzUuNzUgMCAxMC0xLjIyLS44NzJsLTMuMjM2IDQuNTNMOS41MyAxMi4yMmEuNzUuNzUgMCAwMC0xLjA2IDEuMDZsMi4yNSAyLjI1YS43NS43NSAwIDAwMS4xNC0uMDk0bDMuNzUtNS4yNXoiIGNsaXAtcnVsZT0iZXZlbm9kZCIgLz4NCjwvc3ZnPg0K";
                $notificationContent = $row['message'];
                $applicationID = $row['reference_id'];
                $url = BASE_URL . '/cashier/application_payments.php';


                $currentDateTime = new DateTime();
                $notificationDateTime = new DateTime($row['created_at'], new DateTimeZone('Asia/Manila'));
                $interval = $notificationDateTime->diff($currentDateTime);

                if ($interval->y > 0) {
                    $timeAgo = $interval->y . " year" . ($interval->y > 1 ? "s" : "") . " ago";
                } elseif ($interval->m > 0) {
                    $timeAgo = $interval->m . " month" . ($interval->m > 1 ? "s" : "") . " ago";
                } elseif ($interval->d > 0) {
                    $timeAgo = $interval->d . " day" . ($interval->d > 1 ? "s" : "") . " ago";
                } elseif ($interval->h > 0) {
                    $timeAgo = $interval->h . " hour" . ($interval->h > 1 ? "s" : "") . " ago";
                } elseif ($interval->i > 0) {
                    $timeAgo = $interval->i . " minute" . ($interval->i > 1 ? "s" : "") . " ago";
                } else {
                    $timeAgo = "a few moments ago";
                }

                $output .= "
                    <button onclick=\"window.location.href='$url'\" class=\"flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700\">
                        <div class=\"flex-shrink-0\">
                            <img class=\"rounded-full w-11 h-11\" src='$icon' alt=\"Confirm Icon\">
                        </div>
                        <div class=\"w-full pl-3\">
                            <div class=\"text-left text-gray-500 text-sm mb-1.5 dark:text-gray-400\">$notificationContent</div>
                            <div class=\"text-left text-xs text-blue-600 dark:text-blue-500\">$timeAgo</div>
                        </div>
                    </button>
                    ";
            }
        } else {
            $output .= "<div class=\"font-medium italic text-gray-600 flex justify-center items-center px-4 py-5 hover:bg-gray-100\">Empty</div>";
        }

        $output = '<input id="notif_count_hidden" type="hidden" value="' . $notifCount . '">' . $output;
        echo $output;
    }

    public function countUnreadNotifications()
    {
        $sql = "SELECT COUNT(*) as unread_count FROM notifications WHERE status = 'unread' AND type = 'application_confirmation'";
        $response = array();

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $unread_count = $row['unread_count'];

            if ($unread_count > 0) {
                $response['status'] = 'success';
                $response['unread_count'] = $unread_count;
            } else {
                $response['status'] = 'empty';
                $response['unread_count'] = 0;
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Unable to fetch data';
        }

        return json_encode($response);
    }

    public function updateUserData($formData) {
        $userID = htmlspecialchars($formData['userID'], ENT_QUOTES, 'UTF-8');
        $fullName = htmlspecialchars($formData['fullName'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($formData['email'], ENT_QUOTES, 'UTF-8');
        $rawPassword = htmlspecialchars($formData['password'], ENT_QUOTES, 'UTF-8');
    
        $hashedPassword = password_hash($rawPassword, PASSWORD_BCRYPT);
    
        $sql = "UPDATE users SET 
                user_name = ?,
                email = ?,
                password = ?
                WHERE user_id = ?";
    
        $stmt = $this->conn->prepareStatement($sql);
    
        if (!$stmt) {
            return false;
        }
    
        $stmt->bind_param(
            'ssss',
            $fullName,
            $email,
            $hashedPassword, 
            $userID
        );
    
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    
    
    public function updateUserProfile($formData)     {
        $this->conn->beginTransaction();
        try {
            if (!$this->updateUserData($formData)) {
                throw new Exception("Failed to update user data.");
            }
            $this->conn->commitTransaction();
            $response = [
                "status" => "success",
                "message" => "User profile updated successfully."
            ];
            return $response;
        } catch(Exception $e) {
            $this->conn->rollbackTransaction();
            $response = [
                "status" => "error",
                "message" => "User profile update failed."
            ];
            return $response;
        }
    }
}


class DataTable extends BaseQuery
{
    public function billingTable($dataTableParam)
    {

        $pageNumber = $dataTableParam['pageNumber'];
        $itemPerPage = $dataTableParam['itemPerPage'];
        $searchTerm = isset($dataTableParam['searchTerm']) ? $dataTableParam['searchTerm'] : "";
        $offset = ($pageNumber - 1) * $itemPerPage;
        $sortColumn = isset($dataTableParam['sortColumn']) ? $dataTableParam['sortColumn'] : "timestamp";
        $sortDirection = isset($dataTableParam['sortDirection']) ? $dataTableParam['sortDirection'] : "DESC";
        $filters = isset($dataTableParam['filters']) ? $dataTableParam['filters'] : [];

        $conditions = [];
        $params = [];
        $types = "";

        if ($searchTerm) {
            $likeTerm = "%" . $searchTerm . "%";
            $conditions[] = "(bd.billing_id LIKE ? OR bd.client_id LIKE ? OR cd.full_name LIKE ? OR bd.meter_number LIKE ? OR cd.property_type LIKE ? OR cd.status LIKE ?)";
            $params = array_merge($params, [$likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm]);
            $types .= "ssssss";
        }

        if (!empty($filters)) {
            foreach ($filters as $filter) {
                $conditions[] = "{$filter['column']} = ?";
                $params[] = $filter['value'];
                $types .= "s";
            }
        }

        if (!empty($conditions)) {
            $sql = "SELECT SQL_CALC_FOUND_ROWS bd.*, cd.* FROM billing_data AS bd";
            $sql .= " INNER JOIN client_data AS cd ON bd.client_id = cd.client_id";
            $sql .= " WHERE bd.billing_type = 'billed' AND bd.billing_status = 'unpaid' AND " . implode(" AND ", $conditions);
        } else {
            $sql = "SELECT SQL_CALC_FOUND_ROWS bd.*, cd.* FROM billing_data AS bd";
            $sql .= " INNER JOIN client_data AS cd ON bd.client_id = cd.client_id";
            $sql .= " WHERE bd.billing_type = 'billed' AND bd.billing_status = 'unpaid'";
        }

        // echo $sql;
        // print_r($params);

        $validColumns = [
            'bd.client_id', 'bd.billing_id', 'cd.full_name',  'cd.property_type', 'bd.timestamp', 'cd.brgy'
        ];
        $validDirections = ['ASC', 'DESC'];

        if (in_array($sortColumn, $validColumns) && in_array($sortDirection, $validDirections)) {
            $sql .= " ORDER BY {$sortColumn} {$sortDirection}";
        } else {
            $sql .= " ORDER BY bd.timestamp DESC";
        }

        $sql .= " LIMIT ? OFFSET ?";
        $params = array_merge($params, [$itemPerPage, $offset]);
        $types .= "ii";

        $stmt = $this->conn->prepareStatement($sql);
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        mysqli_stmt_execute($stmt);


        $result = mysqli_stmt_get_result($stmt);

        $resultCount = $this->conn->query("SELECT FOUND_ROWS() as total");

        if ($resultCount && $row = mysqli_fetch_assoc($resultCount)) {
            $totalRecords = $row['total'];
        } else {
            $totalRecords = 0;
        }

        $descendingIcon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
    </svg>';
        $ascendingIcon = ' <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
    </svg>';

        $sortIcon = $sortDirection === 'DESC' ? $ascendingIcon : $descendingIcon;

        $table = '<table class="w-full text-sm text-left text-gray-500 rounded-b-lg">
        <thead class="text-xs text-gray-500 uppercase">
            <tr class="bg-slate-100 border-b">
                <th class="px-6 py-4">No.</th>
                <th class="px-6 py-4" data-column-name="bd.billing_id" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Billing ID</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                        <span id="totalItemsSpan" class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer">' . $totalRecords . '</span>
                    </div>
                </th>
                <input id="totalItemsHidden" type="hidden" value="' . $totalRecords . '">
                <th class="px-6 py-4" data-column-name="bd.client_id" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Client ID</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="cd.full_name" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Client Name</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="cd.property_type" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Property Type</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="bd.billing_amount" data-sortable="true">
                <div class="flex items-center gap-2">
                    <p>Amount</p>
                    <span class="sort-icon">
                    ' . $sortIcon . '
                    </span>
                </div>
                </th>
                <th class="px-6 py-4" data-column-name="bd.timestamp" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Reading Date</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4">Action</th>
            </tr>
        </thead>';

        $countArr = array();
        $number = ($pageNumber - 1) * $itemPerPage + 1;

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $billingID = $row['billing_id'];
            $clientID = $row['client_id'];
            $clientName = $row['full_name'];
            $propertyType = $row['property_type'];
            $billingAmount = $row['billing_amount'];
            $formattedBillingAmount = "₱" . number_format($billingAmount, 2, '.', ',');
            $time = $row['time'];
            $date = $row['date'];
            $readable_date = date("F j, Y", strtotime($date));
            $readable_time = date("h:i A", strtotime($time));

            $table .= '<tr class="table-auto bg-white border-b border-gray-200 group hover:bg-gray-100" data-id="' . $id . '">
            <td  class="px-6 py-3 text-sm">' . $number . '</td>
            <td  class="px-6 py-3 text-sm">' . $billingID . '</td>
            <td  class="px-6 py-3 text-sm">' . $clientID . '</td>
            <td  class="px-6 py-3 text-sm">' . $clientName . '</td>
            <td class="px-6 py-3 text-sm">' . $propertyType . '</td>
            <td class="px-6 py-3 text-sm font-semibold  group-hover:bg-gray-50 group-hover:text-indigo-500 group-hover:font-semibold ease-in-out duration-150">' . $formattedBillingAmount . '</td>
            <td class="px-6 py-3 text-sm">            
                <span class="font-medium text-sm">' . $readable_date . '</span> </br>
                <span class="text-xs">' . $readable_time . '</span>
            </td>
            <td class="flex items-center px-6 py-4 space-x-3">

                <button title="Accept Payment" onclick="acceptClientBillingPayment(\'' . $clientID . '\')" type="button" title="View Client" class="text-white bg-primary-700 hover:bg-primary-600 focus:ring-2 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center ">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 icon icon-tabler icon-tabler-cash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" >
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M7 9m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z"></path>
                <path d="M14 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                <path d="M17 9v-2a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v6a2 2 0 0 0 2 2h2"></path>
             </svg>
        
                <span class="ml-2 text-sm">Payment</span>
            </button>
            </td>
        </tr>';
            array_push($countArr, $number);
            $number++;
        }

        $start = 0;
        $end = 0;

        if (!empty($countArr)) {
            $start = $countArr[0];
            $end = end($countArr);

            $table .= '</tbody></table>';

            if ($number > 1) {
                echo $table;
            } else {
                echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">No billing found.</div>';
            }
        } else {
            echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">No billing found.</div>';
        }

        echo '<input data-hidden-name="start" type="hidden" value="' . $start . '">';
        echo '<input data-hidden-name="end" type="hidden" value="' . $end . '">';
    }
    public function clientAppBillingTable($dataTableParam)
    {
        $pageNumber = $dataTableParam['pageNumber'];
        $itemPerPage = $dataTableParam['itemPerPage'];
        $searchTerm = isset($dataTableParam['searchTerm']) ? $dataTableParam['searchTerm'] : "";
        $offset = ($pageNumber - 1) * $itemPerPage;
        $sortColumn = isset($dataTableParam['sortColumn']) ? $dataTableParam['sortColumn'] : "timestamp";
        $sortDirection = isset($dataTableParam['sortDirection']) ? $dataTableParam['sortDirection'] : "DESC";
        $filters = isset($dataTableParam['filters']) ? $dataTableParam['filters'] : [];

        $conditions = [];
        $params = [];
        $types = "";


        if ($searchTerm) {
            $likeTerm = "%" . $searchTerm . "%";
            $conditions[] = "(full_name LIKE ? OR meter_number LIKE ? OR property_type LIKE ? OR application_id LIKE ?)";
            $params = array_merge($params, [$likeTerm, $likeTerm, $likeTerm, $likeTerm]);
            $types .= "ssss";
        }

        if (!empty($filters)) {
            foreach ($filters as $filter) {
                $conditions[] = "{$filter['column']} = ?";
                $params[] = $filter['value'];
                $types .= "s";
            }
        }

        if (!empty($conditions)) {
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM client_application WHERE status = 'confirmed' AND billing_status = 'unpaid' AND " . implode(" AND ", $conditions);
        } else {
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM client_application WHERE status = 'confirmed' AND billing_status = 'unpaid'";
        }


        $validColumns = [
            'full_name', 'meter_number', 'property_type', 'brgy',  'application_id', 'timestamp', 'brgy'
        ];
        $validDirections = ['ASC', 'DESC'];

        if (in_array($sortColumn, $validColumns) && in_array($sortDirection, $validDirections)) {
            $sql .= " ORDER BY {$sortColumn} {$sortDirection}";
        } else {
            $sql .= " ORDER BY timestamp DESC";
        }

        $sql .= " LIMIT ? OFFSET ?";
        $params = array_merge($params, [$itemPerPage, $offset]);
        $types .= "ii";

        // echo $sql;
        // print_r($params);
        $stmt = $this->conn->prepareStatement($sql);
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        // More efficient way to get total records
        $resultCount = $this->conn->query("SELECT FOUND_ROWS() as total");

        if ($resultCount && $row = mysqli_fetch_assoc($resultCount)) {
            $totalRecords = $row['total'];
        } else {
            $totalRecords = 0;
        }

        $descendingIcon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
    </svg>';
        $ascendingIcon = ' <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
    </svg>';

        $sortIcon = $sortDirection === 'DESC' ? $ascendingIcon : $descendingIcon;

        $table = '<table class="w-full text-sm text-left text-gray-500 rounded-b-lg">
        <thead class="text-xs text-gray-500 uppercase">
            <tr class="bg-slate-100 border-b">
                <th class="px-6 py-4">No.</th>
                <th class="px-6 py-4" data-column-name="application_id" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Application ID</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                        <span id="totalItemsSpan" class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer">' . $totalRecords . '</span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="full_name" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Name</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <input id="totalItemsHidden" type="hidden" value="' . $totalRecords . '">
                <th class="px-6 py-4" data-column-name="property_type" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Property Type</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="brgy" data-sortable="true">
                <div class="flex items-center gap-2">
                    <p>Address</p>
                    <span class="sort-icon">
                    ' . $sortIcon . '
                    </span>
                </div>
                </th>
                <th class="px-6 py-4" data-column-name="timestamp" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Applied Date</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4">Action</th>
            </tr>
        </thead>';

        $countArr = array();
        $number = ($pageNumber - 1) * $itemPerPage + 1;

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $applicationID = $row['application_id'];
            $name = $row['full_name'];
            $propertyType = $row['property_type'];
            $street = $row['street'];
            $brgy = $row['brgy'];
            $time = $row['time'];
            $date = $row['date'];

            $readable_date = date("F j, Y", strtotime($date));
            $readable_time = date("h:i A", strtotime($time));

            $table .= '<tr class="table-auto bg-white border-b border-gray-200 group hover:bg-gray-100" data-id="' . $id . '">
            <td  class="px-6 py-3 text-sm">' . $number . '</td>
            <td  class="px-6 py-3 text-sm">' . $applicationID . '</td>
            <td  class="px-6 py-3 text-sm font-semibold  group-hover:bg-gray-50 group-hover:text-indigo-500 group-hover:font-semibold ease-in-out duration-150">' . $name . '</td>
            <td  class="px-6 py-3 text-sm">' . $propertyType . '</td>
            <td class="px-6 py-3 text-sm"> 
            <span class="font-medium text-sm">' . $brgy . '</span> </br>
            <span class="text-xs text-gray-400">' . $street . '</span>
        </td>
            <td class="px-6 py-3 text-sm">            
                <span class="font-medium text-sm">' . $readable_date . '</span> </br>
                <span class="text-xs">' . $readable_time . '</span>
            </td>

            <td class="flex items-center px-6 py-4 space-x-3">
            <button title="Accept Payment" onclick="acceptClientAppPayment(\'' . $applicationID . '\')" type="button" title="View Client" class="text-white bg-primary-700 hover:bg-primary-600 focus:ring-2 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm p-2 text-center inline-flex items-center ">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 icon icon-tabler icon-tabler-cash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" >
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M7 9m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z"></path>
                <path d="M14 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                <path d="M17 9v-2a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v6a2 2 0 0 0 2 2h2"></path>
                </svg>
                <span class="ml-2 text-sm">Payment</span>
            </button>
            </td>
        </tr>';
            array_push($countArr, $number);
            $number++;
        }

        $start = 0;
        $end = 0;

        if (!empty($countArr)) {
            $start = $countArr[0];
            $end = end($countArr);

            $table .= '</tbody></table>';

            if ($number > 1) {
                echo $table;
            } else {
                echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">No client application found</div>';
            }
        } else {
            echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">No client application found</div>';
        }

        echo '<input data-hidden-name="start" type="hidden" value="' . $start . '">';
        echo '<input data-hidden-name="end" type="hidden" value="' . $end . '">';
    }
    public function reportsTable($dataTableParam)
    {
        $pageNumber = $dataTableParam['pageNumber'];
        $itemPerPage = $dataTableParam['itemPerPage'];
        $searchTerm = isset($dataTableParam['searchTerm']) ? $dataTableParam['searchTerm'] : "";
        $offset = ($pageNumber - 1) * $itemPerPage;
        $sortColumn = isset($dataTableParam['sortColumn']) ? $dataTableParam['sortColumn'] : "timestamp";
        $sortDirection = isset($dataTableParam['sortDirection']) ? $dataTableParam['sortDirection'] : "DESC";
        $filters = isset($dataTableParam['filters']) ? $dataTableParam['filters'] : [];
        $startDate = isset($dataTableParam['startDate']) ? $dataTableParam['startDate'] : "";
        $endDate = isset($dataTableParam['endDate']) ? $dataTableParam['endDate'] : "";
        $params = [];
        $types = "";

        if ($searchTerm) {
            $likeTerm = "%" . $searchTerm . "%";
            $conditions[] = "(transaction_id LIKE ? OR reference_id LIKE ? OR transaction_type LIKE ? OR amount_due LIKE ? OR amount_paid LIKE ? OR confirmed_by LIKE ?)";
            $params = array_merge($params, [$likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm]);
            $types .= "ssssss";
        }

        if (!empty($filters)) {
            foreach ($filters as $filter) {
                $conditions[] = "{$filter['column']} = ?";
                $params[] = $filter['value'];
                $types .= "s";
            }
        }

        if ($startDate && $endDate) {
            $conditions[] = "date BETWEEN ? AND ?";
            $params = array_merge($params, [$startDate, $endDate]);
            $types .= "ss";
        }

        if (!empty($conditions)) {
            $conditions[] = "date = CURDATE()";
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM transactions WHERE " . implode(" AND ", $conditions);
        } else {
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM transactions WHERE date = CURDATE()";
        }

        $validColumns = [
            'transaction_id', 'reference_id', 'transaction_type', 'transaction_desc', 'amount_due', 'amount_paid', 'confirmed_by', 'timestamp'
        ];
        $validDirections = ['ASC', 'DESC'];

        if (in_array($sortColumn, $validColumns) && in_array($sortDirection, $validDirections)) {
            $sql .= " ORDER BY {$sortColumn} {$sortDirection}";
        } else {
            $sql .= " ORDER BY timestamp DESC";
        }

        $sql .= " LIMIT ? OFFSET ?";
        $params = array_merge($params, [$itemPerPage, $offset]);
        $types .= "ii";



        $stmt = $this->conn->prepareStatement($sql);
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $resultCount = $this->conn->query("SELECT FOUND_ROWS() as total");

        if ($resultCount && $row = mysqli_fetch_assoc($resultCount)) {
            $totalRecords = $row['total'];
        } else {
            $totalRecords = 0;
        }
        $ascendingIcon = ' <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
    </svg>';

        $descendingIcon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
    </svg>';


        $sortIcon = $sortDirection === 'DESC' ? $ascendingIcon : $descendingIcon;
        $table = '<table class="w-full text-sm text-left text-gray-500 rounded-b-lg">

        
        <thead class="text-xs text-gray-500 uppercase">
            <tr class="bg-slate-100 border-b cursor-pointer">
                <th class="px-6 py-4" data-sortable="false">No.</th>
                <th class="px-6 py-4" data-column-name="transaction_id" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Transaction ID</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                        <span id="totalItemsSpan" class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer">
                        ' . $totalRecords . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="transaction_type" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Type</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <input id="totalItemsHidden" type="hidden" value="' . $totalRecords . '">
                <th class="px-6 py-4" data-column-name="transaction_desc" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Description</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="amount_paid" data-sortable="true">
                <div class="flex items-center gap-2">
                    <p>Amount Paid</p>
                    <span class="sort-icon">
                    ' . $sortIcon . '
                    </span>
                </div>
                </th>
                <th class="px-6 py-4" data-column-name="amount_due" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Amount Due</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="timestamp" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Created at</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="confirmed_by" data-sortable="true">
                <div class="flex items-center gap-2">
                    <p>Confirmed by</p>
                    <span class="sort-icon">
                    ' . $sortIcon . '
                    </span>
                </div>
            </th>
            </tr>
        </thead>';

        $countArr = array();
        $number = ($pageNumber - 1) * $itemPerPage + 1;

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $transactionID = $row['transaction_id'];
            $referenceID = $row['reference_id'];
            $transactionType = $row['transaction_type'];
            $description = $row['transaction_desc'];
            $amountDue = $row['amount_due'];
            $formattedAmountDue = "₱" . number_format($amountDue, 2, '.', ',');
            $amountPaid = $row['amount_paid'];
            $formattedAmountPaid = "₱" . number_format($amountPaid, 2, '.', ',');
            $confirmedBy = $row['confirmed_by'];
            $time = $row['time'];
            $date = $row['date'];

            $readable_date = date("F j, Y", strtotime($date));
            $readable_time = date("h:i A", strtotime($time));


            $table .= '<tr class="table-auto bg-white border-b border-gray-200 group hover:bg-gray-100" data-id="' . $id . '">
            <td  class="px-6 py-3 text-sm">' . $number . '</td>
            <td  class="px-6 py-3 text-sm">' . $transactionID . '</td>
            <td class="px-6 py-3 text-sm">' . $transactionType . '</td>
            <td class="px-6 py-3 text-sm" style="max-width: 20rem;">' . $description . '</td>
            <td class="px-6 py-3 text-sm">' . $formattedAmountPaid . '</td>
            <td class="px-6 py-3 text-sm">' . $formattedAmountDue . '</td>
            <td class="px-6 py-3 text-sm">            
                <span class="font-medium text-sm">' . $readable_date . '</span> </br>
                <span class="text-xs">' . $readable_time . '</span>
            </td>
            <td class="px-6 py-3 text-sm">' . $confirmedBy . '</td>


        </tr>';
            array_push($countArr, $number);
            $number++;
        }

        $start = 0;
        $end = 0;

        if (!empty($countArr)) {
            $start = $countArr[0];
            $end = end($countArr);

            $table .= '</tbody></table>';

            if ($number > 1) {
                echo $table;
            } else {
                echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">No reports found</div>';
            }
        } else {
            echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">No reports found</div>';
        }

        echo '<input data-hidden-name="start" type="hidden" value="' . $start . '">';
        echo '<input data-hidden-name="end" type="hidden" value="' . $end . '">';
    }
}
