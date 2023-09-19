<?php
include './database/connection.php';

$sql = "SELECT * FROM `address`";
$result = mysqli_query($conn, $sql);

$address_array = array();
while ($rows = mysqli_fetch_assoc($result)) {
    $address_array[] = $rows;
}

$response['Address'] = $address_array;
echo json_encode($response);
