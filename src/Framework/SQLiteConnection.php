<?php

namespace Framework;

use PDOStatement;

class SQLiteConnection implements Connection {

    const SQLITE_FILE = '/db/blog.sqlite';
    private $pdo;

    /**
     * Connection constructor.
     */
    public function __construct()
    {
        if ($this->pdo == null) {
            $this->pdo = new \PDO("sqlite:" . dirname(__DIR__, 2) . self::SQLITE_FILE);
        }
        return $this->pdo;
    }

    /**
     * @param $stmt
     * @return PDOStatement
     */
    public function query($stmt): PDOStatement
    {
        return $this->pdo->query($stmt);
    }

    /**
     * @param $stmt
     * @return PDOStatement
     */
    public function prepare($stmt): PDOStatement
    {
        return $this->pdo->prepare($stmt);
    }

    /**
     * @return string
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}