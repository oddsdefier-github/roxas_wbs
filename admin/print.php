<?php

use Admin\Database\DatabaseConnection;

require './database_queries.php';
require __DIR__ . "/vendor/autoload.php";



use Dompdf\Dompdf;
use Dompdf\Options;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($conn) {
        $dbConnection = new DatabaseConnection($host1, $username1, $password1, $database1);
    } else {
        echo "Database connection failed.";
    }


    $sql = "SELECT * FROM client_data WHERE reg_id = ?";
    $stmt = $dbConnection->prepareStatement($sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = $dbConnection->getResultSet($stmt);

    $clientRow = mysqli_fetch_assoc($result);
    if ($clientRow) {
        $data = $clientRow;
        $name = $data['full_name'];
        $address = $data['full_address'];
        $propertyType = $data['property_type'];
        $date = $data['date'];
        $regID = $data['reg_id'];
        $meterNumber = $data['meter_number'];

        $options = new Options;
        $options->setChroot(__DIR__);
        $options->setIsRemoteEnabled(true);
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);

        $options->set('margin-top', '0mm'); // Top margin
        $options->set('margin-right', '0mm'); // Right margin
        $options->set('margin-bottom', '0mm'); // Bottom margin
        $options->set('margin-left', '0mm'); // Left margin

        $dompdf = new Dompdf($options);

        $dompdf->setPaper("A4", "portrait");


        $html = file_get_contents("./templates/template.html");

        $html = str_replace(["{{ name }}", "{{ address }}", "{{ meter_number }}", "{{ reg_id }}", "{{ date }}", " {{ property_type }}"], [$name, $address, $meterNumber, $regID, $date, $propertyType], $html);


        $dompdf->loadHtml($html);

        $dompdf->render();

        $dompdf->addInfo("Title", "Registration");

        $fileName = $regID . ".pdf";
        $dompdf->stream($fileName, ["Attachment" => 0]);


        $output = $dompdf->output();

        $fileName = "reg_pdf/" . $regID . ".pdf";

        file_put_contents($fileName, $output);
    }

    mysqli_stmt_free_result($stmt);
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid or missing id parameter.";
}
