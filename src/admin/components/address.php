<?php include './query/database.php';

$sql = "SELECT barangay FROM address";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    // Return the data as JSON
    echo json_encode($data);
} else {
    echo "No data found";
}

// Close the database connection
$conn->close();
