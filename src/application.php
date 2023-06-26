<?php
include('database.php');

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
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <label for="name">Name: </label>
        <input type="text" name="client_name" id="">
        <label for="address">Address: </label>
        <input type="text" name="address" id="">
        <label for="property_type">Property Type: </label> <br>
        <input type="text" name="property_type">
        <!-- <input type="radio" name="property_type" value="Commercial">Commercial <br> -->
        <label for="household_size">Household: </label>
        <input type="number" name="household_size">
        <label for="email">Email</label>
        <input type="email" name="email">
        <label for="phone">Phone No.:</label>
        <input type="text" name="phone_num">
        <input type="submit" name="submit" value="submit">
    </form>
</body>

</html>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submit"])) {
        $client_name = filter_input(INPUT_POST, "client_name", FILTER_SANITIZE_SPECIAL_CHARS);
        $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS);
        // $property_type = null;
        $property_type = $_POST["property_type"];
        // switch ($property_type) {
        //     case "Residential":
        //         echo "You selected Residential!";
        //         break;
        //     case "Commercial":
        //         echo "You selected Commercial!";
        //         break;
        //     default:
        //         echo "Please make a selection";
        // }
        $household_size = filter_input(INPUT_POST, "household_size", FILTER_SANITIZE_NUMBER_INT);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $query_email = "SELECT email FROM `clients` WHERE email = '$email'";
        $query_email_result = mysqli_query($conn, $query_email);
        if (mysqli_num_rows($query_email_result) > 0) {
            echo "Duplicated email found.";
        }
        $phone_num = filter_input(INPUT_POST, "phone_num", FILTER_SANITIZE_NUMBER_INT);

        $errors = [];
        if (empty($client_name)) {
            echo "Please enter a client_name!";
        }
        if (empty($address)) {
            echo "Please enter a address!";
        }
        if (empty($household_size)) {
            echo "Please enter a household count!";
        }
        if (empty($email)) {
            echo "Please enter a email!";
        }
        if (empty($phone_num)) {
            echo "Please enter a phone number!";
        }
        if (count($errors) === 0) {
            $sql = "INSERT INTO clients (client_name, address, property_type, household_size, email, phone_number, reg_date) VALUES ('$client_name', '$address',  '$property_type', '$household_size', '$email', '$phone_num', CURRENT_TIMESTAMP())";
            try {
                mysqli_query($conn, $sql);
                echo "You are now registered!";
            } catch (mysqli_sql_exception $e) {
                echo "Exception occurred: " . $e->getMessage();
            }
        } else {
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        }
    }
}

mysqli_close($conn);
?>