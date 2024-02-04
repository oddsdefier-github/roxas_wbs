<?php

use Admin\Database\DatabaseConnection;

require './database_queries.php';
require __DIR__ . "/vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;

function retrieveOverdueBills($conn) {

}

function selectDisconnectedClientID($conn) {
    $sql = "SELECT client_id FROM billing_data WHERE ";
    $result = $conn->query($sql);
    $client_id = $result->fetch_assoc();
    return $client_id;
}