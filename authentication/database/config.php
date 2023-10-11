<?php
$configPath = __DIR__ . '/config.json';
$config = json_decode(file_get_contents($configPath), true);


$database1Config = $config['database1'];
$database2Config = $config['database2'];


$host1 = $database1Config['db_host'];
$username1 = $database1Config['db_user'];
$password1 = $database1Config['db_password'];
$database1 = $database1Config['db_name'];

$host2 = $database2Config['db_host'];
$username2 = $database2Config['db_user'];
$password2 = $database2Config['db_password'];
$database2 = $database2Config['db_name'];


define('BASE_URL', 'http://localhost/wbs_zero_php/');
define('HOME_URL', BASE_URL);
define('CLIENTS_URL', BASE_URL . 'admin/clients.php');
define('DASHBOARD_URL', BASE_URL . 'admin/dashboard.php');
define('CLIENTS_APPLICATION_URL', BASE_URL . 'admin/clients_application.php');
