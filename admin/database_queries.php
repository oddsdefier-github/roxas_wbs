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

        while ($rows = mysqli_fetch_assoc($result)) {
            $response['clientData'] = $rows;
        }

        $address = "SELECT * FROM `address` ";
        $addressData = mysqli_query($this->conn, $address);
        $addressArray = array();
        while ($addressRows = mysqli_fetch_assoc($addressData)) {
            $addressArray[] = $addressRows;
        }

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
        $client_id = $_POST['updateId'];
        $client_data = $dbQueries->retrieveClientData($client_id);
        echo json_encode($client_data);
    }
}
