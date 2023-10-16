<?php

namespace MeterReader\Database;

class DatabaseConnection
{
  protected $connection;

  public function __construct($host, $username, $password, $database)
  {
    $this->connection = new \mysqli($host, $username, $password, $database);

    if ($this->connection->connect_error) {
      die("Connection failed: " . $this->connection->connect_error);
    }
  }

  public function query($sql)
  {
    return $this->connection->query($sql);
  }
  public function prepareStatement($sql)
  {
    return $this->connection->prepare($sql);
  }
  public function getResultSet($stmt)
  {
    return mysqli_stmt_get_result($stmt);
  }
  public function beginTransaction()
  {
    return $this->connection->begin_transaction();
  }

  public function commitTransaction()
  {
    return $this->connection->commit();
  }

  public function rollbackTransaction()
  {
    return $this->connection->rollback();
  }


  public function closeStatement($stmt)
  {
    mysqli_stmt_close($stmt);
  }
  public function getErrorMessage()
  {
    return $this->connection->error;
  }
  public function close()
  {
    $this->connection->close();
  }
}

class BaseQuery extends DatabaseConnection
{
  public function __construct($host, $username, $password, $database)
  {
    parent::__construct($host, $username, $password, $database);
  }
}
