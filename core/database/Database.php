<?php

namespace tframe\core\database;

use PDO;
use PDOStatement;

class Database {
    public PDO $pdo;

    public function __construct ($config = []) {
        $host = 'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'];
        $username = $config['username'];
        $password = $config['password'];

        $this->pdo = new PDO($host, $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    public function query (string $sql): false|array {
        $statement = $this->prepare("$sql");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function prepare ($sql): PDOStatement {
        return $this->pdo->prepare($sql);
    }
}