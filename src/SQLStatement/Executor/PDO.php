<?php

namespace Changemaker\SQLStatement\Executor;

use \PDO as PDODriver;
use Changemaker\SQLStatement\SQLStatementInterface;
use Changemaker\Exception\SQLException;

class PDO
{
    /** @var PDODriver */
    protected $pdo;

    public function __construct(PDODriver $pdo)
    {
        $this->pdo = $pdo;
    }

    public function select(SQLStatementInterface $query): array
    {
        $stmt = $this->pdo->prepare($query->getQuery());
        if ($stmt->execute($query->getParams())) {
            return $stmt->fetchAll();
        }

        throw new SQLException($stmt->errorInfo());
    }
}