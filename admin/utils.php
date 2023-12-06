<?php

require './database/connection.php';


function getRecentRates($conn, $propertyType): array
{
    $sql = "SELECT * FROM rates WHERE rate_type = ? ORDER BY timestamp DESC LIMIT 1";
    $stmt = $conn->prepareStatement($sql);
    $stmt->bind_param("s", $propertyType);

    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row;
}
function checkRateExistence($conn, $propertyType): bool
{
    $currentMonthYear = date('F Y');
    $sql = "SELECT COUNT(*) AS count FROM rates WHERE rate_type = ? AND billing_month = ?";
    $stmt = $conn->prepareStatement($sql);
    $stmt->bind_param("ss", $propertyType, $currentMonthYear);

    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return ($row['count'] > 0);
}

function insertIntoRates($conn, $propertyType)
{
    $ratesData = getRecentRates($conn, $propertyType);

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $ratesID = "RF" . date("YmdHis") . rand(100, 999);
    $rates = $ratesData['rates'];
    $currentMonthYear = date('F Y');
    $userId = $_SESSION['user_id'];
    $referenceId = $userId;

    $sql = "INSERT into rates(rate_fee_id, rate_type, rates, billing_month, reference_id, time, date, timestamp) VALUES(?,?, ?, ?, ?, CURRENT_TIME, CURRENT_DATE, CURRENT_TIMESTAMP)";
    $stmt = $conn->prepareStatement($sql);
    $stmt->bind_param("sssss", $ratesID, $propertyType, $rates, $currentMonthYear, $referenceId);

    $stmt->execute();
    $stmt->close();

}

if (!checkRateExistence($conn, "Residential")) {
    insertIntoRates($conn, "Residential");
}
if (!checkRateExistence($conn, "Commercial")) {
    insertIntoRates($conn, "Commercial");
}
