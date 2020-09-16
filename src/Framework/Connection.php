<?php

namespace Framework;

use PDOStatement;

interface Connection
{
    /**
     * @param $stmt
     * @return PDOStatement
     */
    public function query($stmt): PDOStatement;

}
