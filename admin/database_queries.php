<?php

use Admin\Database\DatabaseConnection;

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
    public function queryApplicationFees($applicationFeeID)
    {
        $sql = "SELECT * FROM client_application_fees WHERE application_fee_id = ?";
        $stmt = $this->conn->prepareStatement($sql);

        if (!$stmt) {
            return null;
        }
        mysqli_stmt_bind_param($stmt, "s", $applicationFeeID);
        if (!mysqli_stmt_execute($stmt)) {
            return null;
        }
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row;
        }
        return null;
    }
    public function generateRegCertificate($clientID, $applicationFeeID)
    {
        $applicationFeeData = $this->queryApplicationFees($applicationFeeID);
        if ($applicationFeeData) {
            $applicationFee = $applicationFeeData['application_fee'];
            $inspectionFee = $applicationFeeData['inspection_fee'];
            $registrationFee = $applicationFeeData['registration_fee'];
            $connectionFee = $applicationFeeData['connection_fee'];
            $installationFee = $applicationFeeData['installation_fee'];

            $totalApplicationFee = intval($applicationFee) + intval($inspectionFee) + intval($registrationFee) + intval($connectionFee) + intval($installationFee);

            $formattedApplicationFee = number_format($applicationFee, 2, '.', ',');
            $formattedInspectionFee = number_format($inspectionFee, 2, '.', ',');
            $formattedRegistrationFee = number_format($registrationFee, 2, '.', ',');
            $formattedConnectionFee = number_format($connectionFee, 2, '.', ',');
            $formattedInstallationFee = number_format($installationFee, 2, '.', ',');
            $formattedTotalApplicationFee = number_format($totalApplicationFee, 2, '.', ',');
        }

        $sql = "SELECT * FROM client_data WHERE client_id = ?";
        $stmt = $this->conn->prepareStatement($sql);
        mysqli_stmt_bind_param($stmt, "s", $clientID);
        mysqli_stmt_execute($stmt);
        $result = $this->conn->getResultSet($stmt);
        $clientRow = mysqli_fetch_assoc($result);

        if ($clientRow) {
            $data = $clientRow;
            $name = $data['full_name'];
            $address = $data['full_address'];
            $propertyType = $data['property_type'];
            $date = $data['timestamp'];
            $regID = $data['reg_id'];
            $meterNumber = $data['meter_number'];

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

            $dompdf->setPaper("A4", "portrait");


            $html = file_get_contents("./templates/reg-template.html");

            $html = str_replace(["{{ name }}", "{{ address }}", "{{ meter_number }}", "{{ reg_id }}", "{{ client_id }}", "{{ date }}", "{{ property_type }}", "{{ application_fee }}", "{{ inspection_fee }}", "{{ registration_fee }}", "{{ connection_fee }}", "{{ installation_fee }}", "{{ total_application_fee }}"], [$name, $address, $meterNumber, $regID, $clientID, $date, $propertyType, $formattedApplicationFee, $formattedInspectionFee, $formattedRegistrationFee, $formattedConnectionFee, $formattedInstallationFee, $formattedTotalApplicationFee], $html);

            $dompdf->loadHtml($html);
            $dompdf->render();
            $dompdf->addInfo("Title", "Registration");

            $outputDirectory = 'temp/registration/';

            if (!is_dir($outputDirectory)) {
                mkdir($outputDirectory, 0755, true);
            }

            $filename = $regID . '.pdf';
            $filepath = $outputDirectory . $filename;

            if (file_put_contents($filepath, $dompdf->output())) {
                return [
                    'status' => 'success',
                    'filename' => $filename,
                    'path' => $filepath,
                ];
            } else {
                $errorMessage = error_get_last()['message'];
                return [
                    'status' => 'error',
                    'message' => "Failed to save PDF file. Error: $errorMessage",
                ];
            }

        }

        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
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
            $mail->Subject = 'Your Copy of Certificate of Registration';
            $mail->Body    = 'Please find your certificate attached.';

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
    public function retrieveClientData($clientID)
    {
        $response = array();
        $sql = "SELECT * FROM client_data WHERE client_id = ?";
        $stmt = $this->conn->prepareStatement($sql);
        mysqli_stmt_bind_param($stmt, "s", $clientID);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $client_data_array = array();

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($client_data_array, $row);
                }
                $response['client_data'] = $client_data_array;
            } else {
                $response['error'] = "No client found with the provided ID.";
            }
        } else {
            $response['error'] = "There was an error executing the statement.";
        }

        mysqli_stmt_close($stmt);

        return $response;
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


    public function insertIntoClientApplication($formData)
    {
        foreach ($formData as $key => $value) {
            $formData[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        extract($formData);

        $status = 'unconfirmed';
        $billingStatus = 'unpaid';

        $applicationID = 'A' . date("YmdHis");
        $sql = "INSERT INTO client_application (meter_number, first_name, middle_name, last_name, name_suffix, full_name, email, phone_number, birthdate, age, gender, property_type, street, brgy, municipality, province, region, full_address, valid_id, proof_of_ownership, deed_of_sale, affidavit, billing_status, status, application_id, time, date, timestamp ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";

        $stmt = $this->conn->prepareStatement($sql);

        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt,
                "sssssssssssssssssssssssss",
                $meterNumber,
                $firstName,
                $middleName,
                $lastName,
                $nameSuffix,
                $fullName,
                $email,
                $phoneNumber,
                $birthDate,
                $age,
                $gender,
                $propertyType,
                $streetAddress,
                $brgy,
                $municipality,
                $province,
                $region,
                $fullAddress,
                $validID,
                $proofOfOwnership,
                $deedOfSale,
                $affidavit,
                $billingStatus,
                $status,
                $applicationID
            );

            if (mysqli_stmt_execute($stmt)) {
                return true;
            } else {
                return "Error: " . mysqli_stmt_error($stmt);
            }
        } else {
            return "Error: " . $this->conn->getErrorMessage();
        }
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


    public function processClientApplication($formData)
    {
        $table = "client_application";
        $meterNumber = htmlspecialchars($formData['meterNumber'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($formData['email'], ENT_QUOTES, 'UTF-8');
        $fullName = htmlspecialchars($formData['fullName'], ENT_QUOTES, 'UTF-8');

        if ($this->checkDuplicate("meter_number", $meterNumber, $table)) {
            $response = array(
                "status" => "error",
                "message" => "Meter No: " . $meterNumber . " already exists in the database."
            );
            return $response;
        }

        if ($this->checkDuplicate("email", $email, $table)) {
            $response = array(
                "status" => "error",
                "message" => "Email: " . $email . " already exists in the database."
            );
            return $response;
        }

        if ($this->checkDuplicate("full_name", $fullName, $table)) {
            $response = array(
                "status" => "error",
                "message" => $fullName . " already exists."
            );
            return $response;
        }

        $insertResult = $this->insertIntoClientApplication($formData);
        if ($insertResult === true) {
            $response = array(
                "status" => "success",
                "message" => $fullName . "'s application has successfully processed.",
            );
            return $response;
        } else {
            $response = array(
                "status" => "error",
                "message" => $insertResult
            );
            return $response;
        }
    }

    public function fetchAddressData()
    {
        $sql = "SELECT * FROM `address`";
        $result = $this->conn->query($sql);

        $address_array = array();
        while ($rows = mysqli_fetch_assoc($result)) {
            $address_array[] = $rows;
        }
        $response['address'] = $address_array;

        return $response;
    }
    public function insertIntoClientData($formData, $clientID): bool
    {
        $this->conn->beginTransaction();
        foreach ($formData as $key => $value) {
            $formData[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        extract($formData);

        $status = "active";
        $readingStatus = "pending";

        $registrationId = 'R' . date("YmdHis");

        $sql = "INSERT INTO client_data (client_id, reg_id, meter_number, full_name, email, phone_number, birthdate, age, property_type, street, brgy, full_address, status, reading_status, application_id, time, date, timestamp ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";

        $stmt = $this->conn->prepareStatement($sql);
        mysqli_stmt_bind_param(
            $stmt,
            "sssssssssssssss",
            $clientID,
            $registrationId,
            $meterNumber,
            $fullName,
            $email,
            $phoneNumber,
            $birthDate,
            $age,
            $propertyType,
            $streetAddress,
            $brgy,
            $fullAddress,
            $status,
            $readingStatus,
            $applicationID
        );

        if (mysqli_stmt_execute($stmt)) {
            $this->conn->commitTransaction();
            $markNotificationAsRead = $this->markNotificationAsRead($applicationID);
            if (!$markNotificationAsRead) {
                return false;
            }

            $insertIntoClientSecondaryData = $this->insertIntoClientSecondaryData($formData, $clientID);
            if (!$insertIntoClientSecondaryData) {
                return false;
            }

            $insertIntoBillingData = $this->insertIntoBillingData($formData, $clientID);
            if (!$insertIntoBillingData) {
                return false;
            }

            return true;
        } else {
            $this->conn->rollbackTransaction();
            return false;
        }
    }

    public function insertIntoClientSecondaryData($formData, $clientID)
    {
        $this->conn->beginTransaction();

        foreach ($formData as $key => $value) {
            $formData[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        extract($formData);

        $status = 'approved';
        $sql = "UPDATE client_application SET status = ? WHERE application_id = ?";
        $updateStmt = $this->conn->prepareStatement($sql);
        $updateStmt->bind_param("ss", $status, $applicationID);

        if (mysqli_stmt_execute($updateStmt)) {
            $this->conn->commitTransaction();
            $insert_sec_data = "INSERT INTO client_secondary_data (client_id, first_name, middle_name, last_name, name_suffix, property_type, gender, street, brgy, municipality, province, region, valid_id, proof_of_ownership, deed_of_sale, affidavit, time, date, timestamp) VALUES (?, ?, ?, ?, ?, ?, ?,?, ?, ?,?, ?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";
            $stmt = $this->conn->prepareStatement($insert_sec_data);

            mysqli_stmt_bind_param(
                $stmt,
                "ssssssssssssssss",
                $clientID,
                $firstName,
                $middleName,
                $lastName,
                $nameSuffix,
                $propertyType,
                $gender,
                $streetAddress,
                $brgy,
                $municipality,
                $province,
                $region,
                $validID,
                $proofOfOwnership,
                $deedOfSale,
                $affidavit,
            );
            if (mysqli_stmt_execute($stmt)) {
                $this->conn->commitTransaction();
                return true;
            } else {
                $this->conn->rollbackTransaction();
                return false;
            }
        }
    }

    public function insertIntoBillingData($formData, $clientID)
    {
        $meterNumber = htmlspecialchars($formData['meterNumber'], ENT_QUOTES, 'UTF-8');

        session_start();

        $encoder = $_SESSION['user_id'];

        $billingID = "B" . time();
        $billingID = "B-" . $meterNumber . "-" . time();
        $readingType = 'current';


        $currentDate = new DateTime();
        $currentDate->setTime(0, 0, 0);
        $periodTo = clone $currentDate;
        $periodTo->modify('last day of this month');
        $periodTo = $periodTo->format('Y-m-d');

        $periodFrom = date("Y-m-d");

        $billingStatus = 'initial';
        $billingType = 'initial';


        $currentDate = new DateTime();
        $billingMonthAndYear = $currentDate->format('F Y');

        $sql_billing = "INSERT INTO billing_data (billing_id, client_id, meter_number, reading_type, billing_status, billing_type, billing_month, period_to, period_from, encoder, time, date, timestamp ) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";
        $stmt_billing = $this->conn->prepareStatement($sql_billing);
        mysqli_stmt_bind_param(
            $stmt_billing,
            "ssssssssss",
            $billingID,
            $clientID,
            $meterNumber,
            $readingType,
            $billingStatus,
            $billingType,
            $billingMonthAndYear,
            $periodFrom,
            $periodFrom,
            $encoder
        );

        if (mysqli_stmt_execute($stmt_billing)) {
            return true;
        } else {
            return "Error: " . $this->conn->getErrorMessage();
        }
    }

    public function getApplicationFeeID($applicationID)
    {
        $sql = "SELECT application_fee_id FROM client_application WHERE application_id = ?";
        $stmt = $this->conn->prepareStatement($sql);

        if (!$stmt) {
            return null;
        }

        mysqli_stmt_bind_param($stmt, "s", $applicationID);
        if  (!mysqli_stmt_execute($stmt)) {
            return null;
        }

        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['application_fee_id'];
        }
        return null;
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

    public function updateApplicationTransaction($clientID, $applicationID)
    {
        $sql = "UPDATE transactions SET client_id = ? WHERE reference_id = ?";
        $stmt = $this->conn->prepareStatement($sql);

        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("ss", $clientID, $applicationID);
        $result = $stmt->execute();

        if (!$result) {
            return false;
        }

        $stmt->close();
        return true;
    }

    public function approveClientApplication($formData)
    {
        $this->conn->beginTransaction();
        $response = array();
        $table = "client_data";
        $applicationID = htmlspecialchars($formData['applicationID'], ENT_QUOTES, 'UTF-8');
        $firstName = htmlspecialchars($formData['firstName'], ENT_QUOTES, 'UTF-8');
        $middleName = htmlspecialchars($formData['middleName'], ENT_QUOTES, 'UTF-8');
        $lastName = htmlspecialchars($formData['lastName'], ENT_QUOTES, 'UTF-8');
        $fullName = htmlspecialchars($formData['fullName'], ENT_QUOTES, 'UTF-8');
        $meterNumber = htmlspecialchars($formData['meterNumber'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($formData['email'], ENT_QUOTES, 'UTF-8');

        $totalClient = "SELECT COUNT(*) as total_clients FROM client_data";

        $query = $this->conn->query($totalClient);
        $result = mysqli_fetch_assoc($query);
        if ($result) {
            $total = $result['total_clients'];
            $total = $total + 1;
            $paddedTotal = str_pad($total, 3, '0', STR_PAD_LEFT);
        }

        $initials = $firstName[0] . $middleName[0] . $lastName[0];
        $currDate = date('mdy');
        $clientID = "WBS-" . $initials . "-" . $paddedTotal . $currDate;

        $mailData = array(
            "first_name" => $firstName,
            "last_name" => $lastName,
            "email" => $email
        );

        try {
            if ($this->checkDuplicate("meter_number", $meterNumber, $table)) {
                throw new DuplicateMeterNumberException("Meter No: ' . $meterNumber . ' already exists.");
            };
            if ($this->checkDuplicate("email", $email, $table)) {
                throw new DuplicateEmailException($email . " already exists.");
            };
            if (!$this->insertIntoClientData($formData, $clientID)) {
                throw new InsertClientDataException("Failed to insert into client data.");
            };
            if (!$this->updateApplicationTransaction($clientID, $applicationID)) {
                throw new InsertClientDataException("Failed to update application transaction.");
            };

            $this->conn->commitTransaction();

            $pdf = new PdfGenerator($this->conn);
            $wbsMailer = new WbsMailer($this->conn);

            $applicationFeeID = $this->getApplicationFeeID($formData['applicationID']);
            $regCertificateData = $pdf->generateRegCertificate($clientID, $applicationFeeID);

            if ($regCertificateData['status'] === 'success') {
                $filename = $regCertificateData['filename'];
                $filepath = $regCertificateData['path'];
                $wbsMailer->handleEmailSend($mailData, $filepath);

                $response = [
                    "status" => "success",
                    "client_id" => $clientID,
                    "filename" => $filename,
                    "filepath" => $filepath,
                    "message" => $fullName . "'s application has been approved.",
                ];
                return $response;
            }
        } catch (DuplicateMeterNumberException | DuplicateEmailException | InsertClientDataException $e) {
            $this->conn->rollbackTransaction();

            error_log("Error: " . $e->getMessage());

            $response = [
                "status" => "error",
                "message" => "Error: " . $e->getMessage(),
            ];

            return $response;

        } catch (Exception $e) {

            $this->conn->rollbackTransaction();

            error_log("Error: " . $e->getMessage());

            $response = [
                "status" => "error",
                "message" => "An unexpected error occurred.",
            ];

            return $response;
        }


    }


    public function getTotalItem($tableName, $searchTerm = "")
    {
        $total = array();

        $sql = "SELECT COUNT(*) FROM $tableName";

        if ($searchTerm) {
            $likeTerm = "%" . $searchTerm . "%";
            $sql .= " WHERE full_name LIKE ? OR meter_number LIKE ? OR street LIKE ? OR brgy LIKE ? OR property_type LIKE ? OR status LIKE ?";
        }

        $stmt = $this->conn->prepareStatement($sql);
        if ($searchTerm) {
            mysqli_stmt_bind_param($stmt, "ssssss", $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm);
        }

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_row($result)) {
            $total['totalItem'] = $row[0];
        }

        mysqli_stmt_close($stmt);

        return $total;
    }


    public function retrieveClientApplicationData($applicationID)
    {

        $data = array();
        $sql = "SELECT * FROM client_application WHERE application_id = ?";
        $stmt = $this->conn->prepareStatement($sql);
        mysqli_stmt_bind_param($stmt, "s", $applicationID);
        mysqli_stmt_execute($stmt);
        $result = $this->conn->getResultSet($stmt);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                $data['applicationData'] = $row;
            } else {
                echo "Applicant not found.";
            }
            mysqli_free_result($result);
        } else {
            echo "Error: " . $this->conn->getErrorMessage();
        }
        mysqli_stmt_close($stmt);
        return $data;
    }

    public function deleteItem($delID, $tableName)
    {
        $response = array();
        $sqlFetchName = "SELECT full_name FROM $tableName WHERE id = ?";
        $stmtName = $this->conn->prepareStatement($sqlFetchName);
        $stmtName->bind_param("i", $delID);
        if ($stmtName->execute()) {
            $result = $stmtName->get_result();
            if ($result->num_rows > 0) {
                $userData = $result->fetch_assoc();
                $response['full_name'] = $userData['full_name'];
            }
            $stmtName->close();
        } else {
            $response['error'] = "Failed to fetch user's full name.";
            return $response;
        }

        $sqlDelete = "DELETE FROM $tableName WHERE id = ?";
        try {
            $stmtDelete = $this->conn->prepareStatement($sqlDelete);
            $stmtDelete->bind_param("i", $delID);

            if (!$stmtDelete->execute()) {
                throw new Exception("Failed to delete item. " . $stmtDelete->error);
            }

            if ($stmtDelete->affected_rows == 0) {
                throw new Exception("No rows were deleted.");
            }

            $stmtDelete->close();

            $response['success'] = "Item deleted successfully!";
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
        }

        return $response;
    }

    public function getName($id, $tableName)
    {
        $sql = "SELECT full_name FROM $tableName WHERE id = ?";
        $response = array();

        try {
            $stmt = $this->conn->prepareStatement($sql);
            $stmt->bind_param("i", $id);

            if (!$stmt->execute()) {
                throw new Exception("Failed to fetch name. " . $stmt->error);
            }

            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $response['full_name'] = $row['full_name'];
            } else {
                throw new Exception("No user found with the given ID.");
            }

            $stmt->close();
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
        }

        return $response;
    }


    public function updatedClientAppStatus($applicationID, $documentsData)
    {
        $this->conn->beginTransaction();
        $response = array();
        foreach ($documentsData as $key => $value) {
            $documentsData[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        extract($documentsData);

        $sql = "UPDATE client_application SET status = 'confirmed', meter_number = ?, first_name = ?, middle_name = ?, last_name = ?, full_name = ?, name_suffix = ?, birthdate = ?, age = ?, email = ?, gender = ?, phone_number = ?, property_type = ?, street = ?, brgy = ?, full_address = ?, valid_id = ?, proof_of_ownership = ?,  deed_of_sale = ?,  affidavit = ?, billing_status = 'unpaid', timestamp = CURRENT_TIMESTAMP  WHERE application_id = ?";
        $stmt = $this->conn->prepareStatement($sql);

        $stmt->bind_param(
            'ssssssssssssssssssss',
            $meterNumber,
            $firstName,
            $middleName,
            $lastName,
            $fullName,
            $nameSuffix,
            $birthDate,
            $age,
            $email,
            $gender,
            $phoneNumber,
            $propertyType,
            $streetAddress,
            $brgy,
            $fullAddress,
            $validID,
            $proofOfOwnership,
            $deedOfSale,
            $affidavit,
            $applicationID
        );


        if ($this->checkDuplicate("email", $email, 'client_data')) {
            $this->conn->rollbackTransaction();
            $response = array(
                "status" => "error",
                "message" => "Email: " . $email . " already exists."
            );
            return $response;
        }

        if ($this->checkDuplicate("meter_number", $meterNumber, 'client_data')) {
            $this->conn->rollbackTransaction();
            $response = array(
                "status" => "error",
                "message" => "Meter No: " . $meterNumber . " already exists."
            );
            return $response;
        }

        if (!$stmt->execute()) {
            $response =  array(
                'status' => 'error',
                'message' => 'Failed to update the client application status.'
            );
            return $response;
        }

        session_start();
        $userID = $_SESSION['user_id'];
        $type = "application_confirmation";
        $message = "$fullName's application has  been confirmed.";

        if ($this->notificationExists($userID, $type, $applicationID)) {
            $this->conn->rollbackTransaction();
            $response = array(
                'status' => 'error',
                'message' => "Notification exists."
            );
            return $response;
        }
        if (!$this->addNotification($userID, $message, $type, $applicationID)) {
            $this->conn->rollbackTransaction();
            $response = array(
                'status' => 'error',
                'message' => "Failed to add notification."
            );
            return $response;
        }

        $this->conn->commitTransaction();
        $response = array(
            'status' => 'success',
            'message' => $message
        );
        return $response;
    }

    public function loadNotificationHtml($limit)
    {
        $limit = isset($_POST['limit']) ? $_POST['limit'] : 10;
        $countSql = "SELECT COUNT(*) as notificationCount FROM notifications WHERE status = 'unread' AND type = 'payment_confirmation'";

        if ($limit !== 'all') {
            $countSql .= " ORDER BY created_at DESC LIMIT $limit";
        }

        $countResult = $this->conn->query($countSql);
        $row = $countResult->fetch_assoc();
        $notifCount = $row['notificationCount'];

        $sql = "SELECT * FROM notifications WHERE status = 'unread' AND type = 'payment_confirmation' ORDER BY created_at DESC";

        if ($limit !== 'all') {
            $sql .= " LIMIT $limit";
        }

        $result = $this->conn->query($sql);

        $output = "";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $icon = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0iY3VycmVudENvbG9yIiBjbGFzcz0idy02IGgtNiIgc3R5bGU9IndpZHRoOiAxLjhyZW07IGhlaWdodDogMS44cmVtOyBjb2xvcjogIzE2YTM0YSI+DQogIDxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgZD0iTTguNjAzIDMuNzk5QTQuNDkgNC40OSAwIDAxMTIgMi4yNWMxLjM1NyAwIDIuNTczLjYgMy4zOTcgMS41NDlhNC40OSA0LjQ5IDAgMDEzLjQ5OCAxLjMwNyA0LjQ5MSA0LjQ5MSAwIDAxMS4zMDcgMy40OTdBNC40OSA0LjQ5IDAgMDEyMS43NSAxMmE0LjQ5IDQuNDkgMCAwMS0xLjU0OSAzLjM5NyA0LjQ5MSA0LjQ5MSAwIDAxLTEuMzA3IDMuNDk3IDQuNDkxIDQuNDkxIDAgMDEtMy40OTcgMS4zMDdBNC40OSA0LjQ5IDAgMDExMiAyMS43NWE0LjQ5IDQuNDkgMCAwMS0zLjM5Ny0xLjU0OSA0LjQ5IDQuNDkgMCAwMS0zLjQ5OC0xLjMwNiA0LjQ5MSA0LjQ5MSAwIDAxLTEuMzA3LTMuNDk4QTQuNDkgNC40OSAwIDAxMi4yNSAxMmMwLTEuMzU3LjYtMi41NzMgMS41NDktMy4zOTdhNC40OSA0LjQ5IDAgMDExLjMwNy0zLjQ5NyA0LjQ5IDQuNDkgMCAwMTMuNDk3LTEuMzA3em03LjAwNyA2LjM4N2EuNzUuNzUgMCAxMC0xLjIyLS44NzJsLTMuMjM2IDQuNTNMOS41MyAxMi4yMmEuNzUuNzUgMCAwMC0xLjA2IDEuMDZsMi4yNSAyLjI1YS43NS43NSAwIDAwMS4xNC0uMDk0bDMuNzUtNS4yNXoiIGNsaXAtcnVsZT0iZXZlbm9kZCIgLz4NCjwvc3ZnPg0K"; // Your SVG data
                $notificationContent = $row['message'];
                $userID = $row['user_id'];
                $referenceID = $row['reference_id'];
                $url = BASE_URL . 'admin/client_application_review.php?id=' . $referenceID;

                // Calculate time ago
                $currentDateTime = new DateTime(); // Current time
                $notificationDateTime = new DateTime($row['created_at'], new DateTimeZone('Asia/Manila'));
                $interval = $notificationDateTime->diff($currentDateTime); // Difference between the two times

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
                    <a href=\"$url\" class=\"flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700\">
                        <div class=\"flex-shrink-0\">
                            <img class=\"rounded-full w-11 h-11\" src='$icon' alt=\"Confirm Icon\">
                        </div>
                        <div class=\"w-full pl-3\">
                            <div class=\"text-gray-500 text-sm mb-1.5 dark:text-gray-400\">$notificationContent</div>
                            <div class=\"text-xs text-blue-600 dark:text-blue-500\">$timeAgo</div>
                        </div>
                    </a>
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
        $sql = "SELECT COUNT(*) as unread_count FROM notifications WHERE status = 'unread' AND type = 'payment_confirmation'";
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

    public function updateApplicationFees($formData)
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $applicationFeeID = "AF" . date("YmdHis") . rand(100, 999);
        $user_id = $_SESSION['user_id'];


        $applicationFee = filter_var($formData['applicationFee'], FILTER_VALIDATE_FLOAT);
        $inspectionFee = filter_var($formData['inspectionFee'], FILTER_VALIDATE_FLOAT);
        $installationFee = filter_var($formData['installationFee'], FILTER_VALIDATE_FLOAT);
        $registrationFee = filter_var($formData['registrationFee'], FILTER_VALIDATE_FLOAT);
        $connectionFee = filter_var($formData['connectionFee'], FILTER_VALIDATE_FLOAT);
        $reference_id = $user_id;


        $sql = "INSERT into client_application_fees(application_fee_id, application_fee, inspection_fee, registration_fee, connection_fee, installation_fee, reference_id, time, date, timestamp) VALUES(?, ?, ?, ?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";
        $stmt = $this->conn->prepareStatement($sql);

        $stmt->bind_param("sddddds", $applicationFeeID, $applicationFee, $inspectionFee, $registrationFee, $connectionFee, $installationFee, $reference_id);


        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'Application Fees are updated successfully'];
        } else {
            return ['status' => 'error', 'message' => 'Data insertion failed', 'error' => $this->conn->getErrorMessage()];
        }
    }
    public function updatePenaltyFees($formData)
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $penaltyID = "PF" . date("YmdHis") . rand(100, 999);
        $user_id = $_SESSION['user_id'];


        $latePaymentFee = filter_var($formData['latePaymentFee'], FILTER_VALIDATE_FLOAT);
        $reconnectionFee = filter_var($formData['reconnectionFee'], FILTER_VALIDATE_FLOAT);
        $reference_id = $user_id;


        $sql = "INSERT into penalty_fees(penalty_fee_id, late_payment_fee, reconnection_fee, reference_id, time, date, timestamp) VALUES( ?,?, ?,?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";
        $stmt = $this->conn->prepareStatement($sql);

        $stmt->bind_param("sdds", $penaltyID, $latePaymentFee, $reconnectionFee, $reference_id);


        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'Penalty Fees are updated successfully'];
        } else {
            return ['status' => 'error', 'message' => 'Data insertion failed', 'error' => $this->conn->getErrorMessage()];
        }
    }
    public function updateRates($formData)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $ratesID = "RF" . date("YmdHis") . rand(100, 999);
        $user_id = $_SESSION['user_id'];


        $propertyType = htmlspecialchars($formData['propertyType'], ENT_QUOTES, 'UTF-8');
        $rates = filter_var($formData['rates'], FILTER_VALIDATE_FLOAT);
        $currentMonthYear = date('F Y');
        $reference_id = $user_id;


        $sql = "INSERT into rates(rate_fee_id, rate_type, rates, billing_month, reference_id, time, date, timestamp) VALUES(?,?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";
        $stmt = $this->conn->prepareStatement($sql);

        $stmt->bind_param("ssdss", $ratesID, $propertyType, $rates, $currentMonthYear, $reference_id);

        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'Rates are updated successfully'];
        } else {
            return ['status' => 'error', 'message' => 'Data insertion failed', 'error' => $this->conn->getErrorMessage()];
        }
    }
}


class DataTable extends BaseQuery
{
    //CLIENT-APPLICATION
    public function clientApplicationTable($dataTableParam)
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

        $conditions = [];
        $params = [];
        $types = "";

        if ($searchTerm) {
            $likeTerm = "%" . $searchTerm . "%";
            $conditions[] = "(full_name LIKE ? OR application_id LIKE ? OR street LIKE ? OR brgy LIKE ? OR property_type LIKE ? OR status LIKE ? OR billing_status LIKE ?)";
            $params = array_merge($params, [$likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm]);
            $types .= "sssssss";
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
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM client_application WHERE " . implode(" AND ", $conditions);
        } else {
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM client_application";
        }


        $validColumns = [
            'application_id', 'full_name',  'property_type', 'brgy',
            'status', 'billing_status', 'timestamp'
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
            <tr class="bg-slate-100 border-b cursor-pointer">
                <th class="px-6 py-4" data-sortable="false">No.</th>
                <th class="px-6 py-4" data-column-name="application_id" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Application ID</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="full_name" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Names</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                        <span id="totalItemsSpan" class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer" >' . $totalRecords . '</span>
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
                <th class="px-6 py-4" data-column-name="status" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Status</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="billing_status" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Billing</p>
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
                <th class="px-6 py-4" data-sortable="false">Action</th>
            </tr>
        </thead>';

        $countArr = array();
        $number = ($pageNumber - 1) * $itemPerPage + 1;

        while ($row = mysqli_fetch_assoc($result)) {
            $tableName = "client_application";
            $id = $row['id'];
            $application_id = $row['application_id'];
            $name = $row['full_name'];
            $street = $row['street'];
            $brgy = $row['brgy'];
            $property_type = $row['property_type'];
            $status = $row['status'];
            $billingStatus = $row['billing_status'];
            $time = $row['time'];
            $date = $row['date'];

            $readable_date = date("F j, Y", strtotime($date));
            $readable_time = date("h:i A", strtotime($time));

            $approvedBadge = '<span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-1 rounded">
                            <span class="mr-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="fill-green-500 w-4 h-4">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            Approved 
                        </span>';

            $unconfirmedBadge = '<span class="bg-yellow-100 text-yellow-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Unconfirmed</span>';
            $confirmedBadge = '<span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Confirmed</span>';
            $statusBadge = ($status === 'approved') ? $approvedBadge : (($status === 'confirmed') ? $confirmedBadge : ($status === 'unconfirmed' ? $unconfirmedBadge : ''));


            $unpaidBillingStatusBadge = '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">Unpaid</span>';

            $paidBillingStatusBadge = '<span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">Paid</span>';



            $billingStatusBadge = $billingStatus === 'paid' ? $paidBillingStatusBadge : $unpaidBillingStatusBadge;

            $page = 'client_application_review.php';

            $table .= '<tr class="table-auto bg-white border-b border-gray-200 group hover:bg-gray-100" onclick="openPage(event, \'' . $application_id . '\', \'' . $page . '\')" data-client-id="' . $id . '" 
            class="table-auto bg-white border-b hover:bg-gray-50  overflow-auto">
            <td  class="px-6 py-3 text-sm">' . $number . '</td>
            <td class="px-6 py-3 text-sm">' . $application_id . '</td>
            <td class="px-6 py-3 text-sm font-semibold  group-hover:bg-gray-50 group-hover:text-indigo-500 group-hover:font-semibold ease-in-out duration-150">' . $name . '</td>
            <td class="px-6 py-3 text-sm">' . $property_type . '</td>
            <td class="px-6 py-3 text-sm"> 
                <span class="font-medium text-sm">' . $brgy . '</span> </br>
                <span class="text-xs text-gray-400">' . $street . '</span>
            </td>
            <td class="px-6 py-3 text-sm">' . $statusBadge . '</td>
            <td class="px-6 py-3 text-sm">' . $billingStatusBadge . '</td>
            <td class="px-6 py-3 text-sm">            
                <span class="font-medium text-sm">' . $readable_date . '</span> </br>
                <span class="text-xs">' . $readable_time . '</span>
            </td>

            <td class="flex items-center px-6 py-4 space-x-3">
                <a href="./client_application_review.php?id=' . $application_id . '" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                <span class="sr-only">Icon description</span>
                </a>
                <button  onclick="deleteClientApplication(' . $id . ', \'' . $tableName . '\')" type="button" class="delete-client text-white bg-red-700 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16px" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                <span class="sr-only">Icon description</span>
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
                echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">No client found</div>';
            }
        } else {
            echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">No client found</div>';
        }

        echo '<input data-hidden-name="start" type="hidden" value="' . $start . '">';
        echo '<input data-hidden-name="end" type="hidden" value="' . $end . '">';
    }


    public function clientTable($dataTableParam)
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
        $conditions = [];
        $params = [];
        $types = "";

        if ($searchTerm) {
            $likeTerm = "%" . $searchTerm . "%";
            $conditions[] = "(full_name LIKE ? OR client_id LIKE ? OR meter_number LIKE ? OR street LIKE ? OR brgy LIKE ? OR property_type LIKE ? OR status LIKE ?)";
            $params = array_merge($params, [$likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm]);
            $types .= "sssssss";
        }

        if (!empty($filters)) {
            foreach ($filters as $filter) {
                $conditions[] = "{$filter['column']} = ?";
                $params[] = $filter['value'];
                $types .= "s";  // Assuming all filter values are strings, adjust if not
            }
        }

        if ($startDate && $endDate) {
            $conditions[] = "date BETWEEN ? AND ?";
            $params = array_merge($params, [$startDate, $endDate]);
            $types .= "ss";  // Assuming dates are strings, adjust if not
        }

        if (!empty($conditions)) {
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM client_data WHERE " . implode(" AND ", $conditions);
        } else {
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM client_data";
        }

        $validColumns = [
            'client_id', 'meter_number', 'full_name', 'property_type', 'brgy',
            'status', 'timestamp'
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
                <th class="px-6 py-4" data-column-name="client_id" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Client ID</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="meter_number" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Meter No.</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="full_name" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Names</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                        <span id="totalItemsSpan" class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer">' . $totalRecords . '</span></th>
                    </div>
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
                <th class="px-6 py-4" data-column-name="status" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Status</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="timestamp" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Joined</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-sortable="false">Action</th>
            </tr>
        </thead>';

        $countArr = array();
        $number = ($pageNumber - 1) * $itemPerPage + 1;

        while ($row = mysqli_fetch_assoc($result)) {
            $tableName = "client_data";
            $id = $row['id'];
            $clientID = $row['client_id'];
            $meter_number = $row['meter_number'];
            $name = $row['full_name'];
            $street = $row['street'];
            $brgy = $row['brgy'];
            $property_type = $row['property_type'];
            $status = $row['status'];
            $time = $row['time'];
            $date = $row['date'];

            $readable_date = date("F j, Y", strtotime($date));
            $readable_time = date("h:i A", strtotime($time));

            switch ($status) {
                case 'active':
                    $statusBadge = '<span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                    Active
                    </span>';
                    break;
                case 'inactive':
                    $statusBadge = '<span class="inline-flex items-center bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    <span class="w-2 h-2 me-1 bg-yellow-500 rounded-full"></span>
                    Inactive
                    </span>';
                    break;
                case 'under_review':
                    $statusBadge = '<span class="inline-flex items-center bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    <span class="w-2 h-2 me-1 bg-orange-500 rounded-full"></span>
                                    Under Review
                                    </span>';
                    break;
                default:
                    $statusBadge = '';
                    break;
            }

            $table .= '<tr class="table-auto bg-white border-b border-gray-200 group hover:bg-gray-100" data-id="' . $id . '">
            <td  class="px-6 py-3 text-sm">' . $number . '</td>
            <td  class="px-6 py-3 text-sm font-semibold  group-hover:bg-gray-50 group-hover:text-indigo-500 group-hover:font-semibold ease-in-out duration-150">' . $clientID . '</td>
            <td class="px-6 py-3 text-sm">' . $meter_number . '</td>
            <td class="px-6 py-3 text-sm font-semibold  group-hover:bg-gray-50 group-hover:text-indigo-500 group-hover:font-semibold ease-in-out duration-150">' . $name . '</td>
            <td class="px-6 py-3 text-sm">' . $property_type . '</td>
            <td class="px-6 py-3 text-sm"> 
                <span class="font-medium text-sm">' . $brgy . '</span> </br>
                <span class="text-xs text-gray-400">' . $street . '</span>
            </td>
            <td class="px-6 py-3 text-sm">' . $statusBadge . '</td>
            <td class="px-6 py-3 text-sm">            
                <span class="font-medium text-sm">' . $readable_date . '</span> </br>
                <span class="text-xs">' . $readable_time . '</span>
            </td>

            <td class="flex items-center px-6 py-4 space-x-3">
                <button onclick="openViewClientModal(\'' . $clientID . '\')" type="button" title="View Client" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                <span class="sr-only">Icon description</span>
                </button>
                <button onclick="deleteClient(' . $id . ', \'' . $tableName . '\')" type="button" class="delete-client text-white bg-red-700 hover:bg-red-800 focus:ring-2 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16px" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                <span class="sr-only">Icon description</span>
                </button>

                <button  onclick="clientActions(\'' . $clientID . '\')"  class="delete-client text-gray-800 bg-gray-200 hover:bg-gray-200 focus:ring-2 focus:outline-none focus:ring-gray-200 font-medium rounded-full text-sm p-2 text-center inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                    </svg>
                
                    <span class="sr-only">Icon description</span>
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
    public function transactionTable($dataTableParam)
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
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM transactions WHERE " . implode(" AND ", $conditions);
        } else {
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM transactions";
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
                echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">No client application found</div>';
            }
        } else {
            echo '<div class="text-center text-gray-600 dark:text-gray-400 mt-4 py-10">No client application found</div>';
        }

        echo '<input data-hidden-name="start" type="hidden" value="' . $start . '">';
        echo '<input data-hidden-name="end" type="hidden" value="' . $end . '">';
    }

    public function billingTable($dataTableParam)
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

        if ($startDate && $endDate) {
            $conditions[] = "bd.date BETWEEN ? AND ?";
            $params = array_merge($params, [$startDate, $endDate]);
            $types .= "ss";
        }

        if (!empty($conditions)) {
            $sql = "SELECT SQL_CALC_FOUND_ROWS bd.*, cd.* FROM billing_data AS bd";
            $sql .= " INNER JOIN client_data AS cd ON bd.client_id = cd.client_id";
            $sql .= " WHERE bd.billing_type != 'initial' AND " . implode(" AND ", $conditions);
        } else {
            $sql = "SELECT SQL_CALC_FOUND_ROWS bd.*, cd.* FROM billing_data AS bd";
            $sql .= " INNER JOIN client_data AS cd ON bd.client_id = cd.client_id";
            $sql .= " WHERE bd.billing_type != 'initial'";
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
                <th class="px-6 py-4" data-column-name="bd.billing_status" data-sortable="true">
                <div class="flex items-center gap-2">
                    <p>Status</p>
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
            $billingStatus = $row['billing_status'];

            switch ($billingStatus) {
                case 'paid':
                    $statusBadge = '<span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-1 rounded">
                                    <span class="mr-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="fill-green-500 w-4 h-4">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                        Paid 
                                    </span>';
                    break;
                case 'unpaid':
                    $statusBadge = '<span class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-1 rounded">
                                    <span class="mr-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="fill-red-400 w-4 h-4">
                                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                        Unpaid 
                                    </span>';
                    break;
                default:
                    $statusBadge = '';
                    break;
            }
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
            <td class="px-6 py-3 text-sm">' . $statusBadge . '</td>
            <td class="px-6 py-3 text-sm">            
                <span class="font-medium text-sm">' . $readable_date . '</span> </br>
                <span class="text-xs">' . $readable_time . '</span>
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
    public function meterReportsTable($dataTableParam)
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

        $conditions = [];
        $params = [];
        $types = "";

        if ($searchTerm) {
            $likeTerm = "%" . $searchTerm . "%";
            $conditions[] = "(mr.report_id LIKE ? OR mr.client_id LIKE ? mr.issue_type LIKE ? OR mr.description LIKE ? OR cd.full_name LIKE ? OR mr.meter_number LIKE ? OR cd.property_type LIKE ? OR mr.status LIKE ?)";
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
            $conditions[] = "mr.date BETWEEN ? AND ?";
            $params = array_merge($params, [$startDate, $endDate]);
            $types .= "ss";
        }

        if (!empty($conditions)) {
            $sql = "SELECT SQL_CALC_FOUND_ROWS mr.*, cd.* FROM meter_reports AS mr";
            $sql .= " INNER JOIN client_data AS cd ON mr.client_id = cd.client_id WHERE " . implode(" AND ", $conditions);
        } else {
            $sql = "SELECT SQL_CALC_FOUND_ROWS mr.*, cd.* FROM meter_reports AS mr";
            $sql .= " INNER JOIN client_data AS cd ON mr.client_id = cd.client_id";
        }


        // echo $sql;
        // print_r($params);

        $validColumns = [
            'mr.client_id', 'mr.report_id', 'mr.issue_type','mr.description', 'cd.full_name', 'mr.meter_number','mr.status', 'cd.property_type', 'mr.timestamp'
        ];
        $validDirections = ['ASC', 'DESC'];

        if (in_array($sortColumn, $validColumns) && in_array($sortDirection, $validDirections)) {
            $sql .= " ORDER BY {$sortColumn} {$sortDirection}";
        } else {
            $sql .= " ORDER BY mr.timestamp DESC";
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
                <th class="px-6 py-4" data-column-name="mr.report_id" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Report ID</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                        <span id="totalItemsSpan" class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 cursor-pointer">' . $totalRecords . '</span>
                    </div>
                </th>
                <input id="totalItemsHidden" type="hidden" value="' . $totalRecords . '">
                <th class="px-6 py-4" data-column-name="mr.client_id" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Client ID</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="mr.meter_number" data-sortable="true">
                <div class="flex items-center gap-2">
                    <p>Meter No.</p>
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
                <th class="px-6 py-4" data-column-name="mr.issue_type" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Issue Type</p>
                        <span class="sort-icon">
                        ' . $sortIcon . '
                        </span>
                    </div>
                </th>
                <th class="px-6 py-4" data-column-name="mr.description" data-sortable="true">
                <div class="flex items-center gap-2">
                    <p>Description</p>
                    <span class="sort-icon">
                    ' . $sortIcon . '
                    </span>
                </div>
                </th>
                <th class="px-6 py-4" data-column-name="mr.status" data-sortable="true">
                <div class="flex items-center gap-2">
                    <p>Status</p>
                    <span class="sort-icon">
                    ' . $sortIcon . '
                    </span>
                </div>
                </th>
                <th class="px-6 py-4" data-column-name="mr.timestamp" data-sortable="true">
                    <div class="flex items-center gap-2">
                        <p>Date</p>
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
            $reportID = $row['report_id'];
            $clientID = $row['client_id'];
            $meterNumber = $row['meter_number'];
            $clientName = $row['full_name'];
            $issueType = $row['issue_type'];
            $description = $row['description'];
            $status = $row['status'];
            $time = $row['time'];
            $date = $row['date'];
            $readable_date = date("F j, Y", strtotime($date));
            $readable_time = date("h:i A", strtotime($time));

            $issueType = $issueType === "other" ? $row['other_specify'] : $issueType;

            $table .= '<tr class="table-auto bg-white border-b border-gray-200 group hover:bg-gray-100" data-id="' . $id . '">
            <td  class="px-6 py-3 text-sm">' . $number . '</td>
            <td  class="px-6 py-3 text-sm">' . $reportID . '</td>
            <td  class="px-6 py-3 text-sm">' . $clientID . '</td>
            <td  class="px-6 py-3 text-sm">' . $meterNumber . '</td>
            <td  class="px-6 py-3 text-sm">' . $clientName . '</td>
            <td class="px-6 py-3 text-sm">' . $issueType . '</td>
            <td  class="px-6 py-3 text-sm">' . $description . '</td>
            <td  class="px-6 py-3 text-sm">' . $status . '</td>
            <td class="px-6 py-3 text-sm">            
                <span class="font-medium text-sm">' . $readable_date . '</span> </br>
                <span class="text-xs">' . $readable_time . '</span>
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
}
