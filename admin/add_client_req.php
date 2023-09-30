<?php
include './database/connection.php';

extract($_POST);

if (isset($_POST['clientAdd']) && isset($_POST['clientAddressAdd']) && isset($_POST['clientEmailAdd']) && isset($_POST['clientPropertyTypeAdd']) && isset($_POST['clientPhoneNumAdd'])) {

    $sql = "INSERT into clients (client_name, address, email, property_type, phone_number) values ('$clientAdd', '$clientAddressAdd', '$clientEmailAdd', '$clientPropertyTypeAdd', '$clientPhoneNumAdd')";

    $result = $conn->query($sql);
};
