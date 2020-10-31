<?php

namespace PhpBB\Data\MySQL;

class Connection
{

    protected $connection;
    protected static $queries = [];

    public function __construct($dsn, $user, $pass, $options = [])
    {
        $this->connection = new \PDO($dsn, $user, $pass, $options);
    }

    public function prepare($query)
    {
        // var_dump($query);
        self::$queries[] = $query;
        return $this->connection->prepare($query);
    }

    public function all($query, $values)
    {
        $statement = $this->prepare($query);
        $statement->execute($values);
        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $results;
    }

    public function one($query, $values)
    {
        $statement = $this->prepare($query);
        $statement->execute($values);
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
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

    public function lastId()
    {
        return $this->connection->lastInsertId();
    }

    public function insert($query, $values = [])
    {
        $statement = $this->prepare($query);
        if ($statement->execute($values)) {
            $lastId = $this->lastId();
            $statement->closeCursor();
            return $lastId;
        }
        return false;
    }

    public function execute($query, $values = [])
    {
        $statement = $this->prepare($query);
        $result = $statement->execute($values);
        $statement->closeCursor();
        return $result;
    }

    public static function GetDSN($dbname, $host = 'localhost', $port = 3306, $charset = 'utf8mb4')
    {
        return sprintf('mysql:dbname=%s;host=%s;port=%d;charset=%s', $dbname, $host, $port, $charset);
    }
}