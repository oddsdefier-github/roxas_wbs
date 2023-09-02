<?php
include('database.php');

$client_id = $_GET["client_id"];

$sql = "DELETE FROM `clients` WHERE `clients_id` = '$client_id'";

