<?php

namespace Framework;

use Exception;
use PDO;
use PDOException;
use PDOStatement;


class MySQLConnection implements Connection {

    /**
     * @var PDO
     */
    private $pdo;
    private $instance = null;

    /**
     * MySQLConnection constructor.
     * @throws Exception
     */
    public function __construct(){
        if ($this->instance === null){
            try {
                $configCon = require_once dirname(__DIR__, 2).'../config/mysql.php';
                $this->pdo = new PDO(
                    'mysql:host='.$configCon['DBHost'].';dbname='.$configCon['DBName'],
                    $configCon['DBUser'],
                    $configCon['DBPassword'],
                    $options = [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".$configCon['DBCharset']
                    ]
                );
            } catch (PDOException $e) {
                throw new Exception ($e->getMessage());
            }
        }
        return $this->instance;
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