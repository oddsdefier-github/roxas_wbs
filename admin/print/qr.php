<?php
require __DIR__ . '/vendor/autoload.php';

use Endroid\QrCode\QrCode;

// Replace '123456' with the actual invoice number or variable containing it
$invoiceNumber = '123456';

// Create a QR code instance
$qrCode = new QrCode('https://example.com/invoice/' . $invoiceNumber);
$qrCode->setSize(150); // Set the size of the QR code

// Save the QR code as an image
$qrCode->writeFile('qrcode.png');
