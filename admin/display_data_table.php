<?php

include './database/connection.php';

class DataTable
{
    private $conn;
    public function setConnection($databaseConnection)
    {
        $this->conn = $databaseConnection;
    }

    public function getDataTable()
    {
    }
}


if ($conn) {
    $dataTable = new DataTable();
    $dbQueries->setConnection($conn);
} else {
    echo "Database connection failed.";
}


