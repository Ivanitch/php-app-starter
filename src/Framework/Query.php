<?php

namespace Framework;

/**
 * Class Query
 * @package core
 */
class Query
{
    static public $countQuery = 0;

    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getRowAsObject($query, $className, array $args)
    {
        return $this->run($query, $args)->fetchObject($className);
    }

    public function getRowAsArray($query, array $args)
    {
        return $this->run($query, $args)->fetch();
    }

    public function getRowsAsObject($query, $className, array $args = [])
    {
        return $this->run($query, $args)->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    public function getRowsAsArray($query, array $args = [])
    {
        return $this->run($query, $args)->fetchAll();
    }

    public function getColumn($query, array $args)
    {
        return $this->run($query, $args)->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function countRows($table): int
    {
        return $this->connection->query("SELECT COUNT(*) FROM {$table}")->fetchColumn();
    }

    public function getValue($query, array $args): string
    {
        $result = $this->run($query, $args)->fetch();
        if (!empty($result)) {
            $result = array_shift($result);
        }
        return $result;
    }

    public function sql($query, array $args = [])
    {
        $this->run($query, $args);
        return $this->connection->lastInsertId();
    }

    private function run($query, array $args)
    {
        if (!$args) {
            return $this->connection->query($query);
        }
        $stmt = $this->connection->prepare($query);
        $stmt->execute($args);
        self::$countQuery++;
        return $stmt;
    }
}