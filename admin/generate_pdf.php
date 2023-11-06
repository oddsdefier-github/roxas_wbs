<?php

use Admin\Database\DatabaseConnection;

require './database_queries.php';
require __DIR__ . "/vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;

class invoiceRepository
{
    protected $conn;

    public function __construct(DatabaseConnection $databaseConnection)
    {
        $this->conn = $databaseConnection;
    }
}

class GeneratePDF
{
    protected $dompdf;
    public function __construct()
    {
        $this->dompdf = new Dompdf();
    }
    public function generateInvoicePDF()
    {
        $this ->dompdf->render();
    }
}

class invoiceService {
    protected $invoiceRepo;
    protected $pdfGenerator;

    public function __construct($dbConnection)
    {

    }
}