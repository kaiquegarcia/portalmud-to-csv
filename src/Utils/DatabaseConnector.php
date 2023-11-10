<?php

namespace Utils;

class DatabaseConnector
{
    private \mysqli $connection;

    public function __construct(
        string $host,
        string $user,
        string $password,
        string $databaseName,
        string $port,
    ) {
        $this->connection = new \mysqli($host, $user, $password, $databaseName, intval($port));
        if (mysqli_connect_errno()) {
            throw new \Exception("Could not connect to database: " . mysqli_connect_error());
        }

        $this->connection->set_charset("latin1");
    }

    public function prepare(string $query): \mysqli_stmt | false
    {
        return $this->connection->prepare($query);
    }

    public function query(string $query, ?array $params = null): \mysqli_result | false
    {
        return $this->connection->execute_query($query, $params);
    }

    public function close(): bool {
        return $this->connection->close();
    }
}
