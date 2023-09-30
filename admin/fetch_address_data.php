<?php
include './database/connection.php';

$sql = "SELECT * FROM `address`";
$result = $conn->query($sql);

$address_array = array();
while ($rows = mysqli_fetch_assoc($result)) {
    $address_array[] = $rows;
}

$response['address'] = $address_array;
echo json_encode($response);
