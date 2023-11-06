<?php

use MeterReader\Database\DatabaseConnection;

include 'config.php';
include 'Database.php';
$conn = new DatabaseConnection($host1, $username1, $password1, $database1);
// $db2 = new DatabaseConnection($host2, $username2, $password2, $database2);
