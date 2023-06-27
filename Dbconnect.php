<?php

class DatabaseConnection
{
    private mysqli $connection;

    public function __construct(string $host, string $username, string $password, string $database)
    {
        $this->connection = new mysqli($host, $username, $password, $database);
        if ($this->connection->connect_error) {
            die("ERROR: " . $this->connection->connect_error);
        }
    }

    public function getConnection(): mysqli
    {
        return $this->connection;
    }
}

// Server, username, password, and database name
$host = "localhost";
$username = "username";
$password = "password";
$database = "DBname";

// Create a new DatabaseConnection object
$dbConnection = new DatabaseConnection($host, $username, $password, $database);

// Access the mysqli connection object
$DBcon = $dbConnection->getConnection();
?>