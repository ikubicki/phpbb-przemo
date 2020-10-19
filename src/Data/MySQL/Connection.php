<?php

namespace PhpBB\Data\MySQL;

class Connection
{

    protected $connection;

    public function __construct($dsn, $user, $pass, $options = [])
    {
        $this->connection = new \PDO($dsn, $user, $pass, $options);
    }

    public function prepare($query)
    {
        return $this->connection->prepare($query);
    }

    public function all($query, $values)
    {
        $statement = $this->prepare($query);
        $statement->execute($values);
        $results = $statement->fetchAll(\PDO::FETCH_OBJ);
        $statement->closeCursor();
        return $results;
    }

    public function one($query, $values)
    {
        $statement = $this->prepare($query);
        $statement->execute($values);
        $result = $statement->fetchObject();
        $statement->closeCursor();
        return $result;
    }

    public function value($query, $values, $index = 0)
    {
        $statement = $this->prepare($query);
        $statement->execute($values);
        $column = $statement->fetchColumn($index);
        $statement->closeCursor();
        return $column;
    }

    public static function GetDSN($dbname, $host = 'localhost', $port = 3306, $charset = 'utf8mb4')
    {
        return sprintf('mysql:dbname=%s;host=%s;port=%d;charset=%s', $dbname, $host, $port, $charset);
    }
}