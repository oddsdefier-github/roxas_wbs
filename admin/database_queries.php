<?php

include 'database/connection.php';

class DatabaseQueries
{
    private $conn;
    public function setConnection($databaseConnection)
    {
        $this->conn = $databaseConnection;
    }

    public function retrieveClientData($clientId)
    {
        $response = array();

        $sql = "SELECT * FROM `clients` WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $clientId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $response['clientData'] = null;

        if ($clientRow = mysqli_fetch_assoc($result)) {
            $response['clientData'] = $clientRow;
        }
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);

        $addressArray = array();

        $addressSql = "SELECT * FROM `address`";
        $addressStmt = mysqli_prepare($this->conn, $addressSql);
        mysqli_stmt_execute($addressStmt);
        $addressResult = mysqli_stmt_get_result($addressStmt);


        $addressArray = array();

        while ($addressRow = mysqli_fetch_assoc($addressResult)) {
            $addressArray[] = $addressRow;
        }

        mysqli_stmt_close($addressStmt);

        $response['addressData'] = $addressArray;

        return $response;
    }


    public function updateClient()
    {
    }
    public function deleteClient()
    {
    }
}


if ($conn) {
    $dbQueries = new DatabaseQueries();
    $dbQueries->setConnection($conn);
} else {
    echo "Database connection failed.";
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'retrieveClientData') {
        if (isset($_POST['updateId'])) {
            $client_id = $_POST['updateId'];
            $client_data = $dbQueries->retrieveClientData($client_id);
            echo json_encode($client_data);
        }
    }
}
