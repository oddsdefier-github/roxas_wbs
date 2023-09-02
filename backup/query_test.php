<?php
include 'database.php';


$query = "SELECT client_id, client_name FROM clients";
$result = mysqli_query($conn, $query);
if ($rows = mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo $row["client_id"] . ":" . $row["client_name"] . "<br>";
    }
}

$date = "SELECT reg_date FROM clients";
$date_result = mysqli_query($conn, $date);
if ($rows = mysqli_num_rows($date_result) > 0) {
    while ($row = mysqli_fetch_assoc($date_result)) {
        var_dump($row);
        $year = date('Y', strtotime($row["reg_date"]));
        $month = date('m', strtotime($row["reg_date"]));
        $day = date('d', strtotime($row["reg_date"]));

        echo "Year: " . $year . "<br>";
        echo "Month: " . $month . "<br>";
        echo "Day: " . $day . "<br>";
    }
}
