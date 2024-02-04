<?php

include './database/connection.php';

function countClientsByStatus($conn, $status)
{
    $validStatuses = ['active', 'inactive'];
    if (!in_array($status, $validStatuses)) {
        return false;
    }

    $sql = "SELECT COUNT(*) AS totalClients FROM client_data WHERE status = '$status'";
    $result = $conn->query($sql);

    if ($result !== false) {
        $row = $result->fetch_assoc();
        return $row['totalClients'];
    } else {
        return false;
    }
}

function countRevenue($conn, $type)
{
    $validTypes = ['application_payment', 'bill_payment'];
    if (!in_array($type, $validTypes)) {
        return false;
    }

    $sql = "SELECT SUM(amount_due) AS totalAmountPaid FROM transactions WHERE transaction_type = '$type'";
    $result = $conn->query($sql);
    if ($result !== false) {
        $row = $result->fetch_assoc();
        return $row['totalAmountPaid'];
    } else {
        return false;
    }
}

function countApplication($conn, $status)
{
    $validStatuses = ['confirmed', 'unconfirmed', 'approved'];
    if (!in_array($status, $validStatuses)) {
        return false;
    }

    $sql = "SELECT COUNT(*) AS totalApplications FROM client_application WHERE status = '$status'";
    $result = $conn->query($sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['totalApplications'];
    } else {
        return false;
    }
}

function sumConsumption($conn, $rateType)
{
    $validRateTypes = ['Commercial', 'Residential'];

    if (!in_array($rateType, $validRateTypes)) {
        return false;
    }

    $sql = "SELECT SUM(consumption) AS totalConsumption FROM billing_data 
            WHERE rate_type = '$rateType'";

    $result = $conn->query($sql);

    if ($result !== false) {
        $row = $result->fetch_assoc();
        return $row['totalConsumption'];
    } else {
        return false;
    }
}


function generateChartData($conn)
{
    $activeClients = (float) countClientsByStatus($conn, 'active');
    $inactiveClients = (float) countClientsByStatus($conn, 'inactive');
    $underReviewClients = (float) countClientsByStatus($conn, 'under_review');

    $totalClients = (float) ($activeClients + $inactiveClients);

    $applicationRevenue = (float) countRevenue($conn, 'application_payment');
    $billingRevenue = (float) countRevenue($conn, 'bill_payment');

    $totalRevenue = (float) ($applicationRevenue + $billingRevenue);

    $unconfirmedApps = (float) countApplication($conn, 'unconfirmed');
    $confirmedApps = (float) countApplication($conn, 'confirmed');
    $approvedApps = (float) countApplication($conn, 'approved');

    $totalApplications = (float) ($unconfirmedApps + $confirmedApps + $approvedApps);

    $residentialConsumption = (float) sumConsumption($conn, 'Residential');
    $commercialConsumption = (float) sumConsumption($conn, 'Commercial');

    $totalConsumption = (float) ($residentialConsumption + $commercialConsumption);

    $response = array(
        'active' => $activeClients,
        'inactive' => $inactiveClients,
        'under_review' => $underReviewClients,
        'total_clients' => $totalClients,
        'application_rev' => $applicationRevenue,
        'billing_rev' => $billingRevenue,
        'total_rev' => $totalRevenue,
        'unconfirmed_app' => $unconfirmedApps,
        'confirmed_app' => $confirmedApps,
        'approved_app' => $approvedApps,
        'total_application' => $totalApplications,
        'residential_consumption' => $residentialConsumption,
        'commercial_consumption' => $commercialConsumption,
        'total_consumption' => $totalConsumption
    );

    return $response;
}

function getRevenue($conn)
{
    $query = "SELECT DATE_FORMAT(date, '%Y-%m') AS month,
                     transaction_type,
                     SUM(amount_due) AS total_revenue
              FROM transactions
              GROUP BY month, transaction_type
              ORDER BY month ASC, transaction_type";

    $result = $conn->query($query);

    $revenueData = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $revenueData[] = [
            'month' => $row['month'],
            'transactionType' => $row['transaction_type'],
            'totalRevenue' => $row['total_revenue'],
        ];
    }
    return $revenueData;
}

function getClients($conn)
{
    $query = "SELECT brgy,
                     COUNT(*) AS total_clients
              FROM client_data
              GROUP BY brgy
              ORDER BY brgy";

    $result = $conn->query($query);

    $clientsData = [];
    while ($row = $result->fetch_assoc()) {
        $clientsData[] = [
            'brgy' => $row['brgy'],
            'totalClients' => $row['total_clients'],
        ];
    }

    return $clientsData;
}

function getConsumption($conn)
{
    $query = "SELECT DATE_FORMAT(date, '%Y-%m') AS month,
                     SUM(consumption) AS total_consumption
              FROM billing_data
              GROUP BY month
              ORDER BY month ASC";

    $result = $conn->query($query);

    $consumptionData = [];
    while ($row = $result->fetch_assoc()) {
        $consumptionData[] = [
            'month' => $row['month'],
            'totalConsumption' => $row['total_consumption'],
        ];
    }
    return $consumptionData;
}


if (isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action == 'getChartsData') {
        $generatedData = generateChartData($conn);
        echo json_encode($generatedData);
    } elseif ($action == 'getRevenue') {
        $getRevenue = getRevenue($conn);
        echo json_encode($getRevenue);
    } elseif ($action == 'getClients') {
        $getClients = getClients($conn);
        echo json_encode($getClients);
    } elseif ($action == 'getConsumption') {
        $getConsumption = getConsumption($conn);
        echo json_encode($getConsumption);
    }
}
