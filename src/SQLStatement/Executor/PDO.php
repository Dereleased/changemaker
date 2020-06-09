<?php

namespace Changemaker\SQLStatement\Executor;

use \PDO;
use Changemaker\SQLStatement\SQLStatementInterface;

class PDO
{
    /** @var PDO */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function select(SQLStatementInterface $query): array
    {
        
        $stmt = $this->pdo->prepare($query->getQuery());
        if ($stmt->execute($query->getParams())) {
            return $stmt->fetchAll();
        }


    }
}