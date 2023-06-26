<?php
include('database.php');

$sql = "SELECT * FROM clients";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">
</head>

<body>
    <table>
        <tr>
            <th>ClientID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Property Type</th>
            <th>Household Size</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Status</th>
            <th>Registration Date</th>
        </tr>
        <?php
        //FOR QUERY OF PRICING SCHEME
        // $currentMonth = date('m');
        // $pricing_query = "SELECT * FROM pricing_scheme WHERE MONTH(`date`) = $currentMonth";
        // $pricing_result = mysqli_query($conn, $test_query);
        // $rows = mysqli_fetch_assoc($test_result);
        // var_dump($rows);
        // $residential_rate = $rows["residential_rate"];
        // $commercial_rate = $rows["commercial_rate"];
        // $tax = $rows["tax"];
        if (mysqli_num_rows($result) > 0) {
            // $row = mysqli_fetch_assoc($result);
            // var_dump($row);
            while ($rows = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $rows["client_id"] . "</td>";
                echo "<td>" . $rows["client_name"] . "</td>";
                echo "<td>" . $rows["address"] . "</td>";
                echo "<td>" . $rows["property_type"] . "</td>";
                echo "<td>" . $rows["household_size"] . "</td>";
                echo "<td>" . $rows["email"] . "</td>";
                echo "<td>" . $rows["phone_number"] . "</td>";
                // echo "<td>" . $rows["status"] . "</td>";
                echo "<td>" . $rows["reg_date"] . "</td>";
                echo "<td>
                        <a href='edit_client.php?client_id=" . $rows["client_id"] . "'>Edit</a>
                        <a href='delete.php?id=" . $rows["client_id"] . "'>Delete</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No data available.</td></tr>";
        }
        ?>
    </table>
</body>

</html>
<?php
mysqli_close($conn);
?>