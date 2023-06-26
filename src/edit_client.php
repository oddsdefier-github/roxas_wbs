<?php
include('database.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">
</head>

<body>
    <?php
    $client_id = $_GET["client_id"];
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $new_client_name = $_POST["client_name"];
        $new_address = $_POST["address"];
        $new_property_type = $_POST["property_type"];
        $new_household_size = $_POST["household_size"];
        $new_email = $_POST["email"];
        $new_phone_number = $_POST["phone_number"];
        $edit_db = "UPDATE clients SET client_name = '$new_client_name', address = '$new_address', property_type = '$new_property_type', household_size = '$new_household_size', email = '$new_email', phone_number = '$new_phone_number' WHERE id = '$client_id'";
        if (mysqli_query($conn, $edit_db)) {
            echo "<script>alert('Record updated successfully.')</script>";
            header("Location: clients.php");
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
    $id = $_GET["client_id"];
    $sql = "SELECT * FROM clients WHERE `client_id` = '$id'";
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_fetch_assoc($result);
    $client_name = $rows["client_name"];
    $address = $rows["address"];
    $property_type = $rows["property_type"];
    $household_size = $rows["household_size"];
    $email = $rows["email"];
    $phone_number = $rows["phone_number"];
    ?>

    <form action="edit_client.php?id=<?php echo $client_id; ?>" method="POST">
        <br>
        <div>
            <label for="client_id">Client Name:</label>
            <input type="text" name="client_name" value="<?php echo $client_name; ?>">
        </div>
        <br>
        <div>
            <label for="address">Address:</label>
            <input type="text" name="address" value="<?php echo $address; ?>">
        </div>
        <br>
        <div>
            <label for="property_type">Property Type:</label>
            <input type="text" name="property_type" value="<?php echo $property_type; ?>">
        </div>
        <br>
        <div>
            <label for="household_size">Household Size:</label>
            <input type="text" name="household_size" value="<?php echo $household_size; ?>">
        </div>
        <div>
            <label for="email">Email Address:</label>
            <input type="text" name="email" value="<?php echo $email; ?>">
        </div>
        <div>
            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" value="<?php echo $phone_number; ?>">
        </div>
        <br>
        <div>
            <label for="phone_number">Status:</label>
            <input type="text" name="status" value="">
        </div>
        <br>
        <input type="submit" value="submit" name="submit">
    </form>

</body>

</html>
<?php
mysqli_close($conn);
?>