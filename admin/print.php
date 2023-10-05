<?php

require __DIR__ . "/vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;


if (isset($_POST['data'])) {
    $data = $_POST['data'];

    $name = $data['name'];
    $address = $data['address'];
    $propertyType = $data['property_type'];
    $date = $data['date'];
    $regID = $data['registration_id'];
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

    $dompdf->stream("invoice.pdf", ["Attachment" => 0]);
    $output = $dompdf->output();

    $response = array();
    $fileName = $meterNumber . ".pdf";

    file_put_contents($fileName, $output);
}
