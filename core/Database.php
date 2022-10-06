<?php

namespace core;

use PDO;

class Database
{

  public $pdo;

  public function __construct()
  {
    try {
      $dsn = "mysql:host=localhost;dbname=myblog";
      $username = "root";
      $password = "";

      $this->pdo = new PDO($dsn, $username, $password);
    } catch (\PDOException $e) {
      echo "Connection failed " . $e->getMessage();
    }
  }
}
