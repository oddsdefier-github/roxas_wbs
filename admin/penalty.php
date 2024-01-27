<?php

include './database/connection.php';

function getLatePaymentFee($conn)
{
    $sql = "SELECT penalty_fee_id, late_payment_fee FROM penalty_fees ORDER BY timestamp DESC LIMIT 1";
    $result = $conn->query($sql);

    if (!$result) {
        echo '<script type="text/javascript">alert("Error executing the query: ' . $conn->error . '");</script>';
    }

    $row = $result->fetch_assoc();

    if (!$row) {
        echo '<script type="text/javascript">alert("No late payment fee found.");</script>';
    }

    return $row;
}


function getCurrentPenalty($conn, $billingId)
{
    $sql = "SELECT penalty FROM billing_data WHERE billing_id = '$billingId' ORDER BY timestamp DESC LIMIT 1";
    $result = $conn->query($sql);

    if (!$result) {
        echo '<script type="text/javascript">alert("Error executing the query: ' . $conn->error . '");</script>';
    }
    $row = $result->fetch_assoc();
    if (!$row) {
        echo '<script type="text/javascript">alert("No billing found.");</script>';
    }
    return $row['penalty'];
}

function setBillingPenalty($conn, $billingId)
{
    $latePaymentData = getLatePaymentFee($conn);
    $late_payment_fee = $latePaymentData['late_payment_fee'];

    $current_penalty = getCurrentPenalty($conn, $billingId);
    $total_penalty = $late_payment_fee + $current_penalty;
    $sql = "UPDATE billing_data SET penalty = ? WHERE billing_id = ?";

    $stmt = $conn->prepareStatement($sql);

    if ($stmt) {
        $stmt->bind_param("ds", $total_penalty, $billingId);
        $stmt->execute();
        $stmt->close();
    }
}

function insertIntoPenaltyLogs($conn, $billingId, $penaltyFeeId, $billingMonthAndYear, $penalty)
{
    $sql = "INSERT INTO penalty_logs (billing_id, penalty_fee_id, billing_month, penalty, time, date, timestamp) VALUES (?, ?, ?, ?, CURTIME(), CURDATE(), CURRENT_TIMESTAMP)";

    $stmt = $conn->prepareStatement($sql);
    if ($stmt) {
        $stmt->bind_param("sssd", $billingId, $penaltyFeeId, $billingMonthAndYear, $penalty);
        $stmt->execute();
        $stmt->close();
    }
}

function checkDuplicate($conn, $billingId, $billingMonthAndYear)
{
    $sql = "SELECT * FROM penalty_logs WHERE billing_id = '$billingId' AND billing_month = '$billingMonthAndYear'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return true;
    }
    return false;
}

function updateClientStatus($conn, $clientId)
{
    $sql = "UPDATE client_data SET status = 'inactive' WHERE client_id = ?";
    $stmt = $conn->prepareStatement($sql);

    if ($stmt) {
        $stmt->bind_param("s", $clientId);
        $stmt->execute();
        $stmt->close();
    }
}

function updateBillingStatusToOverdue($conn, $billingId)
{
    $sql = "UPDATE billing_data SET billing_type = 'overdue' WHERE billing_id = ?";
    $stmt = $conn->prepareStatement($sql);

    if ($stmt) {
        $stmt->bind_param("s", $billingId);
        $stmt->execute();
        $stmt->close();
    }
}
function selectDisconnectedBill($conn)
{
    $sql = "SELECT * FROM billing_data WHERE billing_status = 'unpaid' AND disconnection_date < NOW()";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // $billingId = $row['billing_id'];
            $clientId = $row['client_id'];
            updateClientStatus($conn, $clientId);
        }
    }
}

function selectUnpaidBill($conn)
{
    $sql = "SELECT * FROM billing_data WHERE billing_status = 'unpaid' AND billing_type = 'billed' AND due_date < NOW()";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $billingId = $row['billing_id'];
            $latePaymentData = getLatePaymentFee($conn);
            $penalty_fee_id = $latePaymentData['penalty_fee_id'];
            $billingMonthAndYear = $row['billing_month'];
            $late_payment_fee = $latePaymentData['late_payment_fee'];

            updateBillingStatusToOverdue($conn, $billingId);
            if (!checkDuplicate($conn, $billingId, $billingMonthAndYear)) {
                setBillingPenalty($conn, $billingId);
                insertIntoPenaltyLogs($conn, $billingId, $penalty_fee_id, $billingMonthAndYear, $late_payment_fee);
            }
        }
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'processPenalty') {
    selectUnpaidBill($conn);
    selectDisconnectedBill($conn);
    echo json_encode(array('success' => true));
    exit;
}
